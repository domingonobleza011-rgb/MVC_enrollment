<?php

// Free key: https://aistudio.google.com/apikey
// Put your key in config.php (not tracked by Git).
$__cfg = require __DIR__ . '/../../config.php';
define('GEMINI_API_KEY', $__cfg['gemini_key']);
unset($__cfg);

// Free-tier models: gemini-2.5-flash (better OCR) or gemini-2.5-flash-lite (higher limits)
define('GEMINI_MODEL', 'gemini-3.8-flash');

// If the main model is overloaded or unavailable, these are tried in order.
define('GEMINI_FALLBACK_MODELS', ['gemini-3.7-flash', 'gemini-3.5-flash', 'gemini-3.1-flash-lite']);

define('AI_MAX_DOCS_PER_ANALYSIS', 6);
