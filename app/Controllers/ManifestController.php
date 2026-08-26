<?php

class ManifestController extends Controller
{
    public function index()
    {
// Serves the PWA manifest through PHP so InfinityFree's static-asset
// bot-protection (the aes.js JS challenge) doesn't intercept it.
header('Content-Type: application/manifest+json; charset=utf-8');
header('Cache-Control: public, max-age=3600');
readfile(ROOT_PATH . '/manifest.json');

    }
}
