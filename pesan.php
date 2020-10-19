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
					<img src="<?php echo "upload/".$row['foto_profil'].""; ?>" alt="background" class="img-thumbnail shadow"><br>
					<div class="badge badge-pill badge-primary"><?php echo ''.$row['status'].''?></div> <br>
					<figcaption><?php echo ''.$row['nama'].'';?></figcaption>
					<caption><?php echo ''.$row['no_induk'].'';?></caption>
				</figure>
				<a href="pesan.php?tanggal=" class="btn btn-primary btn-block mr-5">
					<i class="fas fa-door-open"></i> &nbsp;Pinjam Ruang Sidang
				</a>
				<a href=status_pinjam.php class="btn btn-secondary btn-block my-2">
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
			<div id="content" class="col-lg-10">
				<h1>Pinjam Ruang Sidang</h1>
				<form action="validasi_search.php" method="get">
					<div class="row">
						<input type="date" name="tanggal" class="form-control ml-3 col col-lg-4">
						<button type="input" class="mx-3 btn btn-primary">
							<i class="fas fa-search"></i>
						</button>
					</div>
				</form>
				<br>
				<?php 
				$tanggal = $_GET['tanggal'];
				$query = date("d F Y", strtotime($_GET['tanggal']));
				if($tanggal == ""){
					if (isset($_SESSION['errors'])){ ?>
						<div class="alert alert-danger alert-bottom alert-dismissible fade show text-center" role="alert"> 
							<?php echo $_SESSION['errors']; ?>
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<?php unset($_SESSION['errors']);}
						echo '<div class="jumbotron jumbotron-fluid text-center">';
						echo '<div class="container">';
						echo '<img src="https://svgshare.com/i/98Q.svg" title="" />';
						echo '<h6 style="color: #BEBEBE">Masukkan tanggal terlebih dahulu</h6>';
						echo '</div></div>';
					}
					else{
						$select = mysqli_query($koneksi, "SELECT DISTINCT `ruang`.`nama_ruang`, `ruang`.`id_ruang`, `ruang`.`waktu_ruang`, `peminjaman_ruang`.`tanggal`, `peminjaman_ruang`.`status_pesan` FROM `ruang` LEFT JOIN `peminjaman_ruang` ON `ruang`.`id_ruang` = `peminjaman_ruang`.`id_ruang`AND `peminjaman_ruang`.`tanggal` = '".$tanggal."' WHERE `ruang`.`nama_ruang`='Ruang Sidang 1' ORDER BY `ruang`.`waktu_ruang`"); 
						?>
						<form action="create_pesan.php" method="POST">
							<h6 class="m-1"><?php echo "".$query.""; ?></h6>
							<div class="row my-2">
								<div class="col-lg-4">
									<table class="table table-light shadow">
										<th colspan="2"><h6>Ruang Sidang 1</h6></th>
										<th></th>

										<?php
										if(mysqli_num_rows($select)){
											while ($baris = mysqli_fetch_array($select)) {
												?>
												<tbody>
													<tr>
														<th scope="col"><?php echo $baris['waktu_ruang']; ?></th>
														<?php if ($baris['tanggal']==NULL){
															?>
															<th scope="col"><span class="badge badge-success"><?php echo 'TERSEDIA'; ?></span></th>
															<th scope="col"><input name="id_ruang" value="<?php echo $baris['id_ruang']; ?>"  type="radio" onclick="myFunction()"></th>
														<?php } else { ?>
															<th scope="col"><span class="badge badge-danger"><?php echo 'DIGUNAKAN'; ?></span></th>
															<th scope="col"><input name="radio" type="radio" disabled></th>
														</tr>
													<?php }}} else{
														echo "<tr><td>Tidak ada data</td></tr>";
													} ?>
												</tbody>
											</table>
										</div>
										<?php
										$select2 = mysqli_query($koneksi, "SELECT `ruang`.`nama_ruang`, `ruang`.`id_ruang`, `ruang`.`waktu_ruang`, `peminjaman_ruang`.`tanggal` , `peminjaman_ruang`.`status_pesan` FROM `ruang` LEFT JOIN `peminjaman_ruang` ON `ruang`.`id_ruang` = `peminjaman_ruang`.`id_ruang`AND `peminjaman_ruang`.`tanggal` = '".$tanggal."' WHERE `ruang`.`nama_ruang`='Ruang Sidang 2' ORDER BY `ruang`.`waktu_ruang`"); 	
										?>
										<div class="col-lg-4">
											<table class="table table-light shadow">
												<th colspan="2"><h6>Ruang Sidang 2</h6></th>
												<th></th>

												<?php
												if(mysqli_num_rows($select2)){
													while ($baris = mysqli_fetch_array($select2)) {
														?>
														<tbody>
															<tr>
																<th scope="col"><?php echo $baris['waktu_ruang']; ?></th>
																<?php if ($baris['tanggal']==NULL){
																	?>
																	<th scope="col"><span class="badge badge-success"><?php echo 'TERSEDIA'; ?></span></th>
																	<th scope="col"><input name="id_ruang" value="<?php echo $baris['id_ruang']; ?>" type="radio" onclick="myFunction()"></th>
																<?php } else { ?>
																	<th scope="col"><span class="badge badge-danger"><?php echo 'DIGUNAKAN'; ?></span></th>
																	<th scope="col"><input name="radio" type="radio" disabled></th>
																</tr>
															<?php }}} else{
																echo "<tr><td>Tidak ada data</td></tr>";
															} ?>
														</tbody>
													</table>
												</div>				
												
												<?php
												$select3 = mysqli_query($koneksi, "SELECT `ruang`.`nama_ruang`, `ruang`.`id_ruang`, `ruang`.`waktu_ruang`, `peminjaman_ruang`.`tanggal` , `peminjaman_ruang`.`status_pesan` FROM `ruang` LEFT JOIN `peminjaman_ruang` ON `ruang`.`id_ruang` = `peminjaman_ruang`.`id_ruang`AND `peminjaman_ruang`.`tanggal` = '".$tanggal."' WHERE `ruang`.`nama_ruang`='Ruang Sidang 3' ORDER BY `ruang`.`waktu_ruang`"); 	
												?>
												<div class="col-lg-4">
													<table class="table table-light shadow">
														<th colspan="2"><h6>Ruang Sidang 3</h6></th>
														<th></th>

														<?php
														if(mysqli_num_rows($select3)){
															while ($baris = mysqli_fetch_array($select3)) {
																?>
																<tbody>
																	<tr>
																		<th scope="col"><?php echo $baris['waktu_ruang']; ?></th>
																		<?php if ($baris['tanggal']==NULL){
																			?>
																			<th scope="col"><span class="badge badge-success"><?php echo 'TERSEDIA'; ?></span></th>
																			<th scope="col"><input name="id_ruang" value="<?php echo $baris['id_ruang']; ?>" type="radio" onclick="myFunction()"></th>
																		<?php } else { ?>
																			<th scope="col"><span class="badge badge-danger"><?php echo 'DIGUNAKAN'; ?></span></th>
																			<th scope="col"><input name="radio" type="radio" disabled></th>
																		</tr>
																	<?php }}} else{
																		echo "<tr><td>Tidak ada data</td></tr>";
																	} ?>
																</tbody>
															</table>
														</div>
													</div>
													<script>
														function myFunction()
														{
															var input = document.querySelector('input[name="id_ruang"]:checked').value;
															switch(document.querySelector('input[name="id_ruang"]:checked').value){
																case "01":
																document.getElementById('nama_ruang').innerHTML = "Ruang Sidang 1";
																document.getElementById('pukul').innerHTML = "08.00 - 09.00";
																break;
																case "06":
																document.getElementById('nama_ruang').innerHTML = "Ruang Sidang 2";
																document.getElementById('pukul').innerHTML = "08.00 - 09.00";
																break;
																case "11":
																document.getElementById('nama_ruang').innerHTML = "Ruang Sidang 3";
																document.getElementById('pukul').innerHTML = "08.00 - 09.00";
																break;
																case "02":
																document.getElementById('nama_ruang').innerHTML = "Ruang Sidang 1";
																document.getElementById('pukul').innerHTML = "09.00 - 10.00";
																break;
																case "07":
																document.getElementById('nama_ruang').innerHTML = "Ruang Sidang 2";
																document.getElementById('pukul').innerHTML = "09.00 - 10.00";
																break;
																case "12":
																document.getElementById('nama_ruang').innerHTML = "Ruang Sidang 3";
																document.getElementById('pukul').innerHTML = "09.00 - 10.00";
																break;
																case "03":
																document.getElementById('nama_ruang').innerHTML = "Ruang Sidang 1";
																document.getElementById('pukul').innerHTML = "10.00 - 11.00";
																break;
																case "08":
																document.getElementById('nama_ruang').innerHTML = "Ruang Sidang 2";
																document.getElementById('pukul').innerHTML = "10.00 - 11.00";
																break;
																case "13":
																document.getElementById('nama_ruang').innerHTML = "Ruang Sidang 3";
																document.getElementById('pukul').innerHTML = "10.00 - 11.00";
																break;
																case "04":
																document.getElementById('nama_ruang').innerHTML = "Ruang Sidang 1";
																document.getElementById('pukul').innerHTML = "11.00 - 12.00";
																break;
																case "09":
																document.getElementById('nama_ruang').innerHTML = "Ruang Sidang 2";
																document.getElementById('pukul').innerHTML = "11.00 - 12.00";
																break;
																case "14":
																document.getElementById('nama_ruang').innerHTML = "Ruang Sidang 3";
																document.getElementById('pukul').innerHTML = "11.00 - 12.00";
																break;
																case "05":
																document.getElementById('nama_ruang').innerHTML = "Ruang Sidang 1";
																document.getElementById('pukul').innerHTML = "13.00 - 14.00";
																break;
																case "10":
																document.getElementById('nama_ruang').innerHTML = "Ruang Sidang 2";
																document.getElementById('pukul').innerHTML = "13.00 - 14.00";
																break;
																case "15":
																document.getElementById('nama_ruang').innerHTML = "Ruang Sidang 3";
																document.getElementById('pukul').innerHTML = "13.00 - 14.00";
																break;
															}
															document.getElementById('tanggal').innerHTML = "<?php echo $query;?>";
														}
													</script>
													<p>	Ruangan yang dipilih: <b id="nama_ruang"></b><br>
														Tanggal : <b id="tanggal"></b><br>
														Pukul : <b id="pukul"></b><br>
													</p>								
													
													<h6>Keterangan Pinjam</h6>
													<div class="row">
														<div class="col-12 col-lg-3">
															<input type="text" name="keterangan_pinjam" class="form-control" placeholder="Contoh: Sidang Skripsi" required="required">
														</div>
														<input type="hidden" name="tanggal" value="<?php echo $_GET['tanggal']; ?>">
														<div class="col-12 col-lg-4 mt-2 mt-lg-0 p-lg-1">
															<button type="submit" class="btn btn-primary btn-sm">+ PESAN</button>
														</div>
													</div>
												</form>
												<?php if (isset($_SESSION['success'])){ ?>
													<div class="alert alert-success alert-bottom alert-dismissible fade show text-center" role="alert"> 
														<?php echo $_SESSION['success']; ?>
														<button type="button" class="close" data-dismiss="alert" aria-label="Close">
															<span aria-hidden="true">&times;</span>
														</button>
													</div>
												<?php unset($_SESSION['success']);}?>
												</div>
											</div>
										<?php } ?>
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