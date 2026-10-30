<?php

// Free key: https://aistudio.google.com/apikey
// Paste your NEW key between the quotes (no spaces, no extra quotes).
define('GEMINI_API_KEY', 'AQ.Ab8RN6KHhnXjSdMK5gsq9lGTsu7_W5IHdjarIK7NoOEymcSvCQ');

// Free-tier models: gemini-2.5-flash (better OCR) or gemini-2.5-flash-lite (higher limits)
define('GEMINI_MODEL', 'gemini-3.8-flash');

// If the main model is overloaded or unavailable, these are tried in order.
define('GEMINI_FALLBACK_MODELS', ['gemini-3.7-flash', 'gemini-3.5-flash', 'gemini-3.1-flash-lite']);

define('AI_MAX_DOCS_PER_ANALYSIS', 6);
