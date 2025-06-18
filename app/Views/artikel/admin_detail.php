<?= $this->include('templates/header'); ?>


<article class="entry">
  <h2><?= $artikel['judul']; ?></h2>
  <p><?= $artikel['isi']; ?></p>
  <img src="<?= base_url('/gambar/' . $artikel['gambar']); ?>" alt="<?= $artikel['judul']; ?>">
</article>

<?= $this->include('templates/footer'); ?>
