<?php

// request method harus POST
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
	die("<h1>404 PAGE NOT FOUND</h1>");
}

session_start();
// die(print_r($_SESSION['current_peminjam']));
// cek login
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
	header('Location: ../orca/ganti_password_pengelola.php');
	die;
}

require_once('Connections/koneksi.php');
$user = mysqli_fetch_array($koneksi->query("SELECT * FROM `staff_pengelola` WHERE `no_induk`= '".$_SESSION['current_id']."'"));

//die(print_r($user));

$passwordlama = $_POST['pass_lama'];
$passwordbaru = $_POST['pass_baru'];
$konfirmasi = $_POST['konfirmasi'];


if ($passwordlama != $user['kata_sandi']) {
	$_SESSION['errors'] = 'Password lama yang dimasukkan salah';
	header('Location: ../orca/ganti_password_pengelola.php');
 die($_SESSION['errors']);
} elseif ($konfirmasi != $passwordbaru) {
	$_SESSION['errors'] = 'Password yang dimasukkan tidak sesuai';
	header('Location: ../orca/ganti_password_pengelola.php');
 die($_SESSION['errors']);
} elseif ($passwordbaru == $passwordlama) {
	$_SESSION['errors'] = 'Passowrd yang dimasukkan adalah password lama';
	header('Location: ../orca/ganti_password_pengelola.php');
	die($_SESSION['errors']);
}

if(empty(trim($passwordbaru))) {
	$_SESSION['errors'] = 'Password yang dimasukkan tidak mengandung karakter atau kosong';
	echo '<script> window.history.go(-1) </script>';
 	die($_SESSION['errors']);
}

$updatepassword= $koneksi->query("UPDATE `staff_pengelola` SET `kata_sandi` = '$passwordbaru' WHERE `no_induk`= '".$_SESSION['current_id']."'");
	$_SESSION['success'] = 'Password telah diganti';
	die;
header('Location: ../orca/ganti_password_pengelola.php');