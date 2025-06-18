<?= $this->include('templates/header'); ?>

<?php if ($artikel): foreach ($artikel as $item): ?>

    <div class="article-item" id="hero">
      <h2<a href="<?= base_url('/artikel/detail/' . $item['judul']); ?>">
        <h2><a href="<?= base_url('/artikel/' . $item['slug']) ?>"><?= $item['judul']; ?></a></h2>
        </a>

        </h2>
        <p>Kategori: <?= $item['nama_kategori'] ?></p>
        <p><?= substr($item['isi'], 0, 100); ?></p>
        <img src="<?= base_url('/gambar/' . $item['gambar']); ?>" alt="<?= $item['judul']; ?>">
    </div>
    <hr class="divider" />
  <?php endforeach;
else: ?>
  <article class="entry">
    <h2>Belum ada Data </h2>
  </article>
<?php endif; ?>

<?= $this->include('templates/footer'); ?>
