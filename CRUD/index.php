<?php include "connect.php";

if (isset($_POST['submit'])) {
  $nama = $koneksi->real_escape_string($_POST['nama']);
  $kategori = $koneksi->real_escape_string($_POST['kategori']);
  $jumlah = $koneksi->real_escape_string($_POST['jumlah']);
  $lokasi = $koneksi->real_escape_string($_POST['lokasi']);
  $koneksi->query("INSERT INTO inventaris (nama, kategori, jumlah, lokasi) VALUES ('$nama', '$kategori', '$jumlah', '$lokasi')");
  header("Location: index.php");
}


if (isset($_GET['hapus'])) {
  $id = intval($_GET['hapus']);
  if ($id > 0) {
    $cek = $koneksi->query("SELECT id FROM inventaris WHERE id = $id");

    if ($cek->num_rows > 0) {
      // Jika data ditemukan, lakukan hapus
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
$data = $koneksi->query("SELECT * FROM inventaris");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://kit.fontawesome.com/c8f4e6dde8.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="style.css">
  <title>Sistem Inventaris Barang Sekolah</title>
</head>

<body>
  <div class="container mt-5 mb-4">
    <h2 class="mb-4">Sistem Inventaris Barang Sekolah</h2>

    <!-- Form Input -->
    <div class="card mb-4">
      <div class="card-header text-center font-weight-bold">Isi Barang</div>
      <div class="card-body">
        <form method="post">
          <div class="mb-3">
            <label for="nama">Nama</label>
            <input type="text" name="nama" class="form-control" required id="nama">
          </div>
          <div class="mb-3">
            <label for="kategori">Kategori</label>
            <input type="text" name="kategori" class="form-control" id="kategori" required>
          </div>
          <div class="mb-3">
            <label for="jumlah">Jumlah</label>
            <input type="number" name="jumlah" class="form-control" id="jumlah" min="1"></input>
          </div>
          <div class="mb-3">
            <label for="lokasi">Lokasi</label>
            <textarea name="lokasi" class="form-control" id="lokasi" rows="3"></textarea>
          </div>
          <button type="submit" name="submit" class="btn btn-success">
            <i class="fas fa-paper-plane"></i> Kirim
          </button>
        </form>
      </div>
    </div>

    <!-- Daftar Barangnya -->
    <div class="card">
      <div class="card-header text-center font-weight-bold">Daftar Inventaris Barang</div>
      <div class="card-body table-responsive">
        <table class="table table-bordered table-striped">
          <thead class="table-secondary">
            <tr>
              <th>Nama</th>
              <th>Kategori</th>
              <th>Jumlah</th>
              <th>Lokasi</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = $data->fetch_assoc()): ?>
              <tr>
                <td><?= htmlspecialchars($row['nama']) ?></td>
                <td><?= htmlspecialchars($row['kategori']) ?></td>
                <td><?= htmlspecialchars($row['jumlah']) ?></td>
                <td><?= nl2br(htmlspecialchars($row['lokasi'])) ?></td>
                <td>
                  <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">
                    <i class="fas fa-edit"></i>
                  </a>
                  <a href="?hapus=<?= $row['id'] ?>" onclick="return confirm('Yakin hapus?')" class="btn btn-sm btn-danger">
                    <i class="fas fa-trash"></i>
                  </a>
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>

</html>