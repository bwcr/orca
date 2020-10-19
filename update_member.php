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
if(!is_numeric($_POST['no_induk'])){
	$_SESSION['errors'] = 'Masukkan NIM/NIP dengan angka';
	echo '<script> window.history.go(-1) </script>';
	die;
}
$check = $koneksi->query("SELECT `peminjam`.`no_induk` FROM `peminjam` WHERE `no_induk` = '".$_POST['no_induk']."' UNION SELECT `staff_pengelola`.`no_induk` FROM `staff_pengelola` WHERE `no_induk` = '".$_POST['no_induk']."'");
if($_GET['no_induk'] != $_POST['no_induk']){
if(mysqli_num_rows($check) != 0){
	$_SESSION['errors'] = 'NIM sudah terdaftar';
	echo '<script> window.history.go(-1) </script>';
	die;
}
}

if($_POST['status'] == 'Pengelola'){
		$update = $koneksi->query("UPDATE `staff_pengelola` SET `nama` = '".$_POST['nama']."' ,`no_induk` = '".$_POST['no_induk']."' , `kata_sandi` = '".$_POST['kata_sandi']."' WHERE `no_induk`= '".$_POST['no_induk']."'");
			$_SESSION['success'] = 'Profil telah diganti';
			echo '<script> window.history.go(-2) </script>';
			die;
		}
		
		if($_POST['status'] == 'Mahasiswa' || $_POST['status'] == 'Dosen'){
			$update = $koneksi->query("UPDATE `peminjam` SET `nama` = '".$_POST['nama']."' ,`no_induk` = '".$_POST['no_induk']."' , `kata_sandi` = '".$_POST['kata_sandi']."' WHERE `no_induk`= '".$_POST['no_induk']."'");
				$_SESSION['success'] = 'Profil telah diganti';
				echo '<script> window.history.go(-2) </script>';
				die;
		}


else{
	$_SESSION['errors'] = 'Terjadi Kesalahan';
	die;
	echo '<script> window.history.go(-1) </script>';
	die;
}