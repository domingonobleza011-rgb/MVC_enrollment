<?php

class OfflineController extends Controller
{
    public function index()
    {
        $this->view('pages/offline', get_defined_vars());
    }
}
