<?php
	setlocale(LC_TIME, ['id_ID', 'INDONESIA']);

	$hostname="localhost";
	$username="root";
	$password="";
	$database="orca";

	$koneksi=mysqli_connect($hostname, $username, $password, $database);

	// Checking error
    if(mysqli_connect_errno()){
        die('Koneksi gagal: <br>'.mysqli_connect_error());
    }
?>
	