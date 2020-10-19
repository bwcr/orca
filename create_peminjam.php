<!-- 
<?php

require_once('Connections/koneksi.php');
	$id_peminjaman = $_POST['id_peminjaman'];
	$no_induk_peminjam = $_POST['no_induk_peminjam'];
	$id_ruang = $_POST['id_ruang'];
	$tanggal_peminjaman = $_POST['tanggal_peminjaman'];
	//die(print_r($_POST));

	$query = "INSERT INTO `peminjaman_ruang` (`id_peminjaman`, `no_induk_peminjam`, `id_ruang`, `tanggal_peminjaman`) VALUES (NULL, '".$no_induk_peminjam."', '".$id_ruang."', '".$tanggal_peminjaman."'');";
	//die($query);
	$hasil = $koneksi->query($query);
	if($hasil){
		echo ("INPUT DATA BERHASIL");
		header("Location: http://localhost/miniblog/Masuk.php");
	}else{
		echo ("INPUT DATA GAGAL");
		}
	//die(print_r($koneksi));
?>
 -->