<?php

// request method harus POST
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
	die("<h1>404 PAGE NOT FOUND</h1>");
}

session_start();
// die(print_r($_SESSION['current_peminjam']));
// cek login
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
	header('Location: ../orca/edit_member.php');
	die;
}
require_once('Connections/koneksi.php');

$check = $koneksi->query("SELECT `peminjam`.`no_induk` FROM `peminjam` WHERE `no_induk` = '".$_POST['no_induk']."' UNION SELECT `staff_pengelola`.`no_induk` FROM `staff_pengelola` WHERE `no_induk` = '".$_POST['no_induk']."'");
if(!is_numeric($_POST['no_induk'])){
	$_SESSION['errors'] = 'Masukkan NIM/NIP dengan angka';
	echo '<script> window.history.go(-1) </script>';
	die;
}

if(mysqli_num_rows($check) != 0){
	$_SESSION['errors'] = 'Peminjam sudah memiliki akun';
	echo '<script> window.history.go(-1) </script>';
	die;
}
else{
if($_POST['status'] == 'Pengelola'){
	$update = $koneksi->query("INSERT INTO `staff_pengelola` (`nama`, `no_induk`, `kata_sandi`, `status`, `foto_profil`) VALUES ('".$_POST['nama']."' , '".$_POST['no_induk']."' , '".$_POST['kata_sandi']."', '".$_POST['status']."' , 'avatar-placeholder.png')");
	$_SESSION['success'] = 'Peminjam berhasil ditambahkan';
	echo '<script> window.history.go(-2) </script>';
	die;
}

if($_POST['status'] == 'Mahasiswa' || $_POST['status'] == 'Dosen'){
	$update = $koneksi->query("INSERT INTO `peminjam` (`nama`, `no_induk`, `kata_sandi`, `status`, `foto_profil`) VALUES ('".$_POST['nama']."' , '".$_POST['no_induk']."' , '".$_POST['kata_sandi']."', '".$_POST['status']."', 'avatar-placeholder.png')");
		$_SESSION['success'] = 'Peminjam berhasil ditambahkan';
		echo '<script> window.history.go(-2) </script>';
		die;
	}
}