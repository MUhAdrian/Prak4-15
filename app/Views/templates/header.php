<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title><?= isset($title) ? $title : 'Artikel Test'; ?></title>
  <link rel="stylesheet" href="<?= base_url('/style.css'); ?>">
   <link rel="stylesheet" href="<?= base_url('/tabel.css'); ?>"> 
   <link rel="stylesheet" href="<?= base_url('/pagination.css'); ?>"> 
   <link rel="stylesheet" href="<?= base_url('/login.css'); ?>">
  <script src="<?= base_url('/assets/js/jquery-3.7.1.min.js') ?>"></script>
</head>

<body>
  <div id="container">
    <header>
      <h1>Artikel Siana</h1>
    </header>
    <nav>
      <a href="<?= base_url('/home'); ?>" class="<?= url_is('home') ? 'active' : '' ?>">Home</a>
      <a href="<?= base_url('/artikel'); ?>" class="<?= url_is('artikel*') ? 'active' : '' ?>">Artikel</a>
      <a href="<?= base_url('/about'); ?>" class="<?= url_is('about') ? 'active' : '' ?>">About</a>
      <a href="<?= base_url('/contact'); ?>" class="<?= url_is('contact') ? 'active' : '' ?>">Kontak</a>
      <a href="<?= base_url('/user/login'); ?>" class="<?= url_is('user/login') ? 'active' : '' ?>">Login Admin</a>
    </nav>
    <section id="wrapper">
      <section id="main">
        <!-- Konten utama akan dirender di sini -->
