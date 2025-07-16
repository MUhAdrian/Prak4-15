<?php

namespace App\Controllers;

class Home extends BaseController
{
  public function index(): string
  {
    $data['title'] = 'Halaman Utama';
    $data['content'] = 'Selamat datang di halaman utama website kami.';
    return view('home',$data);
  }
}
