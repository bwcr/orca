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

	$sql = "SELECT * FROM staff_pengelola WHERE no_induk = 'admin'";
	$result = mysqli_query($koneksi, $sql);
	if(!$result){
		die("Could not query the database: <br />".mysqli_error($link));
	}
	$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Pesan | Order Room for Academics</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
</head>
<body>
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>	
	<div class="container mt-5">
		<div class="row sidebar">
			<i id="collapse" class="fas fa-bars" onclick="collapse()"></i>
			<i id="hide" class="fas fa-times" onclick="hide()"></i>
			<div id="sidebar" class="col-lg-2 text-center">
				<figure class="figure">
					<img src="http://fuuse.net/wp-content/uploads/2016/02/avatar-placeholder.png" alt="background" class="img-thumbnail shadow"><br>
					<div class="badge badge-pill badge-primary"><?php echo ''.$row['status'].''?></div> <br>
					<figcaption><?php echo ''.$row['nama'].'';?></figcaption>
				</figure>
				<a href="admin.php" class="btn btn-primary btn-block mr-5">
				<i class="fas fa-user"></i> &nbsp; Kelola Peminjam
				</a>
				<a href="riwayat_admin.php" class="btn btn-secondary btn-block my-2">
					<i class="fas fa-history"></i> &nbsp; Kelola Riwayat
				</a>
				<br>
				<div class="text-left"><b style="color: #9C9C9C">PROFIL</b></div>
				<a href=logout.php class="btn btn-secondary btn-block my-2">
					<i class="fas fa-sign-out-alt"></i> &nbsp; Keluar
				</a>
			</div>
			<div id="content" class="col-lg-10">
			<h1>Tambah Peminjam</h1>
			<form role="form" method="POST" action="add_member.php">
				<div class="form-group my-3 w-50">
					<label for="nama">Nama</label>
					<input name="nama" type="text" class="form-control" required="required">
				</div>
				<div class="form-group my-3 w-50">
					<label for="no_induk">NIM/NIP</label>
					<input name="no_induk" type="text" class="form-control" required="required">
				</div>
				<div class="form-group my-3 w-50">
					<label for="kata_sandi">Password</label>
					<input name="kata_sandi" type="text" class="form-control" required="required">
				</div>
					<label for="status">Status</label><br>
					<select name="status" class="form-control w-50">
						<option disabled selected>Pilih Status</option>
						<option value="Mahasiswa">Mahasiswa</option>
						<option value="Dosen">Dosen</option>
						<option value="Pengelola">Staff Pengelola</option>
					</select><br>
				<button type="submit" value="submit" class="btn btn-primary my-2">UPDATE</button><a class="btn btn-secondary ml-2" onclick="javascript:history.go(-1);" class="btn btn-secondary ml-2">BATAL</a>
				</form>
								<script>
									function hide(){
											document.getElementById('sidebar').style.visibility = "hidden";
											document.getElementById('content').style.visibility = "visible";
											document.getElementById('collapse').style.visibility = "visible";
											document.getElementById('hide').style.visibility = "hidden";
										}
									function collapse(){
											document.getElementById('sidebar').style.visibility = "visible";
											document.getElementById('content').style.visibility = "hidden";
											document.getElementById('collapse').style.visibility = "hidden";
											document.getElementById('hide').style.visibility = "visible";
										}
								</script>
								<?php if (isset($_SESSION['errors'])){ ?>
									<div class="alert alert-danger alert-bottom alert-dismissible fade show text-center" role="alert"> 
									<?php echo $_SESSION['errors']; ?>
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
									</button>
									</div>
								<?php unset($_SESSION['errors']);} ?>
								</body>
								</html>