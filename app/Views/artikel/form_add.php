<?= $this->include('templates/header'); ?>

<h2><?= $title; ?></h2>
<form action="" method="post" enctype="multipart/form-data">
  <p>
    <input type="text" name="judul">
  </p>
  <p>
    <textarea cols="50" name="isi" rows="10"></textarea>
  </p>
  <p>
    <label for="id_kategori">kategori</label>
    <select name="id_kategori" id="id_kategori" required>
      <?php foreach ($kategori as $k) : ?>
        <option value="<?= $k['id_kategori']; ?>"><?= $k['id_kategori']; ?></option>
      <?php endforeach; ?>
    </select>
  </p>
  <p>
    <input type="file" name="gambar">
  </p>
  <p><input type="submit" value="Kirim" class="btn btn-large" </p>
</form>

<?= $this->include('templates/footer'); ?>
