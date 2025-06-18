<?php

namespace App\Controllers;

use App\Models\ArtikelModel;
use App\Models\KategoriModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Artikel extends BaseController
{
  public function index()
  {
    $title = 'Daftar Artikel';
    $models = new ArtikelModel();
    $artikel = $models->getArtikelDenganKategori();
    return view('artikel/index', compact('artikel', 'title'));
  }
  public function view($slug)
  {
    $model = new ArtikelModel();
    $data['artikel'] = $model->where('slug', $slug)->first();
    if (empty($data['artikel'])) {
      throw new \CodeIgniter\Exceptions\PageNotFoundException('Cannot find the article.');
    }
    $data['title'] = $data['artikel']['judul'];
    return view('artikel/detail', $data);
  }

  public function adminview($slug)
  {

    $models = new ArtikelModel();
    $artikel = $models->where([
      'slug' => $slug
    ])->first();
    if ($this->request->isAJAX()) {
      return view('admin/artikel/detail', ['artikel' => $artikel]);
    }

    if (!$artikel) {
      throw PageNotFoundException::forPageNotFound();
    }
    $title = $artikel['judul'];
    return view('artikel/detail', compact('artikel', 'title'));
  }

  public function admin_index()
  {

    $title = 'Daftar Artikel (Admin)';
    $model = new ArtikelModel();

    $q = $this->request->getVar('q') ?? '';
    $kategori_id = $this->request->getVar('kategori_id') ?? '';
    $page = $this->request->getVar('page') ?? 1;

    $builder = $model->table('artikel')
    ->select('artikel.*, kategori.nama_kategori')
    ->join('kategori', 'kategori.id_kategori = artikel.id_kategori');
  if ($q != '') {
    $builder->like('artikel.judul', $q);
  }
  if ($kategori_id != '') {
    $builder->where('artikel.id_kategori', $kategori_id);
  }
  $artikel = $builder->paginate(10, 'default', $page);
  $pager = $model->pager;
  $data = [
    'title' => $title,
    'q' => $q,
    'kategori_id' => $kategori_id,
    'artikel' => $artikel,
    'pager' => $pager
  ];

  if ($this->request->isAJAX()) {
    return $this->response->setJSON($data);
  } else {
    $kategoriModel = new KategoriModel();
    $data['kategori'] = $kategoriModel->findAll();
    return view('artikel/admin_index', $data);
  }
}

  public function add()
  { // Validation... 
    if ($this->request->getMethod() == 'post' && $this->validate([
      'judul' => 'required',
      'id_kategori' => 'required|integer' // Ensure id_kategori is 
    ])) {
      $model = new ArtikelModel();
      $model->insert([
        'judul' => $this->request->getPost('judul'),
        'isi' => $this->request->getPost('isi'),
        'slug' => url_title($this->request->getPost('judul')),
        'id_kategori' => $this->request->getPost('id_kategori')
      ]);
      return redirect()->to('/admin/artikel');
    } else {
      $kategoriModel = new KategoriModel();
      $data['kategori'] = $kategoriModel->findAll(); // Fetch categories 
      $data['title'] = "Tambah Artikel";

      return view('artikel/form_add', $data);
    }
  }

  public function edit($id)
  {
    $model = new ArtikelModel();
    if ($this->request->getMethod() == 'post' && $this->validate([
      'judul' => 'required',
      'id_kategori' => 'required|integer'
    ])) {
      $model->update($id, [
        'judul' => $this->request->getPost('judul'),
        'isi' => $this->request->getPost('isi'),
        'id_kategori' => $this->request->getPost('id_kategori')
      ]);
      return redirect()->to('/admin/artikel');
    } else {
      $data['artikel'] = $model->find($id);
      $kategoriModel = new KategoriModel();
      $data['kategori'] = $kategoriModel->findAll(); // Fetch categories  
      $data['title'] = "Edit Artikel";
      return view('artikel/form_edit', $data);
    }
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
    $models->delete($id);
    return redirect('admin/artikel');
  }
}
