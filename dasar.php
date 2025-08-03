//* emua kode PHP harus berada dalam tag <?php ?>

<?php
echo "Halo, dunia!";
?>

//* ==================== Variabel & Tipe Data (Tipe data: string, integer, float, boolean, array, object, null) ====================
//? Variabel ditulis dengan awalan $
//? Case-sensitive ($nama ≠ $Nama)

$nama = "Tino";
$umur = 20;
$tinggi = 170.5;
$mahasiswa = true;

//*==================== Menggabungkan String / concat ====================
//? gunakan . untuk menggabungkan

$nama_depan = "Tino" ;
$nama_belakang = "Nurcahya" ;
$nama_lengkap = $nama_depan . " " . $nama_belakang;

echo $nama_lengkap; // Output: Tino Nurcahya

//* ==================== Operator dan Struktur Kontrol ====================
//! Operator:
Aritmatika: +, -, *, /, %
Perbandingan: ==, !=, >, <, >=, <=
Logika: &&, ||, !
Penugasan: =, +=, -=, *=, /=, %=, .=

//! Percabangan if elseif else:
$nilai = 80;
if ($nilai >= 90) {
    echo "A";
} else if ($nilai >= 75) {
    echo "B";
} else {
    echo "C";
}
// Output: B

//! Perulangan for:
for ($i = 0; $i <= 5; $i++) {
  echo $i . "<br>" ;
}
// Output: 0 1 2 3 4 5 (harusnya kebawah)

//! Perulangan while:
$angka = 1;

while ($angka <= 5) {
    echo "Ini angka ke-$angka<br>";
    $angka++; //! penting: agar tidak infinite loop
}
// Output: 
Ini angka ke-1  
Ini angka ke-2  
Ini angka ke-3  
Ini angka ke-4  
Ini angka ke-5

//! Perulangan do-while (Perulangan do-while selalu dijalankan minimal satu kali):
$angka = 1;

do {
  echo "Angka: $angka<br>";
  $angka++;
} while ($angka <= 5);
// Output:
Angka: 1  
Angka: 2  
Angka: 3  
Angka: 4  
Angka: 5

//! Perulangan foreach khusus array:
  $buah = ["apel", "jeruk" ];
  foreach ($buah as $b) {
    echo $b . "<br>" ;
  }

//* ==================== Fungsi ====================
//? function sapa($nama) {
return "Halo, $nama!" ;
}

echo sapa("Tino");

//*====================Array dan array assosiatif ====================
$buah=["apel", "jeruk" ];
$profil=["nama"=> "Tino", "umur" => 20];

echo $profil["nama"];

//* ==================== Form html dan php ====================
<form method="POST">
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
include "header.php";
require "config.php";

//* ==================== Session dan cookie untuk login ====================
//? Mulai session
session_start();
$_SESSION["username"] = "tino";

// Ambil
echo $_SESSION["username"];