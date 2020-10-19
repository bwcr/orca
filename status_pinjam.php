<?php
session_start();
	// cek sudah login atau belum
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
	header('Location: ../orca/');
	$_SESSION['errors'] = ['no_induk' => 'Silahkan Login'];
	die;
}
require_once('Connections/koneksi.php');
if(isset($_SESSION['logged_in'])){
	$no_induk = $_SESSION['current_id'];

	$sql = "SELECT * FROM peminjam WHERE no_induk = '$no_induk'";
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
	<title>Status Pinjam | Order Room for Academics</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
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
					<img src="<?php echo "upload/".$row['foto_profil'].""; ?>" alt="background" class="img-thumbnail shadow"><br>
					<div class="badge badge-pill badge-primary"><?php echo ''.$row['status'].''?></div> <br>
					<figcaption><?php echo ''.$row['nama'].'';?></figcaption>
					<caption><?php echo ''.$row['no_induk'].'';?></caption>
				</figure>
				<a href="pesan.php?tanggal=" class="btn btn-secondary btn-block mr-5">
					<i class="fas fa-door-open"></i> &nbsp;Pinjam Ruang Sidang
				</a>
				<a href=status_pinjam.php class="btn btn-primary btn-block my-2">
					<i class="fas fa-bell"></i> &nbsp; Status Pinjam
				</a>
				<br>
				<div class="text-left"><b style="color: #9C9C9C">PROFIL</b></div>
				<a href=ganti_password.php class="btn btn-secondary btn-block my-2">
					<i class="fas fa-pen"></i> &nbsp; Ubah Profil
				</a>
				<a href=logout.php class="btn btn-secondary btn-block my-2">
					<i class="fas fa-sign-out-alt"></i> &nbsp; Keluar
				</a>
			</div>

			<!--Konten-->
			<div id="content" class="col-lg-10" id="konten-status-pinjam">
				<h1>Status Pinjam</h1>
				<?php
				$query = mysqli_query($koneksi,"SELECT `ruang`.`id_ruang`, `ruang`.`nama_ruang`, `ruang`.`waktu_ruang`, `peminjaman_ruang`.`no_induk`, `peminjaman_ruang`.`status_pesan`, `peminjaman_ruang`.`keterangan_pinjam`, `peminjaman_ruang`.`tanggal`, `peminjaman_ruang`.`waktu_pinjam` FROM `ruang` JOIN `peminjaman_ruang` ON `ruang`.`id_ruang` = `peminjaman_ruang`.`id_ruang` WHERE `peminjaman_ruang`.`status_pesan` = '0' AND `peminjaman_ruang`.`no_induk` = '".$_SESSION['current_id']."' ORDER BY `peminjaman_ruang`.`waktu_pinjam` DESC");
				?>
				<div class="row ml-1">
					<?php
					if(mysqli_num_rows($query)){
						while ($baris = mysqli_fetch_array($query)) {
							?>
							<div class="card shadow border-light my-3 mr-3" style="max-width: 18rem;">
								<h6 class="card-header bg-transparent"><?php echo $baris['nama_ruang']; ?></h6>
								<div class="card-body text-dark">
									<h6 class="card-title"><?php echo $baris['keterangan_pinjam']; ?></h6>
									<p class="card-text">
										<i class="fas fa-calendar-alt"></i> <?php echo date("d F Y", strtotime($baris['tanggal'])); ?><br>
										<i class="fas fa-clock"></i> <?php echo $baris['waktu_ruang']; ?>
									</p>
									<div class="row">
										<span class="col float-left"><?php echo date("d/m", strtotime($baris['waktu_pinjam'])); ?></span>
										<div class="col">
											<?php if ($baris['status_pesan']=='0'){
												?>
												<th scope="col"><span class="badge badge-warning"><?php echo 'PENDING'; ?></span></th>
											<?php } else {
												echo "<tr><td>Tidak ada data</td></tr>";} ?>
											</div>
										</div>
									</div>
								</div>
							<?php } ?> <hr> <?php } ?>
						</div>

						<?php
						$query1 = mysqli_query($koneksi,"SELECT `ruang`.`id_ruang`, `ruang`.`nama_ruang`, `ruang`.`waktu_ruang`, `peminjaman_ruang`.`no_induk`, `peminjaman_ruang`.`status_pesan`, `peminjaman_ruang`.`keterangan_pinjam`, `peminjaman_ruang`.`tanggal`, `peminjaman_ruang`.`waktu_pinjam` FROM `ruang` JOIN `peminjaman_ruang` ON `ruang`.`id_ruang` = `peminjaman_ruang`.`id_ruang` WHERE `peminjaman_ruang`.`status_pesan` = '1' AND `peminjaman_ruang`.`no_induk` = '".$_SESSION['current_id']."' ORDER BY `peminjaman_ruang`.`waktu_pinjam` DESC");
						?>
						<div class="row ml-1">
							<?php
							if(mysqli_num_rows($query1)){
								while ($baris = mysqli_fetch_array($query1)) {
									?>
									<div class="card shadow border-light my-3 mr-3" style="max-width: 18rem;">
										<h6 class="card-header bg-transparent"><?php echo $baris['nama_ruang']; ?></h6>
										<div class="card-body text-dark">
											<h6 class="card-title"><?php echo $baris['keterangan_pinjam']; ?></h6>
											<p class="card-text">
												<i class="fas fa-calendar-alt"></i> <?php echo date("d F Y", strtotime($baris['tanggal'])); ?><br>
												<i class="fas fa-clock"></i> <?php echo $baris['waktu_ruang']; ?>
											</p>
											<div class="row">
												<span class="col float-left"><?php echo date("d/m", strtotime($baris['waktu_pinjam'])); ?></span>
												<div class="col">
													<?php if ($baris['status_pesan']=='1'){
														?>
														<th scope="col"><span class="badge badge-success"><?php echo 'DITERIMA'; ?></span></th>
													<?php } ?>
												</div>
											</div>
										</div>
									</div>
								<?php }} ?>
							</div>
							<hr>
							<?php
							$query2 = mysqli_query($koneksi,"SELECT `ruang`.`id_ruang`, `ruang`.`nama_ruang`, `ruang`.`waktu_ruang`, `peminjaman_ruang`.`no_induk`, `peminjaman_ruang`.`status_pesan`, `peminjaman_ruang`.`keterangan_pinjam`, `peminjaman_ruang`.`tanggal`, `peminjaman_ruang`.`waktu_pinjam` FROM `ruang` JOIN `peminjaman_ruang` ON `ruang`.`id_ruang` = `peminjaman_ruang`.`id_ruang` WHERE `peminjaman_ruang`.`status_pesan` = '2' AND `peminjaman_ruang`.`no_induk` = '".$_SESSION['current_id']."' ORDER BY `peminjaman_ruang`.`waktu_pinjam` DESC");
							?>
							<div class="row ml-1">
								<?php
								if(mysqli_num_rows($query2)){
									while ($baris = mysqli_fetch_array($query2)) {
										?>
										<div class="card shadow border-light my-3 mr-3">
											<h6 class="card-header bg-transparent"><?php echo $baris['nama_ruang']; ?></h6>
											<div class="card-body text-dark">
												<h6 class="card-title"><?php echo $baris['keterangan_pinjam']; ?></h6>
												<p class="card-text">
													<i class="fas fa-calendar-alt"></i> <?php echo $baris['tanggal']; ?><br>
													<i class="fas fa-clock"></i> <?php echo $baris['waktu_ruang']; ?>
												</p>
												<div class="row">
													<span class="col float-left"><?php echo date("d/m", strtotime($baris['waktu_pinjam'])); ?></span>
													<div class="col">
														<?php if ($baris['status_pesan']=='2'){
															?>
															<th scope="col"><span class="badge badge-danger"><?php echo 'DITOLAK'; ?></span></th>
														<?php } ?>
													</div>
												</div>
											</div>
										</div>
									<?php }} ?>
								</div>
							</div>
						</div>
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