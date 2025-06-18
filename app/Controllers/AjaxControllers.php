<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\Request;
use CodeIgniter\HTTP\Response;
use App\Models\ArtikelModel;

class AjaxControllers extends Controller
{
  public function index()
  {
    return view('ajax/ajaxindex');
  }

  public function getData()
  {
    $models = new ArtikelModel;
    $data = $models->findAll();

    return $this->response->setJSON($data);
  }

  public function delete($id)
  {
    $models = new ArtikelModel;
    $data = $models->delete($id);
    $data = [
      'status' => 'OK'
    ];

    return $this->response->setJSON($data);
  }
}
