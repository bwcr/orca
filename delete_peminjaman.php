<?php
session_start();

// cek sudah login atau belum
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
	header('Location: ../orca/');
	$_SESSION['errors'] = ['no_induk' => 'Silahkan Login'];
	die;
}
include 'Connections/koneksi.php';
if(isset($_SESSION['logged_in'])){
	$no_induk = $_SESSION['current_id'];

	$sql = "SELECT * FROM peminjam WHERE no_induk = '$no_induk'";
	$result = mysqli_query($koneksi, $sql);
	if(!$result){
		die("Could not query the database: <br />".mysqli_error($link));
	}
	$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
}

$id_peminjaman = $_POST['id_peminjaman'];
$tanggal = date("d F Y", strtotime($_POST['tanggal']));

$update = "UPDATE `peminjaman_ruang` SET `tanggal` = '$tanggal', `status_pesan` = '2' WHERE `peminjaman_ruang`.`id_peminjaman` = $id_peminjaman";
	//die($query);
    $hasil = $koneksi->query($update);
    echo '<script> window.history.go(-1) </script>';

?>