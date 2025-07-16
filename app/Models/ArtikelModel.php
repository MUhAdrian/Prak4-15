<?php

namespace App\Models;

use CodeIgniter\Model;

class ArtikelModel extends Model
{
  protected $table = 'artikel';
  protected $primaryKey = 'id';
  protected $useAutoIncrement = true;
  protected $allowedFields = ['judul', 'isi', 'status', 'slug', 'gambar', 'id_kategori','created_at', 'updated_at'];

  protected $useTimestamps = true;
  protected $createdField  = 'created_at';
  protected $updateField  = 'updated_at';
  
  

  public function getArtikelDenganKategori()
  {
    return $this->db->table('artikel')
      ->select('artikel.*, kategori.nama_kategori')
      ->join('kategori', 'kategori.id_kategori = artikel.id_kategori', 'left')
      ->get()
      ->getResultArray();
  }
}
