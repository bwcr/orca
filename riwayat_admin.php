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
	if($_SESSION['current_id'] == 'admin'){
	$sql = "SELECT * FROM staff_pengelola WHERE no_induk = 'admin'";
	$result = mysqli_query($koneksi, $sql);
	if(!$result){
		die("Could not query the database: <br />".mysqli_error($link));
	}
	$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
	}
	else{
		header('Location: ../orca/logout.php');
		$_SESSION['errors'] = ['no_induk' => 'Silahkan Login'];
		die;
	}
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
				<a href="admin.php" class="btn btn-secondary btn-block mr-5">
				<i class="fas fa-user"></i> &nbsp; Kelola Peminjam
				</a>
				<a href="riwayat_admin.php" class="btn btn-primary btn-block my-2">
					<i class="fas fa-history"></i> &nbsp; Kelola Riwayat
				</a>
				<br>
				<div class="text-left"><b style="color: #9C9C9C">PROFIL</b></div>
				<a href=logout.php class="btn btn-secondary btn-block my-2">
					<i class="fas fa-sign-out-alt"></i> &nbsp; Keluar
				</a>
			</div>
			<div id="content" class="col-lg-10">
			<?php
				$query = mysqli_query($koneksi,"SELECT `peminjaman_ruang`.`id_peminjaman`,`ruang`.`waktu_ruang`,`peminjam`.`no_induk`,`peminjam`.`nama`,`ruang`.`id_ruang`,`tanggal`,`ruang`.`nama_ruang`,`peminjam`.`status`,`keterangan_pinjam`,`waktu_pinjam`,`status_pesan` FROM `peminjaman_ruang` LEFT JOIN `peminjam` ON `peminjam`.`no_induk` = `peminjaman_ruang`.`no_induk` LEFT JOIN `ruang` ON `ruang`.`id_ruang` = `peminjaman_ruang`.`id_ruang` ORDER BY `waktu_pinjam` DESC");
			?>
				<h1>Kelola Riwayat</h1>
				<br>
				<table class="table table-sm table-hover table-responsive my-3">
					<thead>
						<tr>
							<th scope="col">ID</th>
							<th scope="col">Waktu Pinjam</th>
							<th scope="col">Ruang</th>
							<th scope="col">Tanggal, Waktu</th>
							<th scope="col">Peminjam</th>
							<th scope="col">No. Induk</th>
							<th scope="col">Keterangan</th>
							<th scope="col">Status</th>
							<th scope="col"></th>
						</tr>
					</thead>
					<tbody>
					<?php
						if(mysqli_num_rows($query)){
						while ($baris = mysqli_fetch_array($query)) {
					?>
						<tr>
							<td scope="col"><?php echo $baris['id_peminjaman'];?></td>
							<td scope="row"><?php echo date("d/m - H.i", strtotime($baris['waktu_pinjam']));?></td>
							<?php switch ($baris['nama_ruang']){
													case "Ruang Sidang 1":
													echo "<td>1</td>";
													break;
													case "Ruang Sidang 2":
													echo "<td>2</td>";
													break;
													case "Ruang Sidang 3":
													echo "<td>3</td>";
													break;
										}?>
							<td><?php echo "".date("d/m", strtotime($baris['tanggal'])).", ".$baris['waktu_ruang']."";?></td>
							<td scope="col"><?php echo $baris['nama'];?></td>
							<td scope="col"><?php echo $baris['no_induk'];?></td>
							<td scope="col"><?php echo $baris['keterangan_pinjam'];?></td>
							<?php switch ($baris['status_pesan']){
													case "0":
													echo "<td>Pending</td>";
													break;
													case "1":
													echo "<td>Diterima</td>";
													break;
													case "2":
													echo "<td>Ditolak</td>";
													break;
							}?>
							<td><button class="btn btn-sm btn-outline-danger" onclick="<?php echo "Hapus".$baris['id_peminjaman']."";?>()"><i class="fas fa-trash"></i></button></td>
							
							<form action="delete_riwayat.php" method="POST" id="<?php echo $baris['id_peminjaman'] ?>">
							<input type="hidden" name="id_peminjaman" value="<?php echo $baris['id_peminjaman']?>">
							</form>
							<script>
							function <?php echo "Hapus".$baris['id_peminjaman']."";?>(){
										if (confirm("Apakah anda yakin ingin menghapus ID <?php echo $baris['id_peminjaman']; ?>?")) {
											document.getElementById("<?php echo $baris['id_peminjaman'] ?>").submit();
										} else {
											window.stop();
										}}
							</script>
						</tr>
						<?php }} ?>
					</tbody>
				</table>
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
				<?php if (isset($_SESSION['success'])){ ?>
								<div class="alert alert-success alert-bottom alert-dismissible fade show text-center" role="alert"> 
									<?php echo $_SESSION['success']; ?>
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<?php unset($_SESSION['success']);}?>
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