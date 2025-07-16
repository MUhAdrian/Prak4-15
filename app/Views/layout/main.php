<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title><?= $title ?? 'My Website' ?></title>
  <link rel="stylesheet" href="<?= base_url('/style.css'); ?>">
  <!-- <link rel="stylesheet" href="<?= base_url('/tabel.css'); ?>"> -->
  <!-- <link rel="stylesheet" href="<?= base_url('/pagination.css'); ?>"> -->
  <!-- <link rel="stylesheet" href="<?= base_url('/login.css'); ?>"> -->
</head>

<body>
  <div id="container">
    <header>
      <h1>Artikel Siana</h1>
    </header>
    <nav>
      <a href="<?= base_url('/'); ?>" class="<?= url_is('/') ? 'active' : '' ?>">Home</a>
      <a href="<?= base_url('/artikel'); ?>" class="<?= url_is('artikel*') ? 'active' : '' ?>">Artikel</a>
      <a href="<?= base_url('/about'); ?>" class="<?= url_is('about') ? 'active' : '' ?>">About</a>
      <a href="<?= base_url('/contact'); ?>" class="<?= url_is('contact') ? 'active' : '' ?>">Kontak</a>
      <a href="<?= base_url('/user/login'); ?>" class="<?= url_is('user/login') ? 'active' : '' ?>">Login Admin</a>
    </nav>
    <section id="wrapper">
      <section id="main">
        <?= $this->renderSection('content') ?>
      </section>
      <aside id="sidebar">
        
        <?// view_cell('App\\Cells\\ArtikelTerkini::show') ?> 
        
        <div class="widget-box">
          <h3 class="title">Widget Header</h3>
          <ul>
            <li><a href="#">Widget Link 1</a></li>
            <li><a href="#">Widget Link 2</a></li>
            <li><a href="#">Widget Link 3</a></li>
          </ul>
        </div>
        <div class="widget-box">
          <h3 class="title">Widget Text</h3>
          <p>Vestibulum lorem elit, iaculis in nisl volutpat,
            malesuada tincidunt arcu. Proin in leo fringilla,
            vestibulum mi porta,
            faucibus felis. Integer pharetra est nunc, nec pretium
            nunc pretium ac.</p>
        </div>
      </aside>
    </section>
    
  </div>
</body>

</html>
