<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        return view('welcome_message');
    }

    public function portofolio()
    {
        $data['judul'] = 'Home';
        return view('portofolio', $data);
    }
}
