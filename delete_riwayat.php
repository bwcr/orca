<?php

// request method harus POST
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
	die("<h1>404 PAGE NOT FOUND</h1>");
}

session_start();
// die(print_r($_SESSION['current_peminjam']));
// cek login
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
	header('Location: ../orca/admin.php');
	die;
}

$id = $_POST['id_peminjaman'];

require_once('Connections/koneksi.php');
if(isset($_POST['id_peminjaman'])){
    $delete = "DELETE FROM `peminjaman_ruang` WHERE `peminjaman_ruang`.`id_peminjaman` = $id";
    $hasil = $koneksi->query($delete);
    $_SESSION['success'] = 'Berhasil Menghapus Peminjaman';
    header('Location: ../orca/riwayat_admin.php');
    die;
}

else{
	$_SESSION['errors'] = 'Terjadi kegagalan';
	echo '<script> window.location.href = "riwayat_admin.php" </script>';
	die;
}