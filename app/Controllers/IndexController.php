<?php

class IndexController extends Controller
{
    public function index()
    {
        $this->view('pages/index', get_defined_vars());
    }
}
