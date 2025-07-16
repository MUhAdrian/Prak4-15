<?= $this->include('templates/header'); ?>


<?php if ($artikel): ?>
  <?php foreach ($artikel as $item): ?>
    <div class="article-item">
      <h2><a href="<?= base_url('/artikel/' . $item['slug']) ?>"><?= esc($item['judul']); ?></a></h2>
      <span class="category">Kategori: <?= esc($item['nama_kategori']) ?></span>
      <p><?= esc(substr($item['isi'], 0, 150)); ?>...</p>
      <?php if (!empty($item['gambar'])): ?>
        <img src="<?= base_url('/gambar/' . $item['gambar']); ?>" alt="<?= esc($item['judul']); ?>">
      <?php endif; ?>
    </div>
    <hr class="divider" />
  <?php endforeach; ?>
<?php else: ?>
  <div class="article-item">
    <h2>Belum ada Data Artikel</h2>
    <p>Maaf, belum ada artikel yang tersedia saat ini.</p>
  </div>
<?php endif; ?>



<?= $this->include('templates/footer'); ?>
