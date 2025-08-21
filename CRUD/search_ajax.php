<?php
include "check_cookie.php";

$keyword = $_GET['keyword'] ?? '';
$where = "";

if (!empty($keyword)) {
  $safe_keyword = $koneksi->real_escape_string($keyword);
  $where = "WHERE nama LIKE '$safe_keyword%' 
          OR nama LIKE '%$safe_keyword%' 
          OR kategori LIKE '%$safe_keyword%'";
}

$data = $koneksi->query("SELECT * FROM inventaris $where ORDER BY waktu DESC LIMIT 5");

$no = 1;
if ($data->num_rows > 0) {
  while ($row = $data->fetch_assoc()) {
    echo "<tr>
      <td>{$no}</td>
      <td>" . htmlspecialchars($row['nama']) . "</td>
      <td>" . htmlspecialchars($row['kategori']) . "</td>
      <td>" . htmlspecialchars($row['jumlah']) . "</td>
      <td>" . nl2br(htmlspecialchars($row['lokasi'])) . "</td>
      <td>" . nl2br(htmlspecialchars($row['waktu'])) . "</td>
      <td><img src='img/" . (!empty($row['gambar']) ? $row['gambar'] : 'default.jpg') . "' style='height:100px;' class='rounded-3'></td>
      <td>
        <a href='edit.php?id={$row['id']}' class='btn btn-sm btn-warning'><i class='fas fa-edit'></i></a>
        <a href='hapus.php?hapus={$row['id']}' onclick=\"return confirm('Yakin hapus?')\" class='btn btn-sm btn-danger'><i class='fas fa-trash'></i></a>
      </td>
    </tr>";
    $no++;
  }
} else {
  echo "<tr><td colspan='7' class='text-center text-muted'>Data tidak ditemukan.</td></tr>";
}
