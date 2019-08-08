<?php
// definisikan koneksi ke database
$server = "localhost";
$username = "root";
$password = "";
$database = "penggajian";

// Koneksi dan memilih database di server
// mysqli_connect($server,$username,$password) or die("Koneksi gagal");
// mysqli_select_db($database) or die("Database tidak bisa dibuka");

$koneksi = mysqli_connect($server, $username, $password, $database);

if (mysqli_connect_errno()) {
	echo 'Gagal melakukan koneksi ke Database : '.mysqli_connect_error($koneksi);

}
?>
