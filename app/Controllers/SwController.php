<?php

class SwController extends Controller
{
    public function index()
    {
// Serves the service worker through PHP so InfinityFree's static-asset
// bot-protection (the aes.js JS challenge) doesn't intercept it.
// Service-Worker-Allowed lets the worker keep scope "/" even though
// it's now served from a .php path.
header('Content-Type: application/javascript; charset=utf-8');
header('Service-Worker-Allowed: /');
header('Cache-Control: no-cache');
readfile(ROOT_PATH . '/sw.js');

    }
}
