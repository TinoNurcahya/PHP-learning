<?php
$host = "localhost";  // Sesuaikan dengan host database
$user = "root";       // Username database
$pass = "";           // Password database
$dbname = "sistembarang";    // Nama database

$koneksi = mysqli_connect($host, $user, $pass, $dbname);

// Cek koneksi
if ($koneksi->connect_error) {
  die("Koneksi gagal: " . $koneksi->connect_error);
}
?>