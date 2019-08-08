<?php

session_start();

include "../../fungsi/koneksi.php";
include "../../fungsi/fungsi_tanggal.php";
include"../../fungsi/pdf/fpdf.php";
include"../../fungsi/format_number.php";

$format_bulan = format_month($_POST['bulan']);
$bulan = $_POST['bulan'];
$tahun = $_POST['tahun'];
//QUERY ULANGAN
$query_absensi = mysqli_query($koneksi,"SELECT date(tgl_absensi) AS tgl FROM absensi
							WHERE YEAR(tgl_absensi) = '$tahun'
							AND MONTH(tgl_absensi) = '$bulan'
							GROUP BY tgl_absensi") or die(mysqli_error());
$jumlah_absensi = mysqli_num_rows($query_absensi);

//QUERY JENIS TUNJANGAN
$query_jenis_tunjangan = mysqli_query($koneksi,"SELECT * FROM jenis_tunjangan");
$query_jenis_tunjangan2 = mysqli_query($koneksi,"SELECT * FROM jenis_tunjangan");
$jlh_jenis_tunjangan = mysqli_num_rows($query_jenis_tunjangan);

//QUERY KARYAWAN
$query_karyawan = mysqli_query($koneksi,"SELECT * FROM karyawan GROUP BY nip") or die(mysqli_error());
$jlh_karyawan = mysqli_num_rows($query_karyawan);

if ($jumlah_absensi < 1) {
    echo "<script language='javascript'>
                        alert('Data gaji tidak ditemukan atau masih kosong');
                        window.location='../../index.php?modul=laporan_gaji';
		</script>";
} else {
    $pdf = new FPDF();
    $pdf->AliasNbPages();
    $pdf->AddPage('C');
    $pdf->Ln();
//TABEL FORM
    $linespace1 = 3;

    $pdf->SetFont('Times', 'BU', '10');
    $pdf->Cell(0, 6, 'DISKOMINFO PROVINSI KALSEL', 0, 1, 'C');
    $pdf->Ln(-2);
    $pdf->SetFont('Times', 'B', '10');
    $pdf->Cell(0, 6, 'Rekapitulasi Gaji', 0, 1, 'C');
    $pdf->Cell(0, 6, 'Bulan : ' . $format_bulan . ' ' . $tahun, 0, 1, 'C');

//TABEL DATA
    $linespace = 3;
    $w = array(6, 25, 40, 7, 20, 20, 20, 20, 25);
//=========0, 1,  2,  3, 4,   5, 6, 7=====//

    $pdf->setX(60);
    $pdf->SetFont('Arial', 'B', 6);

    $pdf->Cell($w[0], 4, 'NO', 'TLR', 0, 'L');
    $pdf->Cell($w[1], 4, 'NIP', 'TLR', 0, 'C');
    $pdf->Cell($w[2], 4, 'NAMA', 'TLR', 0, 'C');
//PERULANGAN KOLOM SOAL
    $nou = 0;
    $total_cell = 0;
    while ($data_jt = mysqli_fetch_array($query_jenis_tunjangan2)) {
        $nou++;
        $total_cell += $w[4];
    }
    $pdf->Cell($total_cell, 4, 'TUNJANGAN', 'TB', 0, 'C');
    $pdf->Cell($w[5], 4, 'KEHADIRAN', 'TLR', 0, 'C');
    $pdf->Cell($w[6], 4, 'JLH KERJA', 'TLR', 0, 'C');
    $pdf->Cell($w[7], 4, 'GAJI', 'TLR', 0, 'C');
    $pdf->Cell($w[8], 4, 'JLH GAJI', 'TLR', 0, 'C');
    $pdf->Ln();
    $pdf->setX(60);
    $pdf->SetFont('Arial', 'B', 6);

    $pdf->Cell($w[0], 4, '', 'LR', 0, 'L');
    $pdf->Cell($w[1], 4, '', 'LR', 0, 'C');
    $pdf->Cell($w[2], 4, '', 'LR', 0, 'C');
//PERULANGAN KOLOM SOAL
    $nou1 = 0;
    while ($data_jt2 = mysqli_fetch_array($query_jenis_tunjangan)) {
        $nou1++;
        $pdf->Cell($w[4], 4, strtoupper($data_jt2['nama_jenis_tunjangan']), 'LR', 0, 'C');
    }
    $pdf->Cell($w[5], 4, '(HARI)', 'LR', 0, 'C');
    $pdf->Cell($w[6], 4, '(JAM)', 'LR', 0, 'C');
    $pdf->Cell($w[7], 4, '', 'LR', 0, 'C');
    $pdf->Cell($w[8], 4, '(GAJI + TUNJANGAN)', 'LR', 0, 'C');
    $pdf->Ln();
//=========0, 1,  2,  3,  4,  5,  6,  7=====//
//Color and font restoration
    $pdf->setX(60);
    $pdf->SetFillColor(224, 235, 255);
    $pdf->SetTextColor(1);
    $pdf->SetFont('Arial', '', 6);
//Data

    $fill = false;
    $i = 0;

    //$num = count($query_absensi);

    $data_result = array();
    $jlh_jam = 0;

    while ($data = mysqli_fetch_array($query_karyawan)) {
        $query_jenis_tunjangan2 = mysqli_query($koneksi,"SELECT * FROM jenis_tunjangan");
        $nou = 0;
        $jumlah_btunjangan = 0;
        $result_btunjangan = array();

        while ($data_jt2 = mysqli_fetch_array($query_jenis_tunjangan2)) {
            $id_jenis_tunjangan = $data_jt2['id_jenis_tunjangan'];

            $query_besar_tunjangan = mysqli_query($koneksi,"SELECT * FROM tunjangan_jabatan
										  WHERE nip = '$data[nip]'
										  AND id_jenis_tunjangan = '$id_jenis_tunjangan'") or die(mysqli_error());
            $data_bt = mysqli_fetch_array($query_besar_tunjangan);
            if ($data_bt['besar_tunjangan'] != NULL) {
                $btunjangan = $data_bt['besar_tunjangan'];
            } else {
                $btunjangan = 0;
            }

            $jumlah_btunjangan += $btunjangan;
            $result_btunjangan[] = $btunjangan;

            $nou++;
        }

        $query_jlh_kehadiran = mysqli_query($koneksi,"SELECT HOUR(timediff(waktu_keluar, waktu_masuk)) AS jlh_jam, kehadiran
									  FROM absensi
									  WHERE nip = '$data[nip]' AND kehadiran = 'Hadir'
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

            $jumlah_jam_kehadiran += $jlh_jam; //HITUNG TOTAL JAM KERJA 1 BULAN (26 HARI)

            $nou++;
        }

        $query_gapok = mysqli_query($koneksi,"SELECT * FROM jabatan j
								JOIN karyawan k ON k.id_jabatan = j.id_jabatan
								WHERE nip = '$data[nip]' GROUP BY nip");
        $data_gapok = mysqli_fetch_array($query_gapok);

        $gaji_jam = $data_gapok['gapok'] / 208; // gaji per jam = GAPOK/8jam x 26


        $data_result[] = array(
            'nip' => $data['nip'],
            'nama_karyawan' => $data['nama_karyawan'],
            'gjam' => $gaji_jam,
            'jkehadiran' => $jumlah_kehadiran,
            'btunjangan' => $result_btunjangan,
            'jjk' => $jumlah_jam_kehadiran,
            'jbtunjangan' => $jumlah_btunjangan,
        );
        //var_dump($data_result);die();
    }

    $j = 0;
    $total_gapok = 0;
    $total_jgapok = 0;
    foreach ($data_result as $row) {
        $pdf->setX(60);
        $i++;
        $pdf->Cell($w[0], $linespace, $i, 'TLRB', 0, 'L', $fill); //NOMOR
        $pdf->Cell($w[1], $linespace, $row['nip'], 'TLRB', 0, 'L', $fill); //NIS
        $pdf->Cell($w[2], $linespace, ucwords(strtolower($row['nama_karyawan'])), 'TLRB', 0, 'L', $fill); //NAMA KARYAWAN

        $query_jenis_tunjangan4 = mysqli_query($koneksi,"SELECT * FROM jenis_tunjangan");
        $nou4 = 0;
        while ($data_tjt4 = mysqli_fetch_array($query_jenis_tunjangan4)) {
            @$total_tunjangan[$nou4] += $row['btunjangan'][$nou4];
            $nou4++;
        }

        foreach ($row['btunjangan'] as $row_ => $value_) {
            $pdf->Cell($w[4], $linespace, indo_number($value_), 'TLRB', 0, 'R', $fill); //JAWABAN
        }

        $pdf->Cell($w[5], $linespace, $row['jkehadiran'], 'TLRB', 0, 'C', $fill); //JUMLAH KANAN
        $pdf->Cell($w[6], $linespace, $row['jjk'], 'TLRB', 0, 'C', $fill); //JUMLAH KANAN

        $gaji = $row['jjk'] * $row['gjam']; //HITUNG GAJI = JUMLAH JAM KERJA x GAJI PER JAM
        $jgaji = ($row['jjk'] * $row['gjam']) + $row['jbtunjangan']; //HITUNG GAJI = JUMLAH JAM KERJA x GAJI PER JAM
        $total_gapok += $gaji; //TOTAL GAPOK SAJA
        $total_jgapok += $jgaji; //TOTAL JUMLAH GAPOK

        $pdf->Cell($w[7], $linespace, indo_number($gaji), 'TLRB', 0, 'R', $fill); //JUMLAH KANAN
        $pdf->Cell($w[8], $linespace, indo_number($jgaji), 'TLRB', 0, 'R', $fill); //JUMLAH KANAN
        $fill = !$fill;
        $pdf->Ln();
        $j++;
    }
//var_dump($total_tunjangan);die();
    $pdf->setX(605060);
    $pdf->SetFont('Arial', 'B', '6');
    $pdf->Cell($w[0] + $w[1] + $w[2], $linespace, 'TOTAL', 'TLRB', 0, 'R', $fill); //NOMOR
    $query_jenis_tunjangan5 = mysqli_query($koneksi,"SELECT * FROM jenis_tunjangan") or die(mysqli_error());
    $nos5 = 0;
    while ($data_tjt5 = mysqli_fetch_array($query_jenis_tunjangan5)) {
        $pdf->Cell($w[4], $linespace, indo_number($total_tunjangan[$nos5]), 'TLRB', 0, 'R', $fill); //JAWABAN
        $nos5++;
    }
    $pdf->Cell($w[5], $linespace, '-', 'TLRB', 0, 'C', $fill);
    $pdf->Cell($w[6], $linespace, '-', 'TLRB', 0, 'C', $fill);
    $pdf->Cell($w[7], $linespace, indo_number($total_gapok), 'TLRB', 0, 'R', $fill); //TOTAL GAPOK
    $pdf->Cell($w[8], $linespace, indo_number($total_jgapok), 'TLRB', 0, 'R', $fill); //TOTAL JUMLAH GAPOK
    $fill = !$fill;
    $pdf->Ln();

    $query_dirut = mysqli_query($koneksi,"SELECT * FROM karyawan k
							INNER JOIN jabatan j ON k.id_jabatan=j.id_jabatan 
							WHERE nama_jabatan = 'Kepala Dinas'") or die(mysqli_error());
    $data_dirut = mysqli_fetch_array($query_dirut);

    $pdf->Ln();
//footer selalu sama
    $pdf->SetX(-330);
    $pdf->Cell(0, 6, 'Mengetahui,', 0, 1, 'C');
    $pdf->SetFont('Arial', 'B', '7');
    $pdf->SetX(-330);
    $pdf->Cell(0, 6, 'Kepala Dinas', 0, 0, 'C');
    $pdf->SetX(50);
    $pdf->Cell(0, 6, 'Disiapkan Oleh', 0, 1, 'C');
    $pdf->Ln(10);
    $pdf->SetFont('Arial', 'BU', '7');
    $pdf->SetX(-330);
    $pdf->Cell(0, 6, $data_dirut['nama_karyawan'], 0, 0, 'C'); //NAMA DIREKTUR
    $pdf->SetX(50);
    $pdf->Cell(0, 6, $_SESSION['nama'], 0, 1, 'C'); //NAMA KEUANGAN
    $pdf->ln(-3);

    $pdf->SetFont('Arial', 'B', '7');
    $pdf->SetX(-330);
    $pdf->Cell(0, 6, 'NIP. ' . $data_dirut['nip'], 0, 0, 'C'); //NIP DIREKTUR
    $pdf->SetX(50);
    $pdf->Cell(0, 6, 'NIP. ' . $_SESSION['id_pengguna'], 0, 1, 'C'); //NIP KEUANGAN

    $pdf->Output();
}
