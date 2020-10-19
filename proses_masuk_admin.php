<?php

session_start();

// cek jika sudah login
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
    die("<h1>404 PAGE NOT FOUND</h1>");
}
// cek request metod harus POST
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
 die("<h1>404 PAGE NOT FOUND</h1>");
}

// cek id dan kata_sandi tidak boleh kosong
if (!isset($_POST['no_induk']) || !isset($_POST['kata_sandi'])) {
    $_SESSION['errors'] = ['no_induk' => 'no_induk dan kata_sandi tidak boleh kosong'];
 header('Location: ../orca/index_admin.php');
 die;
}

require_once('Connections/koneksi.php');

$no_induk = filter_var($_POST['no_induk'], FILTER_SANITIZE_STRING);
$kata_sandi = filter_var($_POST['kata_sandi'], FILTER_SANITIZE_STRING);


// cek no_induk
$cekno_induk = $koneksi->query("SELECT * FROM `staff_pengelola` WHERE `no_induk` = 'admin' LIMIT 1");
if ($cekno_induk->num_rows <= 0) {
    $_SESSION['errors'] = ['no_induk' => 'Username atau Password salah'];
    header('Location: ../orca/index_admin.php');
 die;
}

$user = $cekno_induk->fetch_array();

// cek kata_sandi
if ($kata_sandi != $user['kata_sandi']) {
    $_SESSION['errors'] = ['no_induk' => 'Username atau Password salah'];
    header('Location: ../orca/index_admin.php');
 die;
}

$_SESSION['logged_in'] = TRUE;
$_SESSION['current_id'] = $user['no_induk'];
$_SESSION['current_peminjam'] = $user;

header ('location: ../orca/admin.php');

?>