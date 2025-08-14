<?php
include "connect.php";

if (isset($_GET['hapus'])) {
  $id = intval($_GET['hapus']);
  if ($id > 0) {
    $result = $koneksi->query("SELECT * FROM inventaris WHERE id = $id");
    if ($result->num_rows > 0) {
      $data = $result->fetch_assoc(); // Ambil data gambar
      $gambar = $data['gambar']; // Nama file gambar dari database

      if ($gambar !== 'default.jpg' && !empty($gambar) && file_exists("img/$gambar")) {
        unlink("img/$gambar");
      }


      // Hapus dari database
      $koneksi->query("DELETE FROM inventaris WHERE id = $id");

      echo "<script>
              alert('Data berhasil dihapus.');
              window.location.href = 'index.php';
            </script>";
    } else {
      // Jika tidak ditemukan, beri peringatan
      echo "<script>
              alert('Data tidak ditemukan.');
              window.location.href = 'index.php';
            </script>";
    }
  } else {
    // Jika ID tidak valid
    echo "<script>
            alert('ID tidak valid!');
            window.location.href = 'index.php';
          </script>";
  }
}
