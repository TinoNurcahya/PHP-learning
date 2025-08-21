<?php
include "check_cookie.php";
header("Content-Type: application/json");

$keyword = $_GET['keyword'] ?? '';
$where = "";

if (!empty($keyword)) {
  $safe_keyword = $koneksi->real_escape_string($keyword);
  $where = "WHERE nama LIKE '$safe_keyword%' 
  OR nama LIKE '%$safe_keyword%' 
  OR kategori LIKE '%$safe_keyword%'";
}

$data = $koneksi->query("SELECT * FROM inventaris $where ORDER BY waktu DESC LIMIT 5");

$result = [];
while ($row = $data->fetch_assoc()) {
  $result[] = [
    "id" => $row["id"],
    "nama" => $row["nama"],
    "kategori" => $row["kategori"],
    "jumlah" => $row["jumlah"],
    "lokasi" => $row["lokasi"],
    "waktu" => $row["waktu"],
    "gambar" => !empty($row["gambar"]) ? $row["gambar"] : "default.jpg"
  ];
}

echo json_encode($result);
?>