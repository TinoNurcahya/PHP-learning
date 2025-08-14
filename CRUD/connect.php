<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "sistembarang";

// OOP style
$koneksi = new mysqli($host, $user, $pass, $dbname);

if ($koneksi->connect_error) {
  die("Koneksi gagal: " . $koneksi->connect_error);
}
?>