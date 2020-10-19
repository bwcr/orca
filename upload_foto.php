<?php
require_once('Connections/koneksi.php');
session_start();

if(isset($_POST['but_upload'])){
 
 $name = $_FILES['file']['name'];
 $target_dir = "upload/";
 $target_file = $target_dir . basename($_FILES["file"]["name"]);

 // Select file type
 $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

 // Valid file extensions
 $extensions_arr = array("jpg","jpeg","png","gif");

 // Check extension
 if(in_array($imageFileType,$extensions_arr)){
 
  // Insert record
  $query = "UPDATE `peminjam` SET `foto_profil` = '$name' WHERE `peminjam`.`no_induk` = '".$_SESSION['current_id']."'";
  mysqli_query($koneksi,$query);
  
  // Upload file
  move_uploaded_file($_FILES['file']['tmp_name'],$target_dir.$name);
  $_SESSION['success'] = 'Upload foto berhasil';
  echo '<script> window.history.go(-1) </script>';

 }
 else{
  $_SESSION['errors'] = 'Upload foto gagal, silahkan pilih file yang lain';
  echo '<script> window.history.go(-1) </script>';
 }
 
}