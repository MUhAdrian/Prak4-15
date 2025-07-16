<?= $this->include('templates/header'); ?>

<h2><?= esc($title); ?></h2>

<?php if (session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger">
        <ul>
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form action="" method="post" enctype="multipart/form-data">
  <div class="mb-3">
    <label for="judul">Judul Artikel</label>
    <input type="text" name="judul" id="judul" class="form-control" value="<?= old('judul'); ?>">
  </div>
  <div class="mb-3">
    <label for="isi">Isi Artikel</label>
    <textarea name="isi" id="isi" rows="10" class="form-control"><?= old('isi'); ?></textarea>
  </div>
  <div class="mb-3">
    <label for="id_kategori">Kategori</label>
    <select name="id_kategori" id="id_kategori" class="form-control" required>
      <option value="">-- Pilih Kategori --</option>
      <?php foreach ($kategori as $k) : ?>
        <option value="<?= esc($k['id_kategori']); ?>" <?= (old('id_kategori') == $k['id_kategori']) ? 'selected' : ''; ?>>
          <?= esc($k['nama_kategori']); ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="mb-3">
    <label for="gambar">Gambar Artikel</label>
    <input type="file" name="gambar" id="gambar" class="form-control">
  </div>
  <button type="submit" class="btn btn-primary">Simpan Artikel</button>
</form>

<?= $this->include('templates/footer'); ?>
