<?php
//session_start();
//cek apakah yang mengakses halaman ini sudah login
//include "../../fungsi/koneksi.php";
//include ('../../header.php');
$mySql="SELECT * FROM karyawan";
//$jumlah_laki="SELECT * FROM t_penduduk WHERE jk = 'Laki-laki'";
//$jumlah_peremuan="SELECT * FROM t_penduduk WHERE jk = 'Perempuan'";
//$count= "SELECT COUNT(id_penduduk) as jumlah FROM t_penduduk WHERE jk";
// if(isset($_POST['qcari'])) {
// 	$qcari=$_POST['qcari'];
// 	$mySql="SELECT * FROM t_penduduk WHERE thn_masuk like '%$qcari%' ORDER BY thn_masuk DESC";
// 	$mySqlChrt="SELECT * FROM t_penduduk WHERE thn_masuk like '%$qcari%' GROUP BY DATE_FORMAT(thn_masuk, '%Y - %m')";
// 	$count= "SELECT COUNT(id_penduduk) as jumlah FROM t_penduduk WHERE thn_masuk like '%$qcari%' GROUP BY DATE_FORMAT(thn_masuk, '%Y - %m')";
// }
?>
<div>
		<canvas id="myChart" width="100" height="30"></canvas>
</div>
<div class="card">
	<h2 style="margin:10px;">Data Statistik</h2>
	<div class="form-group">
		<!-- <a href="penduduk_keseluruhan_cetak.php" class="btn btn-sm btn-primary " style="margin-left:10px;">Cetak Data</a> -->
		<!-- <div class="right"  style="margin-right:10px;">
			<form class="" method="POST" action="">
				<input type="text" class="form-control" name="qcari" placeholder="<?php echo date('Y-m-d') ?>" autofocus/>
			</form>
		</div> -->
	</div>
	<div class="table-responsive">

	<table class="table table-striped table-hover">
		<thead >
		<tr>
			<th scope="col" class="text-center">NIP</th>
			<th scope="col" class="text-center">Nama</th>
			<th scope="col" class="text-center">Tpt & Tgl lahir</th>
			<th scope="col" class="text-center">Jenis Kelamin</th>
      <th scope="col" class="text-center">Agama</th>
			<th scope="col" class="text-center">Alamat</th>
		</tr>
		</thead>
<?php
	$myQry = mySqli_query ($koneksi, $mySql) or die ("Query salah : ".mysqli_error ($koneksi));
	$nomor = 1;
	while ($kolomData = mysqli_fetch_array ($myQry)) {
?>
		<tr>
			<td class="text-center"><?php echo $kolomData['nip']; ?></td>
			<td class="text-center"><?php echo $kolomData['nama_karyawan']; ?></td>
			<td class="text-center"><?php echo $kolomData['tempat_lahir'];?>-<?php echo $kolomData['tgl_lahir'];?></td>
			<td class="text-center"><?php echo $kolomData['jk']; ?></td>
      <td class="text-center"><?php echo $kolomData['agama']; ?></td>
			<td class="text-center"><?php echo $kolomData['alamat_karyawan']; ?></td>
		</tr>
	<?php } ?>
				</table>
				</div>
			</div>
			<?php //$myQry1 = mySqli_query ($koneksi, $jumlah_laki) or die ("Query salah : ".mysqli_error ($koneksi)); ?>
			<?php //$myQry2 = mySqli_query ($koneksi, $jumlah_peremuan) or die ("Query salah : ".mysqli_error ($koneksi)); ?>
			<?php //$mycount = mySqli_query ($koneksi, $count) or die ("Query salah : ".mysqli_error ($koneksi)); ?>
			<?php $myQry1 = mySqli_query ($koneksi, $mySql) or die ("Query salah : ".mysqli_error ($koneksi)); ?>
			<script>
		var ctx = document.getElementById("myChart").getContext('2d');
		var myChart = new Chart(ctx, {
			type: 'bar',
			data: {
				labels: ["Laki-laki", "Perempuan"],
				datasets: [{
					label: '',
					data: [
					<?php
					$jumlah_laki = mysqli_query($koneksi,"select * from karyawan where jk='Laki-laki'");
					echo mysqli_num_rows($jumlah_laki);
					?>,
					<?php
					$jumlah_perempuan = mysqli_query($koneksi,"select * from karyawan where jk='Perempuan'");
					echo mysqli_num_rows($jumlah_perempuan);
					?>
					],
					backgroundColor: [
					'rgba(255, 99, 132, 0.2)',
					'rgba(54, 162, 235, 0.2)',
					'rgba(255, 206, 86, 0.2)',
					'rgba(75, 192, 192, 0.2)'
					],
					borderColor: [
					'rgba(255,99,132,1)',
					'rgba(54, 162, 235, 1)',
					'rgba(255, 206, 86, 1)',
					'rgba(75, 192, 192, 1)'
					],
					borderWidth: 1
				}]
			},
			options: {
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero:true
						}
					}]
				}
			}
		});
	</script>
<?php //include "../../footer.php"; ?>
