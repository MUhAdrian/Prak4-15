<?php

namespace App\Cell;

use CodeIgniter\View\Cell;
use App\Models\ArtikelModel;

class ArtikelTerkini extends Cell
{
  public function show(): string
  {
    $model = new ArtikelModel();
    $artikel = $model->orderBy('created_at', 'DESC')->limit(5)->findAll();

    return view('components/artikel_terkini', ['artikel' => $artikel]);
  }
}
