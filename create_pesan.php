<?php
session_start();

// cek sudah login atau belum
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
	header('Location: ../orca/');
	die;
}
require_once('Connections/koneksi.php');
	$id_ruang = $_POST['id_ruang'];
	$tanggal =  $_POST['tanggal'];
	$keterangan_pinjam = $_POST['keterangan_pinjam'];
	//die(print_r($_POST));

	$query = "INSERT INTO `peminjaman_ruang` (`no_induk`, `id_ruang`, `tanggal`, `keterangan_pinjam`, `waktu_pinjam`) VALUES ('".$_SESSION['current_id']."', '$id_ruang', '$tanggal', '$keterangan_pinjam', CURRENT_TIMESTAMP);";
	//die($query);
	$hasil = $koneksi->query($query);
	if($hasil){
		$_SESSION['success'] = 'Permintaan berhasil dikirim';
		echo '<script> window.history.go(-1) </script>';
	}else{
		echo ("INPUT DATA GAGAL");
		}
	//die(print_r($koneksi));
?>