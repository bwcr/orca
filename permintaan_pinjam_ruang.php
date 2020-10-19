<?php
	session_start();
	require_once('Connections/koneksi.php');
	if(isset($_SESSION['logged_in'])){
		$no_induk = $_SESSION['current_id'];

		$sql = "SELECT * FROM staff_pengelola WHERE no_induk = '$no_induk'";
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
	<title>Permintaan Pinjam Ruang | Order Room for Academics</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="style.css">
	
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
</head>
<body style="background-color: #EFEFEF">
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>	
	<div class="container mt-5">
	<div class="row sidebar">
			<i id="collapse" class="fas fa-bars" onclick="collapse()"></i>
			<i id="hide" class="fas fa-times" onclick="hide()"></i>
			<div id="sidebar" class="col-lg-2 text-center">
			<figure class="figure">
			<img src="<?php echo "upload/".$row['foto_profil'].""; ?>" alt="background" class="img-thumbnail shadow"><br>
				<div class="badge badge-pill badge-primary"><?php echo ''.$row['status'].''?></div> <br>
				<figcaption><?php echo ''.$row['nama'].'';?></figcaption>
				<caption><?php echo ''.$row['no_induk'].'';?></caption>
				</figure>
				<a href=permintaan_pinjam_ruang.php class="btn btn-primary btn-block mr-5">
				<i class="fas fa-door-open"></i> &nbsp;Permintaan Pinjam
						</a>
						<a href=riwayat.php class="btn btn-secondary btn-block my-2">
						<i class="fas fa-bell"></i> &nbsp; Riwayat
							</a>
							<br>
						<div class="text-left"><b style="color: #9C9C9C">PROFIL</b></div>
						<a href=ganti_password_pengelola.php class="btn btn-secondary btn-block my-2">
						<i class="fas fa-pen"></i> &nbsp; Ubah Profil
							</a>
							<a href=logout.php class="btn btn-secondary btn-block my-2">
							<i class="fas fa-sign-out-alt"></i> &nbsp; Keluar
								</a>
							</div>
		  	<div id="content" class="col-lg-10" id="konten-permintaan-pinjam">
			  <?php $query = mysqli_query($koneksi,"SELECT `peminjaman_ruang`.`id_peminjaman`,`ruang`.`id_ruang`, `ruang`.`nama_ruang`, `peminjam`.`nama`,`ruang`.`waktu_ruang`, `peminjaman_ruang`.`no_induk`, `peminjaman_ruang`.`status_pesan`, `peminjaman_ruang`.`keterangan_pinjam`, `peminjaman_ruang`.`tanggal`, `peminjaman_ruang`.`waktu_pinjam` FROM `ruang` JOIN `peminjaman_ruang` ON `ruang`.`id_ruang` = `peminjaman_ruang`.`id_ruang` JOIN `peminjam` ON `peminjaman_ruang`.`no_induk` = `peminjam`.`no_induk` WHERE `status_pesan` = 0 ORDER BY `waktu_pinjam` DESC"); ?>
		  		<h1>Permintaan Pinjam Ruang</h1>
		  		<div class="row ml-1">
				  <?php if ($query->num_rows == 0) {
					echo '<div class="jumbotron jumbotron-fluid text-center">';
					echo '<div class="container">';
					echo "<img src='https://svgshare.com/i/9Cv.svg' title='' />";
					echo '<h6 style="color: #BEBEBE">Tidak ada permintaan pinjam hari ini</h6>';
					echo '</div></div>';
					}
					  else{
						  if(mysqli_num_rows($query)){
							while ($baris = mysqli_fetch_array($query)) {
								?>
					<div class="card shadow border-light my-3 mr-3" style="width: 20rem;">
						<h6 class="card-header bg-transparent" style="font-weight: bold;"><?php echo $baris['nama'] ?><br><?php echo $baris['no_induk'] ?></h6>
							<div class="card-body text-dark">
								<h6 class="card-title"><?php echo $baris['keterangan_pinjam'] ?></h6>
								<p class="card-text">
								<i class="fas fa-calendar-alt"></i> <?php echo date("d F Y", strtotime($baris['tanggal'])); ?><br>
								<i class="fas fa-clock"></i> <?php echo $baris['waktu_ruang']; ?>
								</p>
									<div class="row">
									<span class="col-6"><?php echo date("d/m H.i", strtotime($baris['waktu_pinjam'])); ?></span>
										<div class="row col-7">
										<form method="POST" action="update_peminjaman.php">
										<input type="hidden" name="id_peminjaman" value="<?php echo $baris['id_peminjaman'] ?>">
										<button type="submit" class="btn btn-sm btn-primary"> Terima </button>
										</form>
										<form method="POST" action="delete_peminjaman.php">
										<input type="hidden" name="tanggal" value="<?php echo $baris['tanggal'] ?>">
										<button type="submit" name="id_peminjaman" value="<?php echo $baris['id_peminjaman'] ?>" class="btn btn-sm btn-link"> Tolak </button>
										</form>
										</div>
									</div>
								</div>
							</div>
							<?php }}} ?>
							</div>
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
</body>
</html>