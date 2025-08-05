<?php
include "connect.php";
$id = intval($_GET['id']);
$hasil = $koneksi->query("SELECT * FROM inventaris WHERE id = $id");
$inventaris = $hasil->fetch_assoc();

if ($hasil->num_rows === 0) {
  // Jika data tidak ditemukan, kembali ke index
  echo "<script>
          alert('Data tidak ditemukan!');
          window.location.href = 'index.php';
        </script>";
  exit;
}

if (isset($_POST['update'])) {
  $nama = $koneksi->real_escape_string($_POST['nama']);
  $kategori = $koneksi->real_escape_string($_POST['kategori']);
  $jumlah = $koneksi->real_escape_string($_POST['jumlah']);
  $lokasi = $koneksi->real_escape_string($_POST['lokasi']);

  $query = $koneksi->query("UPDATE inventaris SET nama='$nama', kategori='$kategori', jumlah='$jumlah', lokasi='$lokasi'  WHERE id=$id");

  if ($query) {
    echo "<script>
            alert('Sukses update data inventaris');
            window.location.href = 'index.php';
          </script>";
  } else {
    echo "<script>
            alert('Gagal update data');
            window.location.href = 'index.php';
          </script>";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Edit Data Sistem Inventaris Barang Sekolah</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
  <div class="container mt-5">
    <h2>Edit Data Sistem Inventaris Barang Sekolah</h2>
    <form method="post" class="card p-4">
      <div class="mb-3">
        <label for="nama">Nama</label>
        <input type="text" name="nama" class="form-control" id="nama" value="<?= htmlspecialchars($inventaris['nama']) ?>">
      </div>
      <div class="mb-3">
        <label for="kategori">kategori</label>
        <input type="text" name="kategori" class="form-control" id="kategori" value="<?= htmlspecialchars($inventaris['kategori']) ?>">
      </div>
      <div class="mb-3">
        <label for="jumlah">Jumlah</label>
        <input type="text" name="jumlah" class="form-control" id="jumlah" value="<?= htmlspecialchars($inventaris['jumlah']) ?>">
      </div>
      <div class="mb-3">
        <label for="lokasi">Lokasi</label>
        <textarea name="lokasi" class="form-control" id="lokasi" rows="3"><?= htmlspecialchars($inventaris['lokasi']) ?></textarea>
      </div>
      <div class="d-grid gap-2">
        <button type="submit" name="update" class="btn btn-success">Simpan Perubahan</button>
        <a href="index.php" class="btn btn-outline-danger">Kembali</a>
      </div>
    </form>
  </div>
</body>

</html>