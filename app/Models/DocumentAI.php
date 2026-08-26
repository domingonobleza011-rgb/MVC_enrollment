<?php
/**
 * DocumentAI
 * ----------
 * Sends a student's uploaded enrollment documents (PSA birth certificate,
 * Form 137, Good Moral, Brigada Eskwela slip, 4Ps/IP certificates, etc.)
 * to Mistral AI's Chat Completions API (vision + document understanding)
 * so it can:
 *   1. Identify what each document actually is.
 *   2. Read the name printed on it.
 *   3. Flag whether that matches what the student typed into the form.
 *
 * This is an ASSISTIVE tool for registrar staff — it never auto-approves
 * or auto-rejects an enrollment. Staff always make the final call; the AI
 * result is just a flag telling them what's worth a closer look.
 */

require_once __DIR__ . '/ai_config.php';

class DocumentAI {

    /** Document types the model is asked to choose from. */
    const DOC_TYPES = [
        'PSA Birth Certificate',
        'Brigada Eskwela Commitment Slip',
        'Form 137 / Report Card',
        'Good Moral Certificate',
        'Certificate of Completion',
        '4Ps / Pantawid Pamilya Certificate or Household ID',
        'Indigenous People (IP) Certificate',
        'Other / Unclear',
        'Unreadable',
    ];

    /** Stay comfortably under a sane total request size for inline base64 uploads. */
    const MAX_INLINE_BYTES = 15 * 1024 * 1024;

    /**
     * Analyze a set of uploaded documents against the data the student
     * typed into the enrollment form.
     *
     * @param string[] $absolutePaths Absolute filesystem paths to the uploaded files.
     * @param array    $formData      Associative array of relevant form fields, e.g.
     *                                ['Full Name' => 'Dela Cruz, Juan P', 'Birthdate' => '2012-05-01']
     * @return array Structured result — always includes 'success' (bool) and 'analyzed_at'.
     */
    public static function analyze(array $absolutePaths, array $formData): array {
        $analyzedAt = date('Y-m-d H:i:s');

        if (empty($absolutePaths)) {
            return [
                'success'      => false,
                'error'        => 'No documents were uploaded to analyze.',
                'analyzed_at'  => $analyzedAt,
            ];
        }

        if (!defined('MISTRAL_API_KEY') || trim(MISTRAL_API_KEY) === '') {
            return [
                'success'     => false,
                'error'       => 'AI reviewer is not configured yet. Add your Mistral API key in app/Models/ai_config.php.',
                'analyzed_at' => $analyzedAt,
            ];
        }

        $contentBlocks = [];
        $skipped = [];
        $count = 0;
        $runningBytes = 0;

        foreach ($absolutePaths as $path) {
            if ($count >= AI_MAX_DOCS_PER_ANALYSIS) {
                $skipped[] = basename($path) . ' (over the per-record analysis limit)';
                continue;
            }
            if (!is_file($path)) {
                continue;
            }

            $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
            $mime = self::mimeForExt($ext);

            if ($mime === null) {
                $skipped[] = basename($path) . ' (.' . $ext . ' files can\'t be read by the AI reviewer — please check this one manually)';
                continue;
            }

            $rawSize = filesize($path);
            $estimatedEncodedSize = (int) ceil($rawSize * 4 / 3);
            if ($runningBytes + $estimatedEncodedSize > self::MAX_INLINE_BYTES) {
                $skipped[] = basename($path) . ' (skipped to keep the request under the AI service\'s size limit — please check this one manually)';
                continue;
            }

            $data = base64_encode(file_get_contents($path));
            $contentBlocks[] = ['type' => 'text', 'text' => 'Document file name: ' . basename($path)];

            if ($mime === 'application/pdf') {
                // PDFs go through Mistral's document_url block (built-in OCR handles it).
                $contentBlocks[] = [
                    'type'         => 'document_url',
                    'document_url' => 'data:' . $mime . ';base64,' . $data,
                ];
            } else {
                // Images go through the vision image_url block.
                $contentBlocks[] = [
                    'type'      => 'image_url',
                    'image_url' => 'data:' . $mime . ';base64,' . $data,
                ];
            }

            $runningBytes += $estimatedEncodedSize;
            $count++;
        }

        if (empty($contentBlocks)) {
            return [
                'success'     => false,
                'error'       => 'None of the uploaded documents could be read by the AI reviewer (unsupported file types or too large).',
                'skipped'     => $skipped,
                'analyzed_at' => $analyzedAt,
            ];
        }

        $formDataJson = json_encode($formData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        $contentBlocks[] = [
            'type' => 'text',
            'text' => "Here is the data the student typed into the enrollment form:\n" . $formDataJson .
                      "\n\nCompare it against what you read on the documents above and respond with the JSON object only, as instructed.",
        ];

        $payload = [
            'model'    => defined('MISTRAL_MODEL') ? MISTRAL_MODEL : 'pixtral-12b-2409',
            'messages' => [
                ['role' => 'system', 'content' => self::buildSystemPrompt()],
                ['role' => 'user', 'content' => $contentBlocks],
            ],
            'response_format' => ['type' => 'json_object'],
            'temperature'      => 0.1,
        ];

        $response = self::callMistralApi($payload);

        if (!$response['success']) {
            $response['analyzed_at'] = $analyzedAt;
            if (!empty($skipped)) $response['skipped'] = $skipped;
            return $response;
        }

        $parsed = self::extractJson($response['text']);
        if ($parsed === null) {
            return [
                'success'     => false,
                'error'       => 'The AI reviewer returned a response that could not be understood. Try re-analyzing.',
                'raw'         => $response['text'],
                'analyzed_at' => $analyzedAt,
            ];
        }

        $parsed['success']     = true;
        $parsed['analyzed_at'] = $analyzedAt;
        $parsed['model']       = defined('MISTRAL_MODEL') ? MISTRAL_MODEL : 'pixtral-12b-2409';
        if (!empty($skipped)) $parsed['skipped'] = $skipped;

        return $parsed;
    }

    /** Builds the instructions + required JSON schema for the model. */
    private static function buildSystemPrompt(): string {
        $types = implode(', ', self::DOC_TYPES);
        return <<<PROMPT
You are assisting registrar staff at a Philippine public high school in reviewing documents students uploaded during online enrollment. You are an assistive checker only — staff always make the final approve/reject decision, so surface useful flags rather than final verdicts.

For each document image/file you are shown, decide which of these types it most likely is: {$types}. Use "Unreadable" only if the file is genuinely too blurry/dark/corrupted to make out, and "Other / Unclear" if it's legible but doesn't match any listed type.

For each document, also read off the student's full name if it is visible on it. Leave the field blank if it isn't visible on that document.

NAME MATCHING (per document): Whenever a student's full name is visible anywhere on a document, compare it directly against the "Full Name" the student typed into the enrollment form. Minor formatting differences (e.g. "Dela Cruz, Juan" vs "Juan Dela Cruz", extra middle initials, capitalization) still count as a match. Set that document's "name_match" field to exactly "Matched" if the names agree, "Not Matched" if they genuinely differ, or "Not visible on this document" if no name appears on that file at all.

Respond with ONLY a single JSON object matching exactly this structure:

{
  "documents": [
    {
      "file": "string, the file name you were given",
      "detected_type": "one of the listed types",
      "confidence": "high | medium | low",
      "name": "string, the name read off the document, or empty string if not visible",
      "name_match": "Matched | Not Matched | Not visible on this document",
      "notes": "short plain-language note, e.g. image quality issues"
    }
  ],
  "overall_flag": "ok | needs_review | mismatch",
  "summary": "one or two plain-language sentences for registrar staff"
}
PROMPT;
    }

    /** Maps a file extension to a Mistral-supported MIME type, or null if unsupported. */
    private static function mimeForExt(string $ext) {
        $map = [
            'pdf'  => 'application/pdf',
            'jpg'  => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png'  => 'image/png',
            'gif'  => 'image/gif',
            'webp' => 'image/webp',
        ];
        // .doc/.docx and anything else: Mistral's inline vision/document input can't read these directly.
        return $map[$ext] ?? null;
    }

    /**
     * Calls Mistral's Chat Completions API (vision + built-in document OCR).
     * See https://docs.mistral.ai/api/endpoint/chat and
     * https://docs.mistral.ai/capabilities/vision/ for details.
     * Returns ['success'=>bool, 'text'=>string] or ['success'=>false,'error'=>string].
     */
    private static function callMistralApi(array $payload): array {
        $url = 'https://api.mistral.ai/v1/chat/completions';

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_HTTPHEADER     => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . MISTRAL_API_KEY,
            ],
            CURLOPT_POSTFIELDS     => json_encode($payload),
            CURLOPT_TIMEOUT        => 60,
            CURLOPT_CONNECTTIMEOUT => 15,
        ]);

        $body = curl_exec($ch);
        $curlErr = curl_error($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($body === false) {
            return ['success' => false, 'error' => 'Could not reach the AI service: ' . $curlErr .
                '. Note: some free hosts (e.g. InfinityFree) block outgoing HTTPS requests — check with your host if this keeps happening.'];
        }

        $decoded = json_decode($body, true);

        if ($httpCode !== 200) {
            $msg = $decoded['message']
                ?? ($decoded['error']['message'] ?? null);
            if ($msg === null) {
                // Unexpected error shape — show a trimmed snippet of the raw
                // body so it's actually debuggable instead of just "HTTP 401".
                $snippet = trim($body) === '' ? '(empty response body)' : substr(trim($body), 0, 300);
                $msg = 'HTTP ' . $httpCode . ' — ' . $snippet;
            }
            if ($httpCode === 401) {
                $msg .= ' (check that MISTRAL_API_KEY in app/Models/ai_config.php is your real key, with no extra spaces/quotes/placeholder text)';
            }
            if ($httpCode === 429) {
                $msg .= ' (free-tier rate limit reached — try again in a bit, or re-analyze this record later)';
            }
            return ['success' => false, 'error' => 'AI service error: ' . $msg];
        }

        $text = $decoded['choices'][0]['message']['content'] ?? '';
        $finishReason = $decoded['choices'][0]['finish_reason'] ?? '';

        if ($text === '' && $finishReason !== '') {
            return ['success' => false, 'error' => 'AI service returned no content (finish reason: ' . $finishReason . ').'];
        }

        if ($text === '') {
            return ['success' => false, 'error' => 'AI service returned an empty response.'];
        }

        return ['success' => true, 'text' => $text];
    }

    /** Strips stray markdown fences (if any slipped through) and decodes JSON. */
    private static function extractJson(string $text) {
        $text = trim($text);
        $text = preg_replace('/^```(?:json)?/i', '', $text);
        $text = preg_replace('/```$/', '', $text);
        $text = trim($text);

        $decoded = json_decode($text, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            return $decoded;
        }

        // Last resort: grab the outermost {...} in case the model added stray text.
        if (preg_match('/\{.*\}/s', $text, $m)) {
            $decoded = json_decode($m[0], true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                return $decoded;
            }
        }

        return null;
    }
}