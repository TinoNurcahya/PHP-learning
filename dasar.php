//* semua kode PHP harus berada dalam tag <?php ?>
//* <?= ?> untuk panggilan di html (echo)
//* VARIABEL GLOBAL
$_GET	      Menangkap data dari URL (query string)
$_POST	    Menangkap data dari form dengan metode POST
$_REQUEST	  Gabungan dari $_GET, $_POST, dan $_COOKIE
$_SERVER	  Informasi tentang server dan environment
$_FILES	    Menangani file yang diupload
$_ENV	      Menyimpan variabel lingkungan (environment variables)
$_COOKIE	  Menyimpan dan mengakses data cookie
$_SESSION	  Menyimpan data sesi pengguna
$GLOBALS	  Menyimpan semua variabel global di PHP

<?php
echo "Halo, dunia!";
?>


//* ==================== Variabel & Tipe Data (Tipe data: string, integer, float, boolean, array, object, null) ====================
//? Variabel ditulis dengan awalan $
//? Case-sensitive ($nama ≠ $Nama)
<?php
  $nama = "Tino";
  $umur = 20;
  $tinggi = 170.5;
  $mahasiswa = true;
?>


//*==================== Menggabungkan String / concat ====================
//? gunakan . untuk menggabungkan
<?php
  $nama_depan = "Tino" ;
  $nama_belakang = "Nurcahya" ;
  $nama_lengkap = $nama_depan . " " . $nama_belakang;

  echo $nama_lengkap; // Output: Tino Nurcahya
?>


//* ==================== Operator dan Struktur Kontrol ====================
//! Operator:
Aritmatika: +, -, *, /, %
Perbandingan: ==, !=, >, <, >=, <=
Logika: &&, ||, !
Penugasan: =, +=, -=, *=, /=, %=, .=

//! Percabangan if elseif else:
<?php
  $nilai = 80;
  if ($nilai >= 90) {
      echo "A";
  } else if ($nilai >= 75) {
      echo "B";
  } else {
      echo "C";
  }
  // Output: B
?>

//! Perulangan for (gunakan count($nama_var) untuk hitung otomatis):
<?php
  for ($i = 0; $i <= 5; $i++) {
    echo $i . "<br>" ;
  }
  // Output: 0 1 2 3 4 5 (harusnya kebawah)
?>

//! Perulangan while:
<?php
  $angka = 1;

  while ($angka <= 5) {
      echo "Ini angka ke-$angka<br>";
      $angka++; //! penting: agar tidak infinite loop
  }
  // Output: 
  /*
  Ini angka ke-1  
  Ini angka ke-2  
  Ini angka ke-3  
  Ini angka ke-4  
  Ini angka ke-5
  */
?>

//! Perulangan do-while (Perulangan do-while selalu dijalankan minimal satu kali):
<?php
  $angka = 1;

  do {
    echo "Angka: $angka<br>";
    $angka++;
  } while ($angka <= 5);
  // Output:
/*
  Angka: 1  
  Angka: 2  
  Angka: 3  
  Angka: 4  
  Angka: 5
*/
?>

//! Perulangan foreach khusus array:
<?php
  $buah = ["apel", "jeruk" ];
  foreach ($buah as $b) {
    echo $b . "<br>" ;
  }
?>


//* ==================== function (Fungsi) ====================
//! Built-in Function
===== date/time =====
  time()
  date()
  mktime()
  strtotime()
===== string =====
  strlen()  menghitung panjang string
  strcmp()  membandingkan str
  explode() memecah str
  htmlspecialchars() menjaga ketika input str
===== utility =====
  var_dump()  mencetak isi var, array, obj
  isset() apakah ada var
  empty() apakah var ada isinya
  die() memberhentika program
  sleep() memberhentikan sementara
  array_push()

//! User-in Function
function namaFungsi($parameter1, $parameter2, ...) {
    // kode yang akan dijalankan
    return nilai; // (opsional)
}

//? fungsi dengan default
<?php
function sapa($nama = "Tamu") {
    echo "Halo, $nama!";
}

sapa(); // Halo, Tamu
sapa("Andi"); // Halo, Andi
?>


//*==================== Array dan array associative ====================
//? Array adalah variabel yang dapat menyimpan banyak nilai sekaligus dalam satu nama variabel

//! gunakan endforeach untuk di dalam html agar rapih. tidak pakai kurawal, melainkan titik dua dan ditutup dengan endforeach.

<?php $buah = ["apel", "jeruk", "mangga"]; ?>

<ul>
<?php foreach ($buah as $b): ?>
    <li><?= $b ?></li>
<?php endforeach; ?>
</ul>


//! Array
<?php
  $buah = ["apel", "jeruk", "mangga"];
  echo $buah[1]; // Output: jeruk

  foreach ($buah as $b) {
    echo "Buah: $b <br>";
  }
?>

//! array associative
<?php
  $mahasiswa = [
    "nama" => "Tino",
    "umur" => 20,
    "jurusan" => "Teknik Informatika"
  ];

  echo $mahasiswa["nama"]; // Output: Tino

  foreach ($mahasiswa as $key => $value) {
    echo "$key: $value<br>";
  }
?>

//!   CONTOH
  <table border="1" cellpadding="10" cellspacing="0">
    <tr>
      <th>No</th>
      <th>Nama</th>
      <th>Umur</th>
      <th>Jurusan</th>
    </tr>

    <?php
    $mahasiswa = [
      [
        "nama" => "Tino",
        "umur" => 20,
        "jurusan" => "Teknik Informatika"
      ],
      [
        "nama" => "Andi",
        "umur" => 21,
        "jurusan" => "Sistem Informasi"
      ],
      [
        "nama" => "Sari",
        "umur" => 22,
        "jurusan" => "Teknik Komputer"
      ]
    ];

    $no = 1;
    foreach ($mahasiswa as $mhs) {
      echo "<tr>";
      echo "<td>" . $no++ . "</td>";
      echo "<td>" . $mhs["nama"] . "</td>";
      echo "<td>" . $mhs["umur"] . "</td>";
      echo "<td>" . $mhs["jurusan"] . "</td>";
      echo "</tr>";
    }
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db = "namadb";
    
    $conn = new mysqli($host, $user, $pass, $db);
    
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }
    ?>
  </table>

//* ==================== GET dan POST ====================
//? GET dan POST adalah metode HTTP yang digunakan untuk mengirim data dari client (browser) ke server (PHP).

//! ===== $_GET =====
//! Digunakan untuk mengambil data.
//! Data dikirim melalui URL.
//! Data terlihat di URL seperti: index.php?nama=Tino&umur=20
//! Dapat diakses di PHP dengan $_GET['nama'], $_GET['umur']

//! ===== $_POST =====
//! Digunakan untuk mengirim data sensitif atau form besar.
//! Data dikirim secara tersembunyi (hidden) di body request.
//! Tidak terlihat di URL.
//! Diakses dengan $_POST['nama'], dll.

//! ========== CONTOH: FORM GET ==========
<form method="GET" action="proses.php">
  <label for="nama">Nama:</label>
  <input type="text" name="nama">
  <button type="submit">Kirim</button>
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
  $nama = $_GET["nama"];
  echo "Halo, $nama!";
}
?>
//? OUTPUT URL : proses.php?nama=Tino

//! ========== CONTOH: FORM POST ==========
<form method="POST" action="proses.php">
  <label for="nama">Nama:</label>
  <input type="text" name="nama">
  <button type="submit">Kirim</button>
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nama = $_POST["nama"];
  echo "Halo, $nama!";
}
?>

//* ==================== Include dan required ====================
//? Menggunakan file php lain
include "header.php";   menyisipkan file php lain (kode tetap jalan walaupun file tidak ditemukan)
require "config.php";   sama seperti include tapi akan error jika file tidak ditemukan

header("Location: login.php");
exit; // wajib agar redirect benar-benar terjadi

//! header() harus dipanggil sebelum output HTML apapun.
//* ==================== Session dan cookie untuk login ====================
//? Mulai session
session_start();
$_SESSION["username"] = "tino";

// Ambil
echo $_SESSION["username"];