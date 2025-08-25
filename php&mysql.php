<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "namadb";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
  die("Koneksi gagal: " . $conn->connect_error);
}
?>

//* ========== Gaya prosedural (mysqli_connect()) ==========
// mencacah data hasil query
// 4 cara :
// mysqli_fetch_row() : array numerik
// mysqli_fetch_assoc() : array associative
// mysqli_fetch_array() : keduanya
// mysqli_fetch_object() : object

//* ========== Gaya OOP ($conn = new mysqli) ==========
// 4 cara :
// $result->fetch_row() : array numerik
// $result->fetch_assoc : array associative
// $result->fetch_array : keduanya
// $result->fetch_object : object


//* ========== prepare Statement ==========
<?php
$stmt = $conn->prepare("SELECT * FROM admin WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$data_user = $result->fetch_assoc();
$stmt->close();

// ambil hasil
if ($result->num_rows > 0) {
  $data_user = $result->fetch_assoc();
  echo "Username: " . $data_user['username'] . "<br>";
  echo "Email: " . $data_user['email'] . "<br>";
} else {
  echo "User tidak ditemukan!";
}

$stmt->close();
?>

//* ========== query biasa ==========
<?php
$sql = "SELECT * FROM admin WHERE username = '$username'";
$result = $conn->query($sql);

// ambil hasil
if ($result->num_rows > 0) {
  $data_user = $result->fetch_assoc();
  echo "Username: " . $data_user['username'] . "<br>";
  echo "Email: " . $data_user['email'] . "<br>";
} else {
  echo "User tidak ditemukan!";
}
?>

//* ========== FORM ==========
========== $_SERVER["REQUEST_METHOD"] == "POST"
Kapan benar : Saat request pakai POST (form, API, dsb)
Kelebihan : Tidak tergantung nama tombol submit
Kekurangan: Akan true walaupun POST datang dari tempat lain (bukan form yang dimaksud)

========== isset($_POST['submit'])
Kapan benar : Saat tombol submit dengan name=submit diklik
Kelebihan : Lebih spesifik ke tombol tertentu
Kekurangan: Kalau tombol submit tidak punya name, tidak akan bekerja.

<?php
if (isset($_POST['submit'])) {
  $nama = $conn->real_escape_string($_POST['nama']);  //input dgn name="nama"

  $query = "INSERT INTO inventaris (nama) 
            VALUES ('$nama')";
  $conn->query($query);
}
?>

//* ========== MENAMBAHKAN GAMBAR ==========
<?php
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
?>

========== trim() dan real_escape_string
Kalau pakai Prepared Statement ($stmt->bind_param()), kamu tidak perlu real_escape_string() karena binding parameter sudah aman.
Biasanya:

Gunakan trim() untuk membersihkan input teks.

Gunakan password_hash() untuk password.

Gunakan Prepared Statement untuk query agar tidak perlu escape manual.


//* ========== REGISTRASI ==========
<?php
session_start(); // Mulai session (berguna kalau nanti setelah registrasi mau otomatis login)
include "connect.php";

// Cek apakah tombol "registrasi" ditekan
if (isset($_POST['registrasi'])) {
  $username = trim($_POST["username"]);  // Ambil username dari input, hapus spasi depan & belakang
  $email = trim($_POST["email"]);        // Ambil email dari input
  $password = $_POST["password"];        // Ambil password dari input
  $konfpassword = $_POST["konfpassword"]; // Ambil konfirmasi password dari input

  // --- CEK APAKAH EMAIL SUDAH TERDAFTAR ---
  $stmt = $koneksi->prepare("SELECT id FROM user WHERE email = ?"); // Query cek email
  $stmt->bind_param("s", $email); // Binding parameter (s = string)
  $stmt->execute();
  $stmt->store_result();

  if ($stmt->num_rows > 0) { // Kalau ada baris berarti email sudah dipakai
    echo "<script>alert('Email sudah digunakan, silahkan gunakan yang lain!'); window.location.href='registrasi.php';</script>";
    $stmt->close();
    exit;
  }
  $stmt->close(); // Tutup statement

  // --- CEK KONFIRMASI PASSWORD ---
  if ($password !== $konfpassword) { // Kalau password dan konfirmasi beda
    echo "<script>alert('Pastikan kata sandi yang kamu masukkan sama!'); window.location.href='registrasi.php';</script>";
    exit;
  }

  // --- HASH PASSWORD ---
  $hashed_password = password_hash($password, PASSWORD_DEFAULT); 

  // --- SIMPAN DATA KE DATABASE ---
  $stmt_insert = $koneksi->prepare("INSERT INTO user (username, email, password) VALUES (?, ?, ?)");
  $stmt_insert->bind_param("sss", $username, $email, $hashed_password);

  if ($stmt_insert->execute()) {
    echo "<script>alert('Berhasil mendaftar! Silakan login.'); window.location.href='login.php';</script>";
  } else {
    echo "<script>alert('Terjadi kesalahan saat mendaftar.'); window.location.href='registrasi.php';</script>";
  }

  $stmt_insert->close(); // Tutup statement insert
  $koneksi->close(); // Tutup koneksi database
}
?>



//* ========== LOGIN ==========
<?php
session_start();
include "connect.php";

$error = null;

if (isset($_POST['login'])) {
  $username = trim($_POST["username"]);
  $password = $_POST["password"];

  if (empty($username) || empty($password)) {
    $error = "Username/email dan password harus diisi!";
  } else {
    $stmt = $koneksi->prepare("SELECT * FROM user WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();

      if (password_verify($password, $row["password"])) {
        $_SESSION["id"] = $row["id"];
        $_SESSION["username"] = $row["username"];
        header("Location: index.php");
        exit;
      } else {
        $error = "Password salah!";
      }
    } else {
      $error = "Username/email tidak ditemukan!";
    }
    $stmt->close();
  }
}
?>



//* ========== LOGIN dan REMEMBER(cookie) ==========
<?php
session_start();
include "connect.php";

$error = null; // untuk menampung pesan error

// cek apakah tombol login ditekan
if (isset($_POST['login'])) {
  $username = trim($_POST["username"]); // ambil input username/email
  $password = $_POST["password"];       // ambil input password
  $remember = isset($_POST["remember"]); // cek apakah "remember me" dicentang

  // === Validasi input ===
  if (empty($username) || empty($password)) {
    $error = "Username/email dan password harus diisi!";
  } else {
    $stmt = $koneksi->prepare("SELECT * FROM user WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $username); // bind 2 parameter
    $stmt->execute();
    $result = $stmt->get_result();

    // jika ada data user
    if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();

      // cek password (dibandingkan dengan hash di database)
      if (password_verify($password, $row["password"])) {
        // simpan data user ke session
        $_SESSION["id"] = $row["id"];
        $_SESSION["username"] = $row["username"];

        // ===== REMEMBER ME =====
        if ($remember) {
          // buat token random (unik)
          $token = bin2hex(random_bytes(32));

          // hash token sebelum disimpan ke database
          $hash = password_hash($token, PASSWORD_DEFAULT);

          // update database dengan hash token
          $update_stmt = $koneksi->prepare("UPDATE user SET remember_token = ? WHERE id = ?");
          $update_stmt->bind_param("si", $hash, $row["id"]);
          $update_stmt->execute();

          // simpan token asli di cookie (30 hari)
          setcookie(
            "remember",
            $token,
            time() + (30 * 24 * 60 * 60), // 30 hari
            "/",
            "",
            false, // HTTPS? kalau lokal false saja
            true   // hanya bisa diakses oleh HTTP (bukan JavaScript)
          );
        } else {
          // kalau tidak dicentang: hapus token di DB dan cookie
          $update_stmt = $koneksi->prepare("UPDATE user SET remember_token = NULL WHERE id = ?");
          $update_stmt->bind_param("i", $row["id"]);
          $update_stmt->execute();

          setcookie("remember", "", time() - 3600, "/");
        }
        // ===== END REMEMBER ME =====

        header("Location: index.php"); // redirect ke halaman utama
        exit;
      } else {
        $error = "Password salah!";
      }
    } else {
      $error = "Username/email tidak ditemukan!";
    }
    $stmt->close();
  }
}
?>


//* ========== LOGOUT ==========
<?php
session_start();

// Hapus semua data sesi
session_unset();

// Hancurkan sesi
session_destroy();

// Redirect ke halaman login
header("Location: login.php");
exit();
?>


//* ========== AJAX ==========
<?php
// Sertakan file check_cookie.php (biasanya untuk cek apakah user punya cookie login)
include "check_cookie.php";

// Atur header agar output yang dikirim berupa JSON
header("Content-Type: application/json");

// Ambil parameter 'keyword' dari URL, kalau kosong isi string kosong
$keyword = $_GET['keyword'] ?? '';

// Variabel untuk menyimpan kondisi pencarian
$where = "";

// Kalau keyword tidak kosong, buat query pencarian
if (!empty($keyword)) {
  // Hindari SQL Injection dengan escape string
  $safe_keyword = $koneksi->real_escape_string($keyword);

  // Buat kondisi WHERE dengan LIKE untuk mencari nama/kategori
  $where = "WHERE nama LIKE '%$safe_keyword%' 
  OR kategori LIKE '%$safe_keyword%'";
  // Catatan: LIKE '$safe_keyword%' dihapus karena LIKE '%keyword%' sudah mencakup awal/akhir
}

// Jalankan query ambil data inventaris, maksimal 5 terakhir
$data = $koneksi->query("SELECT * FROM inventaris $where ORDER BY waktu DESC LIMIT 5");

// Simpan hasil ke array
$result = [];
while ($row = $data->fetch_assoc()) {
  $result[] = [
    "id" => $row["id"],
    "nama" => $row["nama"],
    "kategori" => $row["kategori"],
    "jumlah" => $row["jumlah"],
    "lokasi" => $row["lokasi"],
    "waktu" => $row["waktu"],
    // Kalau gambar kosong, pakai default.jpg
    "gambar" => !empty($row["gambar"]) ? $row["gambar"] : "default.jpg"
  ];
}

// Ubah hasil array jadi JSON untuk dikirim ke frontend
echo json_encode($result);
?>