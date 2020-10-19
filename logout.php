<?php
  session_start();

  // cek jika akun sudah login maka hapus session
  if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
    session_destroy();
  }
  
  header('Location: ../orca/');
?>