<?php
session_start();
date_default_timezone_set("Asia/Jakarta");
$date = date("y-m-d");
$date1 = "20".$date;

if($_GET['tanggal'] == ""){
	header('Location: ../orca/pesan.php?tanggal=');
}

elseif($_GET['tanggal'] < $date1){
	$_SESSION['errors'] = 'Masukkan tanggal dengan benar';
    header('Location: ../orca/pesan.php?tanggal=');
 die;}
 else{
 	header('Location: ../orca/pesan.php?tanggal='.$_GET['tanggal'].'');
 }
?>