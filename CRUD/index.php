<?php
include "check_cookie.php";

// ----------------- Konfigurasi Pagination -----------------
$limit = 5;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;


if (isset($_POST['submit'])) {
  $nama = $koneksi->real_escape_string($_POST['nama']);
  $kategori = $koneksi->real_escape_string($_POST['kategori']);
  $jumlah = $koneksi->real_escape_string($_POST['jumlah']);
  $lokasi = $koneksi->real_escape_string($_POST['lokasi']);

  // default jika tidak ada gambar
  $nama_file_baru = "default.jpg";

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
    if (!move_uploaded_file($_FILES['gambar']['tmp_name'], $lokasi_simpan)) {
      die("Gagal mengupload foto.");
    }
  }

  // Query insert tunggal, dengan atau tanpa gambar
  $query = "INSERT INTO inventaris (nama, kategori, jumlah, lokasi, gambar) 
            VALUES ('$nama', '$kategori', '$jumlah', '$lokasi', '$nama_file_baru')";
  $koneksi->query($query);

  header("Location: index.php");
  exit;
}

// ----------------- Pencarian + Pagination -----------------
$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
if (!empty($keyword)) {
  $safe_keyword = $koneksi->real_escape_string($keyword);
  $where = "WHERE nama LIKE '%$safe_keyword%' 
            OR kategori LIKE '%$safe_keyword%' 
            OR jumlah LIKE '%$safe_keyword%' 
            OR lokasi LIKE '%$safe_keyword%'";
} else {
  $where = "";
}

// Hitung total data
$total_result = $koneksi->query("SELECT COUNT(*) as total FROM inventaris $where");
$total_data = $total_result->fetch_assoc()['total'];
$total_pages = ceil($total_data / $limit);

// Validasi halaman setelah tahu total pages
if ($page < 1) {
  $page = 1;
} elseif ($page > $total_pages && $total_pages > 0) {
  $page = $total_pages;
}

$offset = ($page - 1) * $limit;
$no = $offset + 1;

// Query data dengan LIMIT
$data = $koneksi->query("SELECT * FROM inventaris $where ORDER BY waktu DESC LIMIT $limit OFFSET $offset");
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
  <link rel="shortcut icon" href="img/gajah.png" type="image/x-icon">
  <link rel="stylesheet" href="style.css">
  <title>Sistem Inventaris Barang Sekolah</title>
</head>

<body>
  <div class="container mt-5 mb-4">
    <h3 class="mb-4 text-white">Selamat datang, <?= $_SESSION['username']; ?>👋</h3>
    <a class="btn btn-danger text-white" href="logout.php"><i class="fa fa-sign-out px-2"></i> Logout</a>
    <h1 class="mb-4">Sistem Inventaris Barang Sekolah</h1>

    <!-- Form Input -->
    <div class="card mb-4">
      <div class="card-header text-center font-weight-bold">Isi Barang</div>
      <div class="card-body">
        <form method="post" enctype="multipart/form-data">
          <div class="mb-3 position-relative">
            <label for="nama">Nama</label>
            <input type="text" name="nama" class="form-control" required id="nama" autofocus autocomplete="off">
          </div>
          <div class="mb-3">
            <label for="kategori">Kategori</label>
            <input type="text" name="kategori" class="form-control" id="kategori" required autocomplete="off">
          </div>
          <div class="mb-3">
            <label for="jumlah">Jumlah</label>
            <input type="number" name="jumlah" class="form-control" id="jumlah" min="1" required></input>
          </div>
          <div class="mb-3">
            <label for="lokasi">Lokasi</label>
            <textarea name="lokasi" class="form-control" id="lokasi" rows="3" required></textarea>
          </div>
          <div class="mb-3">
            <label for="gambar">Gambar</label>
            <input type="file" name="gambar" class="form-control" id="gambar"></input>
          </div>
          <button type="submit" name="submit" class="btn btn-outline-primary">
            <i class="fas fa-paper-plane"></i> Kirim
          </button>
        </form>
      </div>
    </div>

    <!-- Searching -->
    <form action="" method="get">
      <div class="m-5 d-flex align-items-center gap-2">
        <input type="text" name="keyword" class="form-control" placeholder="Cari data..." autocomplete="off" value="<?= isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : '' ?>">
        <button type="submit" name="cari" class="btn btn-success w-20">
          <i class="fas fa-search"></i>
        </button>
        <a href="index.php" class="btn btn-info w-20">
          <i class="fas fa-arrow-left"></i>
        </a>
      </div>
    </form>

    <!-- Daftar Barangnya -->
    <div class="card">
      <div class="card-header text-center font-weight-bold">Daftar Inventaris Barang</div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered table-striped ">
            <thead class="table-secondary">
              <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Kategori</th>
                <th>Jumlah</th>
                <th>Lokasi</th>
                <th>Gambar</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php if ($data->num_rows > 0): ?>
                <?php while ($row = $data->fetch_assoc()): ?>
                  <tr>
                    <td><?= $no++; ?></td>
                    <td><?= htmlspecialchars($row['nama']) ?></td>
                    <td><?= htmlspecialchars($row['kategori']) ?></td>
                    <td><?= htmlspecialchars($row['jumlah']) ?></td>
                    <td><?= nl2br(htmlspecialchars($row['lokasi'])) ?></td>
                    <td><img src="img/<?= !empty($row['gambar']) ? ($row['gambar']) : 'default.jpg' ?>" alt="Foto Profil" style="height:100px;" loading="lazy" class="rounded-3"></td>

                    <td>
                      <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">
                        <i class="fas fa-edit"></i>
                      </a>
                      <a href="hapus.php?hapus=<?= $row['id'] ?>" onclick="return confirm('Yakin hapus?')" class="btn btn-sm btn-danger">
                        <i class="fas fa-trash"></i>
                      </a>
                    </td>
                  </tr>
                <?php endwhile; ?>
              <?php else: ?>
                <tr>
                  <td colspan="7" class="text-center text-muted">Data tidak ditemukan.</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>

          <!-- Pagination -->
          <?php if ($total_pages > 1): ?>
            <nav aria-label="Page navigation example">
              <ul class="pagination justify-content-center mt-3">
                <!-- Tombol Previous -->
                <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                  <a class="page-link"
                    href="?page=<?= max(1, $page - 1) ?><?= !empty($keyword) ? '&keyword=' . urlencode($keyword) : '' ?>">
                    <i class="fa-solid fa-angle-left"></i>
                  </a>
                </li>

                <?php
                $range = 1; // jumlah halaman sebelum/sesudah halaman aktif
                $start = max(1, $page - $range);
                $end   = min($total_pages, $page + $range);

                // Halaman pertama
                if ($start > 1) {
                  echo '<li class="page-item"><a class="page-link" href="?page=1' . (!empty($keyword) ? '&keyword=' . urlencode($keyword) : '') . '">1</a></li>';
                  if ($start > 2) {
                    echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                  }
                }

                // Halaman tengah (sekitar halaman aktif)
                for ($i = $start; $i <= $end; $i++) {
                  echo '<li class="page-item ' . ($i == $page ? 'active' : '') . '">
                <a class="page-link" href="?page=' . $i . (!empty($keyword) ? '&keyword=' . urlencode($keyword) : '') . '">' . $i . '</a>
              </li>';
                }

                // Halaman terakhir
                if ($end < $total_pages) {
                  if ($end < $total_pages - 1) {
                    echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                  }
                  echo '<li class="page-item"><a class="page-link" href="?page=' . $total_pages . (!empty($keyword) ? '&keyword=' . urlencode($keyword) : '') . '">' . $total_pages . '</a></li>';
                }
                ?>

                <!-- Tombol Next -->
                <li class="page-item <?= $page >= $total_pages ? 'disabled' : '' ?>">
                  <a class="page-link"
                    href="?page=<?= min($total_pages, $page + 1) ?><?= !empty($keyword) ? '&keyword=' . urlencode($keyword) : '' ?>">
                    <i class="fa-solid fa-angle-right"></i>
                  </a>
                </li>
              </ul>
            </nav>
          <?php endif; ?>

        </div>
      </div>
    </div>

    <script>
      function autocomplete(inp, arr) {
        var currentFocus;

        inp.addEventListener("input", function(e) {
          var a, b, i, val = this.value;
          closeAllLists();
          if (!val) return false;

          currentFocus = -1;
          a = document.createElement("DIV");
          a.setAttribute("id", this.id + "autocomplete-list");
          a.classList.add("autocomplete-items", "list-group", "position-absolute", "w-100", "z-3", "mt-1");

          this.parentNode.appendChild(a);

          let foundMatch = false;

          for (i = 0; i < arr.length; i++) {
            if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
              foundMatch = true;
              b = document.createElement("DIV");
              b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
              b.innerHTML += arr[i].substr(val.length);
              b.classList.add("list-group-item", "list-group-item-action");
              b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
              b.addEventListener("click", function(e) {
                inp.value = this.getElementsByTagName("input")[0].value;
                closeAllLists();
              });
              a.appendChild(b);
            }
          }

          // jika tidak ada match, hilangkan container autocomplete
          if (!foundMatch) {
            closeAllLists();
          }
        });

        inp.addEventListener("keydown", function(e) {
          var x = document.getElementById(this.id + "autocomplete-list");
          if (x) x = x.getElementsByTagName("div");
          if (e.keyCode == 40) {
            currentFocus++;
            addActive(x);
          } else if (e.keyCode == 38) {
            currentFocus--;
            addActive(x);
          } else if (e.keyCode == 13) {
            if (currentFocus > -1 && x) {
              e.preventDefault();
              x[currentFocus].click();
            }
          }
        });

        function addActive(x) {
          if (!x) return false;
          removeActive(x);
          if (currentFocus >= x.length) currentFocus = 0;
          if (currentFocus < 0) currentFocus = x.length - 1;
          x[currentFocus].classList.add("active");
        }

        function removeActive(x) {
          for (var i = 0; i < x.length; i++) {
            x[i].classList.remove("active");
          }
        }

        function closeAllLists(elmnt) {
          var x = document.getElementsByClassName("autocomplete-items");
          for (var i = 0; i < x.length; i++) {
            if (elmnt != x[i] && elmnt != inp) {
              if (x[i] && x[i].parentNode) {
                x[i].parentNode.removeChild(x[i]);
              }
            }
          }
        }

        document.addEventListener("click", function(e) {
          closeAllLists(e.target);
        });
      }

      var namaList = <?php
                      $res = mysqli_query($koneksi, "SELECT DISTINCT nama FROM inventaris WHERE nama IS NOT NULL");
                      $list = [];
                      while ($row = mysqli_fetch_assoc($res)) {
                        $list[] = $row['nama'];
                      }
                      echo json_encode($list);
                      ?>;
      autocomplete(document.getElementById("nama"), namaList);

      var kategoriList = <?php
                          $res = mysqli_query($koneksi, "SELECT DISTINCT kategori FROM inventaris WHERE kategori IS NOT NULL");
                          $list = [];
                          while ($row = mysqli_fetch_assoc($res)) {
                            $list[] = $row['kategori'];
                          }
                          echo json_encode($list);
                          ?>;
      autocomplete(document.getElementById("kategori"), kategoriList);
    </script>
    <script src="https://kit.fontawesome.com/c8f4e6dde8.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
</body>

</html>