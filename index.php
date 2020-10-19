<?php
session_start();
  // cek jika anggota sudah login
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in']) {
	session_unset();
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login | Order Room for Academics</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="style.css">
	
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
</head>
<body id="index" style="background-image: url(https://image.ibb.co/mo6s50/background.jpg); background-repeat: no-repeat; background-position-y: -5rem;">
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>	
	<section class="col-lg-4 col-12 px-0 shadow">
		<div style="background-color:#333087; padding-top: 1em;"></div>
		<div class="card-body py-3" style="background-color: rgba(255,255,255,0.8);">
			<h1 class="text-center my-3">ORCa</h1>
			<p class="my-3"><b>Order Room for Academics</b> merupakan aplikasi berbasis web yang bertujuan untuk mempermudah transaksi peminjaman ruang sidang di Jurusan Informatika, Fakultas Sains dan Matematika.</p>
		</div>
		<div class="card-body py-3" style="background-color: #EFEFEF;" id="form">
			<?php if (isset($_SESSION['errors'])): ?>
				<div>
					<?php foreach($_SESSION['errors'] as $error): ?> 
						<p class="alert alert-secondary text-center" role="alert"><?php echo $error ?></p>
					<?php endforeach; ?>
				</div>
				<?php unset($_SESSION['errors']); endif; ?>
				<form role="form" method="POST" action="proses_masuk.php">
					<div class="form-group my-3">
						<label for="no_induk">NIM/NIP/Username</label>
						<input type="text" name="no_induk" class="form-control" placeholder="NIM/NIP/Username" id="no_induk" required="required">
					</div>
					<div class="form-group my-3">
						<label for="kata_sandi">Password</label>
						<input type="password" name="kata_sandi" id="kata_sandi" class="form-control" placeholder="Password" required="required">
					</div>
					<button type="submit" name="log_in" class="btn btn-primary btn-block my-4"><div class="text-center">SIGN IN</div></button>
				</form>
				<p class=text-center style="color:gray"><i>Hubungi Administrator jika lupa password</i></p>
			</div>

		</div>
	</section>

</body>
</html>