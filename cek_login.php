<?php
include "fungsi/koneksi.php";
//isset($_POST["submit"]);
$username = $_POST['nip'];
$pass     = md5($_POST['password']);

$login=mysqli_query($koneksi,"SELECT * FROM karyawan
        JOIN jabatan ON jabatan.id_jabatan = karyawan.id_jabatan
        WHERE nip='$username' AND password='$pass' AND nama_jabatan='Staff Keuangan'")or die(mysqli_error($koneksi));
$ketemu=mysqli_num_rows($login);
$r=mysqli_fetch_array($login);

// Apabila username dan password ditemukan
if ($ketemu > 0){
  session_start();
  include "timeout.php";

  $_SESSION['id_pengguna']     = $r['nip'];
  $_SESSION['nama']            = $r['nama_karyawan'];
  $_SESSION['passuser']        = $pass;
  $_SESSION['hak_akses']       = 'admin';
  //$_SESSION['foto']            = $r['foto_admin'];


  // session timeout
  $_SESSION['login'] = 1;
  timer();

	$sid_lama = session_id();

	session_regenerate_id();

	$sid_baru = session_id();

  header('location:index.php?modul=home');
}
else{
  echo "<script>alert('Username/ Password yang anda masukkan salah, silahkan coba kembali !.'); window.location = 'index.php'</script>";
}
?>
