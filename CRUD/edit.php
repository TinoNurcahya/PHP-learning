<?php
include "check_cookie.php";


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
  $gambar = $inventaris['gambar']; // default ambil gambar lama

  // Proses gambar jika diunggah
  if (!empty($_FILES['gambar']['name'])) {
    $allowed_types = ['image/jpeg', 'image/png', 'image/jpg'];
    $file_type = $_FILES['gambar']['type'];
    $file_size = $_FILES['gambar']['size'];

    if (!in_array($file_type, $allowed_types)) {
      echo "<script>alert('File harus berupa JPG atau PNG.'); window.location.href='index.php';</script>";
      exit;
    }

    if ($file_size > 2 * 1024 * 1024) {
      echo "<script>alert('Ukuran file maksimal 2MB.'); window.location.href='index.php';</script>";
      exit;
    }

    $nama_file_baru = uniqid() . '_' . basename($_FILES['gambar']['name']);
    $lokasi_simpan = "img/" . $nama_file_baru;

    // simpan ke folder
    if (move_uploaded_file($_FILES['gambar']['tmp_name'], $lokasi_simpan)) {
      if ($gambar !== 'default.jpg') {
        @unlink("img/" . $gambar); // hapus gambar lama
      }
      $gambar = $nama_file_baru;
    } else {
      echo "<script>alert('Gagal mengupload foto.'); window.location.href='index.php';</script>";
      exit;
    }
  }

  // Jalankan query UPDATE
  $query = $koneksi->query("UPDATE inventaris 
    SET nama='$nama', kategori='$kategori', jumlah='$jumlah', lokasi='$lokasi', gambar='$gambar' 
    WHERE id=$id");

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
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
  <link rel="shortcut icon" href="img/gajah.png" type="image/x-icon">
  <link rel="stylesheet" href="style.css">
  <title>Edit Data Sistem Inventaris Barang Sekolah</title>
</head>

<body class="bg-light">
  <div class="container mt-5">
    <h1>Edit Data Sistem Inventaris Barang Sekolah</h1>
    <form method="post" class="card p-4" enctype="multipart/form-data">
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
      <div class="mb-3 d-flex align-content-between">
        <label for="gambar">Gambar</label>
        <img src="img/<?= !empty($inventaris['gambar']) ? $inventaris['gambar'] : 'default.jpg' ?>" alt="Foto Profil" style="height:100px;" loading="lazy" class="rounded-3 mx-5">
      </div>
      <input type="file" name="gambar" id="gambar" class="form-control mb-5">
      <div class="d-grid gap-2">
        <button type="submit" name="update" class="btn btn-success">Simpan Perubahan</button>
        <a href="index.php" class="btn btn-outline-danger">Kembali</a>
      </div>
    </form>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
</body>

</html>