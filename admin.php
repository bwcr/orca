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
			<?php $select = mysqli_query($koneksi, "SELECT `no_induk`,`nama`,`status`,`last_login` FROM `peminjam` UNION SELECT `no_induk`,`nama`,`status`,`last_login` FROM `staff_pengelola` WHERE `nama` NOT IN ('administrator')"); ?>
				<h1>Kelola Peminjam</h1>
				<a href="create_member.php"><button class="btn btn-primary"> + TAMBAH Peminjam </button></a>
				<table class="table table-hover table-responsive my-3">
					<thead>
						<tr>
							<th scope="col">Nama</th>
							<th scope="col">No. Induk</th>
							<th scope="col">Status</th>
							<th scope="col" colspan="2">Action</th>
						</tr>
					</thead>
					<tbody>
					<?php
					if(mysqli_num_rows($select)){
						while ($baris = mysqli_fetch_array($select)) {
							?>
						<tr>
							<td scope="col"><?php echo $baris['nama'];?></td>
							<td scope="col"><?php echo $baris['no_induk'];?></td>
							<td scope="col"><?php echo $baris['status'];?></td>
							<td scope="col"><a href="edit_member.php?no_induk=<?php echo $baris['no_induk']?>">
							<button class="btn btn-sm btn-outline-secondary"><i class="fas fa-pen"></i></button></a></td>
							<td><button class="btn btn-sm btn-outline-danger" onclick="<?php echo "".$baris['status']."".$baris['no_induk']."";?>()"><i class="fas fa-trash"></i></button></td>
							
							<form action="delete_member.php" method="POST" id="<?php echo $baris['no_induk'] ?>">
							<input type="hidden" name="nama" value="<?php echo $baris['nama']?>">
							<input type="hidden" name="status" value="<?php echo $baris['status']?>">
							<input type="hidden" name="no_induk" value="<?php echo $baris['no_induk']?>">
							</form>
							<script>
							function <?php echo "".$baris['status']."".$baris['no_induk']."";?>(){
										if (confirm("Apakah anda yakin ingin menghapus <?php echo $baris['nama']; ?>?")) {
											document.getElementById("<?php echo $baris['no_induk'] ?>").submit();
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