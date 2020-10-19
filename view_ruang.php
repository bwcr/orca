<!--File: view_books.phpDeskripsi  :  menampilkan  data  buku  menggunakan  mysqli  dengan  pendekatan  prosedural-->
<!DOCTYPE  HTML  PUBLIC  "-//W3C//DTD  HTML  4.01  Transitional//EN""http://www.w3.org/TR/html401/loose.dtd">
<html>
<head>
	<meta  http-equiv="Content-Type"  content="text/html;  charset=iso-8859-1">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="style.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
	<title>Ruang Tersedia</title>
</head>
<body>
	<table class="table table-light shadow">
		<th colspan="2"><h6>Ruang Sidang 1</h6></th>
		<th></th>
		<tbody>
			<tr>
				<th scope="col">08.00-09.00</th>
				<th scope="col"><span class="badge badge-success">Tersedia</span></th>
				<th scope="col"><input name="waktu" type="checkbox"></th>
			</tr>
			<tr>
				<th scope="col">09.00-10.00</th>
				<th scope="col"><span class="badge badge-success">Tersedia</span></th>
				<th scope="col"><input name="waktu" type="checkbox"></th>
			</tr>
			<tr>
				<th scope="col">10.00-11.00</th>
				<th scope="col"><span class="badge badge-success">Tersedia</span></th>
				<th scope="col"><input name="waktu" type="checkbox"></th>
			</tr>
			<tr>
				<th scope="col">11.00-12.00</th>
				<th scope="col"><span class="badge badge-success">Tersedia</span></th>
				<th scope="col"><input name="waktu" type="checkbox"></th>
			</tr>
			<tr>
				<th scope="col">13.00-14.00</th>
				<th scope="col"><span class="badge badge-danger">Digunakan</span></th>
				<th scope="col"><input name="waktu" type="checkbox" disabled></th>
			</tr>
		</tbody>
	</table>
	<tr>
		<th>waktu_ruang</th>
		<th>nama_ruang</th>
		<th>tanggal_peminjaman</th>
	</tr>
	<?php
		//Include  our  login  information
	require_once('Connections/koneksi.php');
	$query  =  "  SELECT ruang.nama_ruang, ruang.waktu_ruang, peminjaman_ruang.tanggal_peminjaman FROM `ruang` LEFT JOIN `peminjaman_ruang` ON ruang.id_ruang = peminjaman_ruang.id_ruang ";
		//  Execute  the  query
	$result  =  mysqli_query($koneksi,$query);
	if  (!$result){die  ("Could  not  query  the  database:  <br  />".  mysqli_error($koneksi));}
		//  Fetch  and  display  the  results
	while  ($row  =  mysqli_fetch_array($result)){echo  '<tr>';
	echo  '<td><a href="view_kategori_byid.php?id_komentar='.$row['id_kategori'].'">'.$row['id_kategori'].'</a></td>';
	echo  '<td>'.$row['nama_kategori'].'</td>  ';
	echo  '<td>'.$row['id_anggota'].'</td>  ';
	echo  '</tr>';
}
echo  '</table>';
echo  '<br  />';
echo  'Total  Rows  =  '.mysqli_num_rows($result).'<br  />';
mysqli_close($koneksi);
?>
</table>
</body>
</html>