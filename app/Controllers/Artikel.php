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
{
    $kategoriModel = new KategoriModel();
    $data['kategori'] = $kategoriModel->findAll(); // Fetch categories 
    $data['title'] = "Tambah Artikel";

    if ($this->request->getMethod() == 'POST') {
        $rules = [
            'judul' => 'required|min_length[5]|max_length[255]',
            'isi' => 'required',
            'id_kategori' => 'required|integer',
            'gambar' => 'uploaded[gambar]|max_size[gambar,1024]|is_image[gambar]|mime_in[gambar,image/jpg,image/jpeg,image/png]',
        ];

        if ($this->validate($rules)) {
            $file = $this->request->getFile('gambar');
            $newName = $file->getRandomName(); // Generate random name for security
            $file->move(ROOTPATH . 'public/gambar', $newName);

            $model = new ArtikelModel();
            $model->insert([
                'judul' => $this->request->getPost('judul'),
                'isi' => $this->request->getPost('isi'),
                'slug' => url_title($this->request->getPost('judul'), '-', TRUE), // TRUE for lowercase
                'id_kategori' => $this->request->getPost('id_kategori'),
                'gambar' => $newName,
                // 'created_at' akan otomatis diisi jika $useTimestamps di model aktif
            ]);
            session()->setFlashdata('success', 'Artikel berhasil ditambahkan.');
            return redirect()->to('/admin/artikel');
        } else {
            return view('artikel/form_add', [
                'title' => $data['title'],
                'kategori' => $data['kategori'],
                'errors' => $this->validator->getErrors()
            ]);
        }
    }
    return view('artikel/form_add', $data);
  }


  public function edit($id)
{
    $model = new ArtikelModel();
    $artikel = $model->find($id);

    if (empty($artikel)) {
        throw new PageNotFoundException('Artikel tidak ditemukan.');
    }

    $kategoriModel = new KategoriModel();
    $data['kategori'] = $kategoriModel->findAll();
    $data['title'] = "Edit Artikel";
    $data['artikel'] = $artikel; // Pass existing article data to the view

    if ($this->request->getMethod() == 'POST') {
        $rules = [
            'judul' => 'required|min_length[5]|max_length[255]',
            'isi' => 'required',
            'id_kategori' => 'required|integer',
            // 'gambar' tidak wajib, jika tidak diupload, tidak perlu diubah
        ];

        if ($this->validate($rules)) {
            $updateData = [
                'judul' => $this->request->getPost('judul'),
                'isi' => $this->request->getPost('isi'),
                'id_kategori' => $this->request->getPost('id_kategori'),
                // 'updated_at' akan otomatis diisi jika $useTimestamps di model aktif
            ];

            // Cek jika ada gambar baru yang diupload
            $file = $this->request->getFile('gambar');
            if ($file && $file->isValid()) {
                $newName = $file->getRandomName(); // Generate random name for security
                $file->move(ROOTPATH . 'public/gambar', $newName);
                $updateData['gambar'] = $newName; // Update gambar jika ada
            }

            $model->update($id, $updateData);
            session()->setFlashdata('success', 'Artikel berhasil diubah.');
            return redirect()->to('/admin/artikel');
        } else {
            // Jika validasi gagal, kembalikan ke form dengan error
            return view('artikel/form_edit', [
                'title' => $data['title'],
                'kategori' => $data['kategori'],
                'artikel' => $artikel, // Pass existing article data again
                'errors' => $this->validator->getErrors()
            ]);
        }
    }
    return view('artikel/form_edit', $data);
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
    $artikel = $models->find($id);

    if (empty($artikel)) {
        throw new PageNotFoundException('Artikel tidak ditemukan.');
    }

    // Hapus gambar terkait jika ada
    if (!empty($artikel['gambar'])) {
        $filePath = ROOTPATH . 'public/gambar/' . $artikel['gambar'];
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }

    $models->delete($id);
    session()->setFlashdata('success', 'Artikel berhasil dihapus.');
    return redirect()->to('admin/artikel');
  }
}
