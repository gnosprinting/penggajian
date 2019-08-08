<?php

session_start();

include "../../fungsi/koneksi.php";
include "../../fungsi/fungsi_tanggal.php";
include"../../fungsi/pdf/fpdf.php";
include"../../fungsi/format_number.php";

$format_bulan = format_month(substr($_POST['bulan'],0,2));
$bulan = substr($_POST['bulan'],0,2);
$tahun = substr($_POST['bulan'],3,4);
$nip = $_POST['cetak'];

//QUERY ABSENSI
$query_absensi = mysqli_query($koneksi,"SELECT date(tgl_absensi) AS tgl FROM absensi
							WHERE nip = '$nip' AND YEAR(tgl_absensi) = '$tahun'
							AND MONTH(tgl_absensi) = '$bulan'
							GROUP BY tgl_absensi") or die(mysqli_error());
$jumlah_absensi = mysqli_num_rows($query_absensi);

//QUERY ABSENSI CUTI
$query_acuti = mysqli_query($koneksi,"SELECT * FROM absensi
							WHERE nip = '$nip' AND YEAR(tgl_absensi) = '$tahun'
							AND MONTH(tgl_absensi) = '$bulan'
                                                        AND kehadiran = 'Cuti'") or die(mysqli_error());
$jlh_acuti = mysqli_num_rows($query_acuti);

//QUERY ABSENSI Sakit
$query_asakit = mysqli_query($koneksi,"SELECT * FROM absensi
							WHERE nip = '$nip' AND YEAR(tgl_absensi) = '$tahun'
							AND MONTH(tgl_absensi) = '$bulan'
                                                        AND kehadiran = 'Sakit'") or die(mysqli_error());
$jlh_asakit = mysqli_num_rows($query_asakit);

//QUERY ABSENSI IJIN
$query_aijin = mysqli_query($koneksi,"SELECT * FROM absensi
							WHERE nip = '$nip' AND YEAR(tgl_absensi) = '$tahun'
							AND MONTH(tgl_absensi) = '$bulan'
                                                        AND kehadiran = 'Ijin'") or die(mysqli_error());
$jlh_aijin = mysqli_num_rows($query_aijin);

//QUERY ABSENSI Alpha
$query_aalfa = mysqli_query($koneksi,"SELECT * FROM absensi
							WHERE nip = '$nip' AND YEAR(tgl_absensi) = '$tahun'
							AND MONTH(tgl_absensi) = '$bulan'
                                                        AND kehadiran = ''") or die(mysqli_error());
$jlh_aalfa = mysqli_num_rows($query_aalfa);


//QUERY TUNJANGAN JABATAN
$query_tj = mysqli_query($koneksi,"SELECT * FROM tunjangan_jabatan tj
						JOIN jenis_tunjangan jt ON tj.id_jenis_tunjangan = jt.id_jenis_tunjangan
						JOIN karyawan k ON tj.nip = k.nip
						WHERE k.nip = '$nip'");

$query_jt = mysqli_query($koneksi,"SELECT * FROM jenis_tunjangan");
$jlh_jenis_tunjangan = mysqli_num_rows($query_jt);

//QUERY KARYAWAN
$query_karyawan = mysqli_query($koneksi,"SELECT * FROM karyawan k JOIN jabatan j ON j.id_jabatan = k.id_jabatan WHERE nip = '$nip'")or die(mysqli_error());
$datak = mysqli_fetch_array($query_karyawan);

//QUERY KEHADIRAN
$query_jlh_kehadiran = mysqli_query($koneksi,"SELECT HOUR(timediff(waktu_keluar, waktu_masuk)) AS jlh_jam, kehadiran
									  FROM absensi
									  WHERE nip = '$nip' AND kehadiran = 'Hadir'
									  AND MONTH(tgl_absensi) = '$bulan' AND YEAR(tgl_absensi) = '$tahun'") or die(mysqli_error());
$jumlah_kehadiran = mysqli_num_rows($query_jlh_kehadiran);

$nou = 0;
$jumlah_jam_kehadiran = 0;

while ($data_jlh_kehadiran = mysqli_fetch_array($query_jlh_kehadiran)) {
	if ($data_jlh_kehadiran['kehadiran'] == 'Hadir') {
		$jlh_jam = $data_jlh_kehadiran['jlh_jam'];
	} else {
		$jlh_jam = '0';
	}

	$jumlah_jam_kehadiran += $jlh_jam;//HITUNG TOTAL JAM KERJA 1 BULAN (26 HARI)

	$nou++;
}

if ($jumlah_jam_kehadiran > 208){
	$jumlah_jam_lembur = $jumlah_jam_kehadiran - 208; //MENGHITUNG JUMLAH JAM LEMBUR
	$jumlah_jam_potongan = 0; // MENGHITUNG JUMLAH JAM POTONGAN
	$gaji_lembur = ($gaji_jam = $datak['gapok']/208) * ($jumlah_jam_lembur); // MENGHITUNG GAJI LEMBUR
	$besar_potongan = 0; // MENGHITUNG BESAR POTONGAN
}else{
	$jumlah_jam_lembur = $jumlah_jam_kehadiran - (8 * $jumlah_kehadiran); //MENGHITUNG JUMLAH JAM LEMBUR
	$jumlah_jam_potongan = 208 - ($jumlah_kehadiran*8);// MENGHITUNG JUMLAH JAM POTONGAN
	$gaji_lembur = ($datak['gapok']/208) * ($jumlah_jam_lembur);// MENGHITUNG GAJI LEMBUR
	$besar_potongan = ($datak['gapok']/208) * ($jumlah_jam_potongan);// MENGHITUNG BESAR POTONGAN
}

//echo $jumlah_jam_potongan;die();

if($jumlah_absensi < 1){
		echo "<script language='javascript'>
                        alert('Data gaji tidak ditemukan atau masih kosong');
                        window.location='../../index.php?modul=struk_gaji';
		</script>";
}else{
$pdf = new FPDF();
$pdf->AliasNbPages();
$pdf->AddPage('P', 'A5');
$pdf->Ln();
//TABEL FORM
$linespace1 = 3;

$pdf->SetFont('Times', 'BU', '10');
$pdf->Cell(0, 6, 'DISKOMINFO PROVINSI KALSEL', 0, 1, 'C');
$pdf->Ln(-2);
$pdf->SetFont('Times', 'B', '10');
$pdf->Cell(0, 6, 'SLIP GAJI', 0, 1, 'C');
$pdf->Cell(0, 6, 'Bulan : '.$format_bulan.' '. $tahun, 0, 1, 'C');
$pdf->ln();
//ATA KARYWAN
$pdf->SetFont('Courier', '', 10);
$pdf->Cell(0, 4, 'NIP', '', 0, 'L');
$pdf->setX(30);
$pdf->Cell(0, 4, ': '.$datak['nip'], '', 1, 'L');
$pdf->Cell(0, 4, 'NAMA', '0', 0, 'L');
$pdf->setX(30);
$pdf->Cell(0, 4, ': '.$datak['nama_karyawan'], '', 1, 'L');
$pdf->Cell(0, 4, 'JABATAN', '0', 0, 'L');
$pdf->setX(30);
$pdf->Cell(0, 4, ': '.$datak['nama_jabatan'], '', 1, 'L');
$pdf->ln();
//KETERANGAN KEHADIRAN

$pdf->setX(20);
$pdf->Cell(0, 4, 'Jumlah hari kerja', '', 0, 'L');
$pdf->setX(70);
$pdf->Cell(0, 4, ': ', '', 0, 'L');
$pdf->setX(74);
$pdf->Cell(30, 4, $jumlah_kehadiran.' Hari', '', 1, 'L');
$pdf->setX(20);
$pdf->Cell(0, 4, 'Jumlah jam kerja', '', 0, 'L');
$pdf->setX(70);
$pdf->Cell(0, 4, ': ', '', 0, 'L');
$pdf->setX(74);
$pdf->Cell(30, 4, $jumlah_jam_kehadiran.' Jam', '', 1, 'L');
$pdf->setX(20);
$pdf->SetFont('Courier', 'I', '8');
$pdf->Cell(0, 4, '(Jumlah jam kehadiran normal : 208 Jam)', '', 1, 'L');
$pdf->ln();
$pdf->ln();
//PERHITUNGAN GAJI
$pdf->setX(20);
$pdf->SetFont('Courier', '', 10);
$pdf->Cell(0, 4, 'Gaji Pokok', '', 0, 'L');
$pdf->setX(70);
$pdf->Cell(0, 4, ': Rp. ', '', 0, 'L');
$pdf->setX(74);
$pdf->Cell(30, 4, indo_number_without_rp($datak['gapok']), '', 1, 'R');

$i = 0;
$jumlah_tunjangan = 0;
while ($datatj = mysqli_fetch_array($query_tj)){
	$pdf->setX(20);
	$i++;
	$pdf->Cell(0, 4, 'Tunjangan '.$datatj['nama_jenis_tunjangan'], '0', 0, 'L');
	$pdf->setX(70);
	$pdf->Cell(0, 4, ': Rp. ', '', 0, 'L');
	$pdf->setX(74);
	$pdf->Cell(30, 4, indo_number_without_rp($datatj['besar_tunjangan']), '', 1, 'R');

	$jumlah_tunjangan += $datatj['besar_tunjangan'];
}

$pdf->setX(20);
$pdf->Cell(0, 4, 'Lembur ('.$jumlah_jam_lembur.'jam)', '0', 0, 'L');
$pdf->setX(70);
$pdf->Cell(0, 4, ': Rp. ', '', 0, 'L');
$pdf->setX(74);
$pdf->Cell(30, 4, indo_number_without_rp($gaji_lembur), '', 1, 'R');
$pdf->Ln();
$pdf->setX(20);
$pdf->Cell(0, 4, 'Potongan Kehadiran', '0', 1, 'L');
$pdf->setX(20);
$pdf->Cell(0, 4, '- Cuti ('.$jlh_acuti.' Hari)', '0', 0, 'L');
$pdf->setX(70);
$pdf->Cell(0, 4, ': Rp. ', '', 0, 'L');
$pdf->setX(74);
$pdf->Cell(30, 4, indo_number_without_rp(($datak['gapok']/208) * ($jlh_acuti*8)), '', 1, 'R');
$pdf->setX(20);
$pdf->Cell(0, 4, '- Sakit ('.$jlh_asakit.' Hari)', '0', 0, 'L');
$pdf->setX(70);
$pdf->Cell(0, 4, ': Rp. ', '', 0, 'L');
$pdf->setX(74);
$pdf->Cell(30, 4, indo_number_without_rp(($datak['gapok']/208) * ($jlh_asakit*8)), '', 1, 'R');
$pdf->setX(20);
$pdf->Cell(0, 4, '- Ijin ('.$jlh_aijin.' Hari)', '0', 0, 'L');
$pdf->setX(70);
$pdf->Cell(0, 4, ': Rp. ', '', 0, 'L');
$pdf->setX(74);
$pdf->Cell(30, 4, indo_number_without_rp(($datak['gapok']/208) * ($jlh_aijin*8)), '', 1, 'R');
$pdf->setX(20);
$pdf->Cell(0, 4, '- T.Keterangan ('.$jlh_aalfa.' Hari)', '0', 0, 'L');
$pdf->setX(70);
$pdf->Cell(0, 4, ': Rp. ', '', 0, 'L');
$pdf->setX(74);
$pdf->Cell(30, 4, indo_number_without_rp(($datak['gapok']/208) * ($jlh_aalfa*8)), '', 1, 'R');
$pdf->setX(74);
$pdf->Cell(30, 4, '', 'T', 1, 'R');
$pdf->setX(40);
$pdf->SetFont('Courier', 'B', '10');
$pdf->Cell(0, 4, 'Jumlah', '0', 0, 'L');
$pdf->setX(70);
$pdf->Cell(0, 4, ': Rp. ', '', 0, 'L');
$pdf->setX(74);
//MENGHITUNG JUMLAH GAJI
$jumlah_gaji = ($datak['gapok'] + $jumlah_tunjangan + $gaji_lembur) - $besar_potongan;

//save to table GAJI
$query_gaji = mysqli_query($koneksi,"SELECT * FROM gaji
							WHERE nip = '$nip' AND bulan = '$bulan'
							AND tahun = '$tahun'") or die(mysqli_error());
$cek = mysqli_num_rows($query_gaji);
if ($cek==0) {
	$insert = mysqli_query($koneksi,"INSERT INTO gaji (bulan, tahun, nip, gapok, total_gaji)
						VALUES ('$bulan', '$tahun', '$nip', '" . $datak["gapok"] ."', '$jumlah_gaji')");
}else {
	$update = mysqli_query($koneksi,"UPDATE gaji SET bulan='$bulan', tahun='$tahun', nip='$nip', gapok='" . $datak["gapok"] ."', total_gaji='$jumlah_gaji' WHERE nip = '$nip' AND bulan = '$bulan' AND tahun = '$tahun'");
}
//end save
//CETAK JUMLAH GAJI
$pdf->Cell(30, 4, indo_number_without_rp($jumlah_gaji), '', 1, 'R');
$pdf->Ln();
$pdf->Ln();
//footer selalu sama
$pdf->SetFont('Courier', 'B', '10');
$pdf->Cell(0, 6, 'Staff Keuangan', 0, 1, 'C');
$pdf->Ln(10);
$pdf->SetFont('Courier', 'BU', '10');
$pdf->Cell(0, 6, $_SESSION['nama'], 0, 1, 'C');//NAMA KEUANGAN
$pdf->SetFont('Courier', 'B', '10');
$pdf->Cell(0, 3, 'NIP. '.$_SESSION['id_pengguna'], 0, 1, 'C');//NAMA KEUANGAN
$pdf->Output();
}
