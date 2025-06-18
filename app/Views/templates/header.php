<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title><?= isset($tittle) ? $tittle : 'Artikel Test'; ?></title>
  <link rel="stylesheet" href="<?= base_url('/style.css'); ?>">
  <link rel="stylesheet" href="<?= base_url('/tabel.css'); ?>">
  <link rel="stylesheet" href="<?= base_url('/pagination.css'); ?>">
  <link rel="stylesheet" href="<?= base_url('/login.css'); ?>">
  <script src="<?= base_url('/assets/js/jquery-3.7.1.min.js') ?>"></script>
</head>


<body>
  <div id="container">
    <header>
      <h1>Layout Sederhana</h1>
    </header>
    <nav>
      <a href="<?= base_url('/'); ?>" class="active">Home</a>
      <a href="<?= base_url('/artikel'); ?>">Artikel</a>
      <a href="<?= base_url('/about'); ?>">About</a>
      <a href="<?= base_url('/contact'); ?>">Kontak</a>
    </nav>
    <section id="wrapper">
      <section id="main">
      </section>
      <aside id="sidebar">
        <!-- <div class="widget-box">
          <h3 class="title">Widget Header</h3>
          <ul>
            <li><a href="#">Widget link</a></li>
            <li><a href="#">Widget link</a></li>
          </ul>
        </div>
        <div class="widget-box">
          <h3 class="title">Widget Text</h3>
          <p>
            Content Widget
          </p>
        </div> -->
      </aside>
    </section>
</body>

</html>
