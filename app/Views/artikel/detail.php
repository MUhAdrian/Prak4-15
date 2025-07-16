<?= $this->include('templates/header'); ?>

<article class="entry">
  <h2><?= esc($artikel['judul']); ?></h2>
  <?php if (!empty($artikel['gambar'])): ?>
    <img src="<?= base_url('/gambar/' . $artikel['gambar']); ?>" alt="<?= esc($artikel['judul']); ?>">
  <?php endif; ?>
  <p><?= nl2br(esc($artikel['isi'])); ?></p>
</article>


<?= $this->include('templates/footer'); ?>
