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
require_once('Connections/koneksi.php');
$user = mysqli_fetch_array($koneksi->query("SELECT `no_induk`,`nama`,`status`,`last_login`, `kata_sandi` FROM `peminjam` WHERE `no_induk` NOT IN ('".$_POST['no_induk']."') UNION SELECT `no_induk`,`nama`,`status`,`last_login`, `kata_sandi` FROM `staff_pengelola` WHERE `no_induk` NOT IN ('".$_POST['no_induk']."')"));

if($_POST['status'] == 'Pengelola'){
$update = $koneksi->query("DELETE FROM `staff_pengelola` WHERE `nama` = '".$_POST['nama']."' AND `no_induk` = '".$_POST['no_induk']."'");
	$_SESSION['success'] = 'Peminjam berhasil dihapus';
	echo '<script> window.location.href = "admin.php" </script>';
	die;
}

if($_POST['status'] == 'Mahasiswa' || $_POST['status'] == 'Dosen'){
	$update = $koneksi->query("DELETE FROM `peminjam` WHERE `nama` = '".$_POST['nama']."' AND `no_induk` = '".$_POST['no_induk']."'");
		$_SESSION['success'] = 'Peminjam berhasil dihapus';
		echo '<script> window.location.href = "admin.php" </script>';
		die;
	}

else{
	$_SESSION['errors'] = 'Terjadi kegagalan';
	die;
	echo '<script> window.location.href = "admin.php" </script>';
	die;
}