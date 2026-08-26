<?php
/**
 * AI Document Reviewer — configuration.
 *
 * Uses Mistral AI's Chat Completions API (vision model, with built-in
 * document OCR for PDFs) instead of Google Gemini. We switched off Gemini
 * because Google AI Studio's current API keys ("AQ." auth keys) are
 * broken for plain REST calls, and the Vertex AI fallback required a
 * credit card on this account. Mistral has a genuine no-credit-card free
 * tier.
 *
 * Get a key (no card needed):
 *   1. Go to https://console.mistral.ai
 *   2. Sign up / sign in
 *   3. Go to "API Keys" and create a new key
 *   4. Paste it below
 *
 * Heads up: on the free tier, Google-style "may train on your data" terms
 * don't automatically apply here, but always check Mistral's current
 * terms at https://mistral.ai/terms before sending student documents —
 * these are scans of PSA/Form 137 records.
 */

define('MISTRAL_API_KEY', '7Qflw0DqGkXtnbNuKhtsjkyb8l2ci4mc');

// pixtral-12b-2409 is Mistral's openly-licensed (Apache 2.0) vision model —
// unlike pixtral-large, which sits under a Research License and isn't
// enabled by default on fresh free-tier keys (you'll get "Invalid model"
// if you try it before requesting access). If you ever get access to
// pixtral-large and want the stronger model, or want to try
// "mistral-small-latest" (also vision-capable), check
// https://docs.mistral.ai/guides/model-selection/ for the current lineup —
// Mistral renames/replaces these periodically.
define('MISTRAL_MODEL', 'pixtral-12b-2409');

// Hard cap on how many documents get sent to the AI per enrollment record
// (keeps requests fast and keeps the total base64 payload reasonable;
// extra files are left unanalyzed with a note so staff know to check them
// manually).
define('AI_MAX_DOCS_PER_ANALYSIS', 6);
