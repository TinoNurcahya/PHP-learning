OOP (Pemrograman Berorientasi Objek) adalah cara menulis kode dengan konsep kelas (class) dan objek (object).
Dengan OOP, kode lebih rapi, mudah digunakan ulang, dan lebih gampang dikembangkan.

Konsep utama OOP:
=====> Class → cetakan / blueprint (misalnya: Mobil).
=====> Object → hasil nyata dari class (misalnya: Mobil Avanza, Mobil Pajero).
=====> Property → variabel di dalam class.
Method → fungsi di dalam class.
=====> Constructor → method khusus yang dijalankan otomatis saat objek dibuat.
=====> Encapsulation → mengatur akses data (public, private, protected).
=====> Inheritance → pewarisan class (class anak bisa mewarisi class induk).
=====> Polymorphism → method yang sama bisa punya implementasi berbeda.

Overloading
//* ==================== Class dan Object, Property & Method, Constructor ====================
//* Class dan Object
Class → cetakan / blueprint (misalnya: Mobil).

diawali dengan keyword class diikuti nama dengan huruf awal besar, lalu kurawal {} untuk menyimpan Property dan method.

Object → hasil nyata dari class (misalnya: Mobil Avanza, Mobil Pajero).
banyak object dapat dibuat menggunakan satu class.
onject dibuat dengan keyword new

//* Property & Method
=====> Property = variabel yang ada di dalam class.
=====> Method = fungsi yang ada di dalam class.

//* Constructor
=====> Constructor (__construct) = method khusus yang otomatis jalan saat object dibuat.
=====> Biasanya dipakai untuk mengisi property awal. (menginisialisasi)

<?php
class Mobil
{
  //* Property
  public $merk;
  public $warna;

  //* Constructor (otomatis jalan saat objek dibuat)
  public function __construct($merk, $warna)
  {
    $this->merk = $merk;
    $this->warna = $warna;
  }

  //* Method
  public function infoMobil()
  {
    return "Mobil ini merk {$this->merk} berwarna {$this->warna}.";
  }
}

//* Membuat objek
$mobil1 = new Mobil("Toyota Avanza", "Hitam");
$mobil2 = new Mobil("Mitsubishi Pajero", "Putih");

// Akses method
echo $mobil1->infoMobil(); // Mobil ini merk Toyota Avanza berwarna Hitam.
echo "<br>";
echo $mobil2->infoMobil(); // Mobil ini merk Mitsubishi Pajero berwarna Putih.


//* ===== TANPA CONSTRUCT (set manual) =====
class Mobil
{
  public $merk;
  public $warna;
}

$mobil1 = new Mobil();
$mobil1->merk = "Toyota Avanza";
$mobil1->warna = "Hitam";

echo $mobil1->merk; // Toyota Avanza
?>

//* ==================== Destructor ====================
=====> Destructor (__destruct) = method khusus yang otomatis jalan saat object dihancurkan / tidak dipakai lagi.
=====> Biasanya dipakai untuk membersihkan resource (contoh: nutup koneksi database).
<?php
class Mobil
{
  public $merk;

  public function __construct($merk)
  {
    $this->merk = $merk;
    echo "Mobil {$this->merk} dibuat.<br>";
  }

  public function __destruct()
  {
    echo "Mobil {$this->merk} dihancurkan.<br>";
  }
}

$mobil1 = new Mobil("Avanza");
$mobil2 = new Mobil("Pajero");

echo "Program selesai.<br>";

/* OUTPUT
Mobil Avanza dibuat.
Mobil Pajero dibuat.
Program selesai.
Mobil Pajero dihancurkan.
Mobil Avanza dihancurkan.
*/
?>


//* ==================== Access Modifier (Encapsulation) ====================
=====> public → bisa diakses dari mana saja.
=====> protected → hanya bisa diakses di class sendiri & turunannya.
=====> private → hanya bisa diakses di class itu sendiri.

//* ===== public (Bisa diakses dari mana saja) =====
<?php
class User
{
  public $username = "Tino";
}

$user = new User();
echo $user->username; // Bisa langsung diakses (OK)
?>

//* ===== protected (hanya class sendiri & turunannya) =====
<?php
class User
{
  protected $role = "Admin";
  protected function getRole()
  {
    return $this->role;
  }
}

class Member extends User
{
  public function showRole()
  {
    return "Role saya: " . $this->getRole();
  }
}

$member = new Member();
// echo $member->role; // ERROR, karena protected
echo $member->showRole(); // OK → "Role saya: Admin"
?>

//* ===== private (Hanya bisa diakses dalam class itu sendiri.) =====
<?php
class User
{
  private $password = "12345";

  private function getPassword()
  {
    return $this->password;
  }

  public function showPassword()
  {
    return "Password: " . $this->getPassword();
  }
}

$user = new User();
// echo $user->password; // ERROR (private)
echo $user->showPassword(); // OK → Password: 12345
?>

//* ===== Getter & Setter (Kadang property dibuat private supaya tidak bisa sembarangan diubahUntuk mengakses atau mengubahnya, dipakai getter dan setter.) =====
<?php
class User
{
  private $username;
  private $password;

  // Setter (untuk mengisi data)
  public function setUser($username, $password)
  {
    $this->username = $username;
    $this->password = $password;
  }

  // Getter (untuk mengambil data)
  public function getUser()
  {
    return "Username: {$this->username}, Password: {$this->password}";
  }
}

$user = new User();
$user->setUser("Tino", "rahasia");
echo $user->getUser();
// Username: Tino, Password: rahasia
?>

//* ========== CONTOH: public, protected, private) ==========
<?php
class User
{
  // =============== PROPERTIES ===============
  public $username;       // public → bisa diakses dari mana saja
  protected $role;        // protected → hanya class & turunannya
  private $password;      // private → hanya class itu sendiri

  // =============== CONSTRUCTOR ===============
  public function __construct($username, $role, $password)
  {
    $this->username = $username;
    $this->role = $role;
    $this->password = $password;
  }

  // =============== GETTER & SETTER ===============
  public function setPassword($password)
  { // setter
    // contoh validasi sebelum diset
    if (strlen($password) < 8) {
      echo "Password terlalu pendek!<br>";
    } else {
      $this->password = $password;
    }
  }

  public function getPassword()
  { // getter
    return $this->password;
  }

  // Method untuk akses protected role
  protected function getRole()
  {
    return $this->role;
  }
}

// Class turunan (Inheritance)
class Member extends User
{
  public function showData()
  {
    // Bisa akses public & protected
    return "Username: {$this->username}, Role: {$this->getRole()}";
    // $this->password → ERROR (karena private)
  }
}

// =============== TEST ===============
$user1 = new Member("Tino", "Admin", "12345");

// Public → bisa langsung akses
echo $user1->username . "<br>"; // OK

// Protected → harus lewat method di turunan
echo $user1->showData() . "<br>"; // OK

// Private → harus lewat getter & setter
echo "Password lama: " . $user1->getPassword() . "<br>";
$user1->setPassword("12");       // gagal (pendek)
$user1->setPassword("abcdef");   // sukses
echo "Password baru: " . $user1->getPassword() . "<br>";
?>




//* ==================== Constant ====================
variabel yang nilainya tidak bisa diubah.
Biasanya dipakai untuk konfigurasi aplikasi, nilai matematika, atau data yang fix.

=====> tulis nama constant dengan huruf besar semua

//* ===== membuat constant dengan define() =====
tidak bisa di gunakan di dalam class

<?php
define("PI", 3.14);
define("APP_NAME", "Sistem Informasi");

echo PI;        // 3.14
echo APP_NAME;  // Sistem Informasi
?>

//* ===== membuat constant dengan const =====
Biasanya dipakai di dalam class
<?php
class Config
{
  const APP_VERSION = "1.0.0";
}

echo Config::APP_VERSION; // 1.0.0
?>




//* ==================== Static keyword ====================
=====> static dalam OOP PHP artinya property atau method yang dimiliki oleh class itu sendiri, bukan oleh object.
=====> Jadi, untuk mengaksesnya tidak perlu bikin objek dengan new, tapi langsung lewat nama class.

//* ===== static property =====
<?php
class Contoh
{
  public static $angka = 0;

  public static function tambah()
  {
    self::$angka++;
    return self::$angka;
  }
}

// akses tanpa bikin objek
echo Contoh::tambah(); // 1
echo Contoh::tambah(); // 2
?>
=====> self:: dipakai untuk akses ke property/method static di dalam class.
=====> Contoh::tambah() dipakai untuk akses dari luar.




//* ==================== Object type ====================
Dalam PHP, kita bisa kasih tipe data pada parameter fungsi/method atau pada return value.
Biasanya kita kenal tipe primitif: int, string, array.

Nah, object type artinya parameter/return tersebut harus berupa object (hasil dari class yang dibuat dengan new).

//* ===== Spesifik: Class tertentu =====
<?php
class User
{
  public $nama;
  public function __construct($nama)
  {
    $this->nama = $nama;
  }
}

function cetakUser(User $u)
{  // hanya terima User
  echo "Nama user: {$u->nama}";
}

$cust = new User("Tino");
cetakUser($cust);   // ✅ valid

cetakUser((object)["nama" => "Budi"]); // ❌ error, bukan class User
//* Jadi PHP akan memastikan kalau yang dikirim benar-benar object User.
?>

//* ===== Generik: object =====
Kalau pakai object, artinya fungsi bisa menerima object apapun (class apapun).
<?php
function debug(object $o)
{
  echo "Ini object dari class: " . get_class($o);
}

debug(new User("Tino"));   // ✅
debug(new DateTime());     // ✅
// Di sini tidak peduli class-nya apa, asal bentuknya object.
?>




//* ==================== Inheritance (Pewarisan) ====================
=====> Inheritance = class baru bisa mewarisi property & method dari class lain.
Di PHP pakai keyword extends.

//* ===== extends (membuat class turunan dari class lain) =====
<?php
class Hewan
{
  public $nama;

  public function __construct($nama)
  {
    $this->nama = $nama;
  }

  public function makan()
  {
    return "{$this->nama} sedang makan...";
  }
}

// Class Kucing mewarisi dari Hewan
class Kucing extends Hewan
{
  public function suara()
  {
    return "{$this->nama} mengeong: Meong!";
  }
}

//Kucing bisa pakai semua property & method dari Hewan.
$kucing = new Kucing("Tom");
echo $kucing->makan();  // bisa akses method induk
echo "<br>";
echo $kucing->suara();  // method milik Kucing
?>

//* ===== Overriding Method (method induk bisa diganti di class turunan.) =====
=====> method induk ditimpa total (hilang)

<?php
class Hewan
{
  public $nama;
  public function __construct($nama)
  {
    $this->nama = $nama;
  }

  public function suara()
  {
    return "Hewan ini bersuara...";
  }
}

class Kucing extends Hewan
{
  // Override method suara()
  public function suara()
  {
    return "{$this->nama} mengeong: Meong!";
  }
}

class Anjing extends Hewan
{
  public function suara()
  {
    return "{$this->nama} menggonggong: Guk guk!";
  }
}

$kucing = new Kucing("Tom");
$anjing = new Anjing("Spike");

echo $kucing->suara(); // Tom mengeong: Meong!
echo "<br>";
echo $anjing->suara(); // Spike menggonggong: Guk guk!
?>

//* ===== parent:: (dipakai untuk akses method/properti milik induk dalam class turunan) =====
=====> parent:: itu berguna kalau kita tidak ingin kehilangan fungsionalitas induk, tapi tetap mau custom di anaknya

<?php
class Hewan
{
  public $nama;
  public function __construct($nama)
  {
    $this->nama = $nama;
  }

  public function suara()
  {
    return "{$this->nama} bersuara umum...";
  }
}

class Kucing extends Hewan
{
  public function suara()
  {
    // Panggil method induk dulu
    $suaraInduk = parent::suara();
    return $suaraInduk . " Tapi khusus kucing: Meong!";
  }
}

// OUTPUT: Tom bersuara umum... Tapi khusus kucing: Meong!
$kucing = new Kucing("Tom");
echo $kucing->suara();
?>

//* ========== CONTOH: extends, Overriding, parent::) ==========
<?php
// ========== CLASS INDUK ==========
class Kendaraan
{
  public $merk;
  public $warna;

  public function __construct($merk, $warna)
  {
    $this->merk = $merk;
    $this->warna = $warna;
  }

  public function info()
  {
    return "Kendaraan merk {$this->merk}, warna {$this->warna}.";
  }

  public function suara()
  {
    return "Kendaraan ini mengeluarkan suara umum...";
  }
}

// ========== CLASS TURUNAN ==========
class Mobil extends Kendaraan
{
  // Override method info()
  public function info()
  {
    // Pakai parent:: untuk ambil method induk
    $infoInduk = parent::info();
    return $infoInduk . " Ini adalah sebuah mobil.";
  }

  // Override method suara()
  public function suara()
  {
    return "{$this->merk} membunyikan klakson: Tiiin Tiiin!";
  }
}

class Motor extends Kendaraan
{
  // Override method info()
  public function info()
  {
    $infoInduk = parent::info();
    return $infoInduk . " Ini adalah sebuah motor.";
  }

  // Override method suara()
  public function suara()
  {
    return "{$this->merk} menyalakan knalpot: Brumm Brumm!";
  }
}

// ========== TEST ==========
// Object Mobil
$mobil1 = new Mobil("Toyota Avanza", "Hitam");
echo $mobil1->info() . "<br>";
echo $mobil1->suara() . "<br><br>";

// Object Motor
$motor1 = new Motor("Honda Beat", "Merah");
echo $motor1->info() . "<br>";
echo $motor1->suara() . "<br>";
?>




//* ==================== Polymorphism ====================
=====> Polymorphism artinya “banyak bentuk”.
Dalam OOP, method dengan nama sama bisa punya perilaku berbeda di class turunan.
=====> Biasanya dipakai bareng Inheritance, Abstract Class, atau Interface.

=====> Overriding → method sama, isi beda di tiap class turunan.
=====> Abstract Class → class induk hanya template, turunan wajib override.
=====> Interface → kontrak method, semua class yang implements wajib isi.

//* ===== Polymorphism dengan Overriding =====
<?php
class Kendaraan
{
  public function suara()
  {
    return "Kendaraan ini mengeluarkan suara umum...";
  }
}

class Mobil extends Kendaraan
{
  public function suara()
  {
    return "Mobil membunyikan klakson: Tiiin Tiiin!";
  }
}

class Motor extends Kendaraan
{
  public function suara()
  {
    return "Motor menyalakan knalpot: Brumm Brumm!";
  }
}

$kendaraan = [new Mobil(), new Motor()];

foreach ($kendaraan as $k) {
  echo $k->suara() . "<br>";
}

/* OUTPUT 
Mobil membunyikan klakson: Tiiin Tiiin!
Motor menyalakan knalpot: Brumm Brumm!
*/
?>


//* ===== Polymorphism dengan Abstract Class =====
Kadang class induk tidak punya implementasi jelas, hanya sebagai “template”.
Gunakan abstract class → tidak bisa dibuat object langsung.

<?php
abstract class Hewan
{
  abstract public function suara(); // wajib di-override turunan
}

class Kucing extends Hewan
{
  public function suara()
  {
    return "Meong!";
  }
}

class Anjing extends Hewan
{
  public function suara()
  {
    return "Guk guk!";
  }
}

$hewan = [new Kucing(), new Anjing()];
foreach ($hewan as $h) {
  echo $h->suara() . "<br>";
}

/* OUTPUT
Meong!
Guk guk!
*/
?>


//* ===== Polymorphism dengan Interface =====
Interface mirip abstract class, tapi hanya berisi kontrak method → semua turunan wajib implementasikan.

<?php
interface Bentuk
{
  public function luas();
}

class Persegi implements Bentuk
{
  private $sisi;
  public function __construct($sisi)
  {
    $this->sisi = $sisi;
  }
  public function luas()
  {
    return $this->sisi * $this->sisi;
  }
}

class Lingkaran implements Bentuk
{
  private $r;
  public function __construct($r)
  {
    $this->r = $r;
  }
  public function luas()
  {
    return 3.14 * $this->r * $this->r;
  }
}

$bentuk = [new Persegi(4), new Lingkaran(7)];
foreach ($bentuk as $b) {
  echo "Luas: " . $b->luas() . "<br>";
}

/* OUTPUT
Luas: 16
Luas: 153.86
*/
?>




//* ==================== Abstract Class ====================
Abstract class adalah class dasar yang tidak bisa dibuat objek langsung, hanya bisa diturunkan.

<?php
abstract class Hewan
{
  abstract public function suara(); // harus di-override child class

  public function info()
  {
    return "Ini adalah hewan.";
  }
}

class Kucing extends Hewan
{
  public function suara()
  {
    return "Meong!";
  }
}

$cat = new Kucing();
echo $cat->suara(); // Meong!
?>
abstract method wajib diimplementasikan oleh class turunan.



//* ==================== Interface ====================
Interface mirip kontrak → semua class yang "meng-implement" harus mematuhi isi interface tersebut.

=====> semua method harus di deklarasi dengan visibility public
=====> boleh mendeklarasikan __construct()
=====> 1 class boleh mengimplement banyak interface

<?php
interface Kendaraan
{
  public function jalan();   // hanya deklarasi
}

class Mobil implements Kendaraan
{
  public function jalan()
  {
    return "Mobil sedang melaju 🚗";
  }
}

class Motor implements Kendaraan
{
  public function jalan()
  {
    return "Motor sedang ngebut 🏍️";
  }
}

$avanza = new Mobil();
$beat = new Motor();

echo $avanza->jalan(); // Mobil sedang melaju 🚗
echo "\n";
echo $beat->jalan();   // Motor sedang ngebut 🏍️
?>

1 class bisa implement banyak interface, tapi hanya bisa extend 1 class.
Jadi kalau butuh "multi inheritance", kita pakai interface.




//* ==================== Autoloading ====================
Autoloading adalah fitur di PHP yang memungkinkan kita memanggil class otomatis saat dibutuhkan, tanpa harus menulis require atau include secara manual setiap kali.

//* ===== tanpa autoloading =====
<?php
require "User.php";
require "Produk.php";
require "Database.php";

$user = new User();
$produk = new Produk();
?>
=====> Kalau class makin banyak → makin ribet.
=====> Dengan autoload → cukup panggil class, file langsung di-load otomatis.


//* ==================== CARA AUTOLOADING DI PHP ====================
//* ===== spl_autoload_register() (Manual Autoloading) =====
<?php
spl_autoload_register(function ($class) {
  require $class . ".php";
});

$user = new User();    // otomatis load User.php
$produk = new Produk(); // otomatis load Produk.php
?>

SYARATNYA:
=====> Nama file sama dengan nama class (User.php, Produk.php).
=====> Semua file class ada di folder yang sama, atau diatur path-nya.


//* ===== Composer Autoloading (Paling Dipakai di Framework) =====
Di project modern (Laravel, Symfony, CI4, dsb) kita pakai Composer.

Buat struktur project:
src/
Models/
User.php
Controllers/
ProdukController.php
composer.json

Isi composer.json:
{
"autoload": {
"psr-4": {
"App\\": "src/"
}
}
}

Jalankan:
composer dump-autoload

Pakai di project:
<?php
require "vendor/autoload.php";

use App\Models\User;
use App\Controllers\ProdukController;

$user = new User();
$produk = new ProdukController();
?>




//* ==================== Namespace ====================
=====> Namespace adalah ruang lingkup (wadah) yang digunakan untuk mengelompokkan class, function, atau constant agar tidak bentrok nama dengan file lain.
=====> Bayangkan kamu punya 2 file berbeda, keduanya punya class User. Tanpa namespace, PHP bingung class User yang mana yang harus dipanggil → error "cannot redeclare class".

Dengan namespace, kamu bisa bedakan:
=====> App\Models\User
=====> App\Controllers\User

//* ===== Comtoh dengan Namespace =====
<?php
// File: Models/User.php
namespace App\Models;

class User
{
  public function getName()
  {
    return "User dari Models";
  }
}
?>

<?php
// File: Controllers/User.php
namespace App\Controllers;

class User
{
  public function getName()
  {
    return "User dari Controllers";
  }
}
?>


//* ===== Pemanggilan =====
<?php
require "Models/User.php";
require "Controllers/User.php";

// Panggil class dengan namespace lengkap
$modelUser = new \App\Models\User();
echo $modelUser->getName(); // Output: User dari Models

$controllerUser = new \App\Controllers\User();
echo $controllerUser->getName(); // Output: User dari Controllers
?>

//* ===== Alias (pakai use) =====
Supaya lebih simpel, bisa kasih alias dengan use:

<?php

use App\Models\User as ModelUser;
use App\Controllers\User as ControllerUser;

$model = new ModelUser();
echo $model->getName(); // User dari Models

$controller = new ControllerUser();
echo $controller->getName(); // User dari Controllers
?>



//* ==================== Trait ====================
=====> Trait adalah mekanisme di PHP untuk menggabungkan/mewarisi method ke dalam class, mirip seperti copy-paste method ke dalam class.
=====> dipakai ketika: Tidak bisa pakai inheritance karena PHP hanya mendukung single inheritance (satu class hanya bisa extends satu class).
=====> Jadi Trait adalah jalan tengah antara inheritance dan composition.


//* ===== contoh trait =====
<?php
trait Logger
{
  public function log($message)
  {
    echo "[LOG] " . $message . PHP_EOL;
  }
}

class User
{
  use Logger;

  public function createUser()
  {
    $this->log("User berhasil dibuat!");
  }
}

$user = new User();
$user->createUser();
// Output: [LOG] User berhasil dibuat!
// User class otomatis punya method log() dari Logger.
?>

//* ===== Trait Dipakai di Banyak Class =====
<?php
trait Tanggal
{
  public function today()
  {
    return date("Y-m-d");
  }
}

class Produk
{
  use Tanggal;
}

class Order
{
  use Tanggal;
}

$p = new Produk();
$o = new Order();

echo $p->today(); // 2025-08-26
echo $o->today(); // 2025-08-26
// Class Produk dan Order sama-sama bisa pakai today() tanpa harus extends.
?>

//* ===== Multiple Traits =====
<?php
trait A
{
  public function methodA()
  {
    echo "Method dari A\n";
  }
}
trait B
{
  public function methodB()
  {
    echo "Method dari B\n";
  }
}

class C
{
  use A, B;
}

$obj = new C();
$obj->methodA(); // Method dari A
$obj->methodB(); // Method dari B
?>

//* ===== Konflik Method di Trait =====
=====> Kalau dua trait punya method dengan nama sama → harus pilih dengan insteadof atau alias as:
<?php
trait A
{
  public function test()
  {
    echo "A::test\n";
  }
}

trait B
{
  public function test()
  {
    echo "B::test\n";
  }
}

class C
{
  use A, B {
    A::test insteadof B; // pakai test() dari A
    B::test as testB;    // alias testB untuk test() dari B
  }
}

$c = new C();
$c->test();   // A::test
$c->testB();  // B::test
?>

=====> Inheritance: class extends class lain (hanya 1).
=====> Interface: hanya kontrak, harus diimplementasikan.
=====> Trait: “tempel” method langsung ke class → solusi untuk reuse code di banyak class.





//* ==================== stdClass ====================
=====> stdClass adalah class bawaan PHP (built-in class).
=====> Dipakai sebagai “wadah kosong” untuk membuat objek tanpa harus mendefinisikan class sendiri.
<?php
$obj = new stdClass();
$obj->nama = "Tino";
$obj->umur = 20;

echo $obj->nama;  // Output: Tino
echo $obj->umur;  // Output: 20
?>

//* ===== Konversi Array ke stdClass =====
<?php
$data = [
  "nama" => "Budi",
  "umur" => 25
];

// Ubah jadi object
$obj = (object) $data;

echo $obj->nama; // Output: Budi
echo $obj->umur; // Output: 25
?>




//* ==================== Object Iteration ====================
=====> Object Iteration = proses melakukan perulangan (foreach) terhadap property milik sebuah object.
=====> Di PHP, semua public property dari object bisa langsung di-loop dengan foreach.
=====> Kalau butuh kontrol lebih (misalnya property private/protected atau perilaku custom), bisa pakai Iterator interface.

//* ===== Contoh dasar iterasi object =====
<?php
class User
{
  public $nama = "Tino";
  public $umur = 20;
  public $email = "tino@mail.com";
}

$user = new User();

foreach ($user as $key => $value) {
  echo "$key : $value <br>";
}

/*
Output:
nama : Tino
umur : 20
email : tino@mail.com
*/

//Hanya public property yang bisa di-loop
?>



//* ==================== Generator ====================
=====> Generator = cara membuat iterator dengan lebih simpel.
=====> Biasanya kalau bikin Iterator (seperti yang tadi) harus implement banyak method (current(), next(), dll).
=====> Dengan Generator, cukup pakai keyword yield di dalam function → otomatis bisa di-foreach.

//* ===== Contoh generator sederhana =====
<?php
function angka()
{
  yield 1;
  yield 2;
  yield 3;
}

foreach (angka() as $value) {
  echo $value . "<br>";
}

/*
Output:
1
2
3
*/
?>
return → semua data ditampung di memory dulu.

yield → data dikirim satu per satu, jadi hemat memory (bagus untuk data besar / stream).

//* ===== Contoh generator dengan Loop =====
<?php
function rangeGenerator($start, $end)
{
  for ($i = $start; $i <= $end; $i++) {
    yield $i;
  }
}

foreach (rangeGenerator(1, 5) as $num) {
  echo $num . " ";
}

/*
Output:
1 2 3 4 5
*/
?>

//* ===== Contoh generator dengan Key => Value =====
<?php
function dataUser()
{
  yield "nama" => "Tino";
  yield "umur" => 20;
  yield "email" => "tino@mail.com";
}

foreach (dataUser() as $key => $value) {
  echo "$key : $value <br>";
}
?>



//* ==================== Object Cloning ====================
=====> Cloning = membuat salinan (copy) dari sebuah object.
=====> Di PHP, kalau kita assign object ke variabel lain, itu bukan copy, tapi reference (alias menunjuk ke object yang sama).
=====> Kalau mau benar-benar membuat object baru (copy), gunakan clone.

//* ===== Contoh tanpa clone =====
<?php
class User
{
  public $name;
}

$user1 = new User();
$user1->name = "Tino";

$user2 = $user1; // hanya reference, bukan clone
$user2->name = "Budi";

echo $user1->name; // Budi (ikut berubah!)
?>

//* ===== Contoh dengan clone =====
<?php
class User
{
  public $name;
}

$user1 = new User();
$user1->name = "Tino";

$user2 = clone $user1; // bikin object baru
$user2->name = "Budi";

echo $user1->name; // Tino
echo $user2->name; // Budi
?>

//* ===== Magic Method __clone() =====
=====> bisa pakai __clone() untuk mengatur apa yang terjadi saat object di-clone.
=====> __clone() dipanggil otomatis setelah clone → bisa dipakai untuk reset property, bikin ID unik, dll.



//* ==================== Comparing Object ====================
Di PHP ada dua cara utama untuk membandingkan object:
=====> == (Equality / sama nilai)
=====> === (Identity / identik)

//* ===== contoh ==(Equality) =====
<?php
class User
{
  public $name;
}

$user1 = new User();
$user1->name = "Tino";

$user2 = new User();
$user2->name = "Tino";

var_dump($user1 == $user2);  // true (isi property sama)
var_dump($user1 === $user2); // false (beda object di memory)
?>

//* ===== contoh ===(Identity) =====
<?php
class User
{
  public $name;
}

$user1 = new User();
$user1->name = "Tino";

$user2 = $user1; // reference ke object yang sama

var_dump($user1 == $user2);  // true
var_dump($user1 === $user2); // true (karena reference sama)
?>



//* ==================== Magic Function (Magic Methods) ====================
=====> Magic function adalah method spesial di PHP yang diawali dengan __ (double underscore).
paling sering dipakai:
__construct() → dipanggil saat object dibuat
__destruct() → dipanggil saat object dihancurkan

//* ===== __construct() =====
<?php
class User
{
  public $name;
  public function __construct($name)
  {
    $this->name = $name;
  }
}
$user = new User("Tino");
echo $user->name; // Tino
?>

//* ===== __destruct() =====
<?php
class FileHandler
{
  public function __destruct()
  {
    echo "Object dihancurkan!";
  }
}
$file = new FileHandler();
// ketika script selesai -> "Object dihancurkan!"
?>

//* ===== __toString() =====
Dipanggil kalau object diperlakukan sebagai string.
<?php
class User
{
  public $name = "Tino";
  public function __toString()
  {
    return "User: " . $this->name;
  }
}
$user = new User();
echo $user; // User: Tino
?>

//* ===== __get() & __set() =====
Menangani akses ke property yang tidak ada / private.
<?php
class User
{
  private $data = [];

  public function __get($key)
  {
    return $this->data[$key] ?? "Tidak ada";
  }
  public function __set($key, $value)
  {
    $this->data[$key] = $value;
  }
}
$user = new User();
$user->age = 20; // lewat __set
echo $user->age; // lewat __get → 20
?>

//* ===== __call() & __callStatic() =====
Dipanggil saat method yang tidak ada dipanggil.
<?php
class Demo
{
  public function __call($name, $args)
  {
    return "Method $name dipanggil dengan argumen: " . implode(", ", $args);
  }
}
$d = new Demo();
echo $d->halo("Tino", "PHP");
// Method halo dipanggil dengan argumen: Tino, PHP
?>

//* ===== __clone() =====
Dipanggil saat object di-clone.
<?php
class User
{
  public $name;
  public function __clone()
  {
    $this->name = "Clone of " . $this->name;
  }
}
$user1 = new User();
$user1->name = "Tino";

$user2 = clone $user1;
echo $user2->name; // Clone of Tino
?>

//* ===== __invoke() =====
Dipanggil saat object diperlakukan seperti function.
<?php
class Hello
{
  public function __invoke($name)
  {
    return "Halo $name!";
  }
}
$h = new Hello();
echo $h("Tino"); // Halo Tino!
?>

//* ===== __sleep() & __wakeup() =====
Untuk serialize / unserialize object.
<?php
class User
{
  public $name = "Tino";
  public function __sleep()
  {
    return ["name"];
  }
  public function __wakeup()
  {
    echo "Object di-unserialize\n";
  }
}
$user = new User();
$s = serialize($user);
$u = unserialize($s); // Object di-unserialize
?>



//* ==================== Overloading ====================
=====> __set($name, $value) → dijalankan saat kita mengisi properti yang tidak ada.
=====> __get($name) → dijalankan saat kita mengambil properti yang tidak ada.
=====> __isset($name) → dijalankan saat isset() atau empty() dipanggil pada properti yang tidak ada.
=====> __unset($name) → dijalankan saat unset() dipanggil pada properti yang tidak ada.

//* ===== Contoh =====
<?php
class User
{
  private $data = [];

  public function __set($name, $value)
  {
    echo "Set properti '$name' dengan nilai '$value'\n";
    $this->data[$name] = $value;
  }

  public function __get($name)
  {
    return $this->data[$name] ?? "Propertinya '$name' tidak ada!";
  }

  public function __isset($name)
  {
    return isset($this->data[$name]);
  }

  public function __unset($name)
  {
    unset($this->data[$name]);
  }
}

$user = new User();

// Properti "dinamis"
$user->nama = "Tino";      // __set
echo $user->nama;          // __get
?>



//* ==================== Covariance dan Contravariance ====================
=====> Covariance → Return type di subclass boleh lebih spesifik daripada parent.
=====> Contravariance → Parameter di subclass boleh lebih umum daripada parent.

//* ===== Contoh Covariance =====
=====> Covariance = Return Type bisa lebih spesifik saat overriding method.
=====> Artinya: subclass boleh mengembalikan tipe data yang lebih sempit (turunan) daripada parent.

<?php
class Animal {}
class Dog extends Animal {}

class AnimalShelter
{
  public function getAnimal(): Animal
  {
    return new Animal();
  }
}

class DogShelter extends AnimalShelter
{
  // Return type lebih spesifik (Dog adalah subclass dari Animal)
  public function getAnimal(): Dog
  {
    return new Dog();
  }
}

$shelter = new DogShelter();
$dog = $shelter->getAnimal(); // Mengembalikan Dog, bukan sekadar Animal
?>

//* ===== Contoh Contravariance =====
=====> Contravariance = Parameter type bisa lebih umum saat overriding method.
=====> Artinya: subclass boleh menerima tipe parameter yang lebih lebar (parent) dibandingkan yang ada di parent class.

<?php
class Animal {}
class Dog extends Animal {}

class Trainer
{
  public function train(Dog $dog)
  {
    echo "Training a dog\n";
  }
}

class AnimalTrainer extends Trainer
{
  // Parameter diperluas (Animal lebih umum daripada Dog)
  public function train(Animal $animal)
  {
    echo "Training an animal\n";
  }
}

$trainer = new AnimalTrainer();
$trainer->train(new Dog());    // Bisa
$trainer->train(new Animal()); // Juga bisa
?>



//* ==================== Date & Time ====================
//* ===== Contoh Cara Dasar Menggunakan Date =====
<?php
// ===============================
// PHP DATE & TIME EXAMPLES
// ===============================

// 1. Tanggal & Waktu sekarang (fungsi date)
echo "Sekarang: " . date("Y-m-d H:i:s") . "\n\n";

// 2. Menggunakan DateTime
$now = new DateTime();
echo "DateTime Sekarang: " . $now->format('Y-m-d H:i:s') . "\n\n";

// 3. Membuat DateTime dari string
$date = new DateTime('2023-01-01 15:30:00');
echo "Tanggal Buatan: " . $date->format('d-m-Y H:i') . "\n\n";

// 4. Modifikasi Tanggal
$date->modify('+1 month')->modify('-10 days');
echo "Setelah Modifikasi: " . $date->format('Y-m-d') . "\n\n";

// 5. Selisih Tanggal (DateInterval)
$date1 = new DateTime("2025-01-01");
$date2 = new DateTime("2025-08-26");
$diff = $date1->diff($date2);
echo "Selisih: " . $diff->format('%m bulan, %d hari') . "\n\n";

// 6. Timezone
$tz = new DateTimeZone("Asia/Jakarta");
$jakarta = new DateTime("now", $tz);
echo "Waktu Jakarta: " . $jakarta->format('Y-m-d H:i:s') . "\n\n";

// 7. Perulangan Tanggal (DatePeriod)
$start = new DateTime('2025-01-01');
$end   = new DateTime('2025-01-10');
$interval = new DateInterval('P2D'); // tiap 2 hari
$period = new DatePeriod($start, $interval, $end);

echo "Perulangan Tanggal:\n";
foreach ($period as $d) {
  echo $d->format("Y-m-d") . "\n";
}
?>

Sekarang: 2025-08-26 10:15:32

DateTime Sekarang: 2025-08-26 10:15:32

Tanggal Buatan: 01-01-2023 15:30

Setelah Modifikasi: 2023-01-22

Selisih: 7 bulan, 25 hari

Waktu Jakarta: 2025-08-26 10:15:32

Perulangan Tanggal:
2025-01-01
2025-01-03
2025-01-05
2025-01-07
2025-01-09



//* ==================== Exception ====================
Exception adalah mekanisme untuk menangani error di PHP dengan cara yang lebih rapi.
Daripada script langsung berhenti saat error, kita bisa menangkap (catch) error tersebut, lalu mengambil tindakan tertentu.

//* ===== konsep utama =====
throw → digunakan untuk melempar exception.
try → blok kode yang "dicoba" dijalankan.
catch → menangkap exception kalau ada error.
finally → blok kode yang selalu dijalankan (opsional).

//* ===== Contoh =====
<?php
function bagi($a, $b)
{
  if ($b == 0) {
    throw new Exception("Tidak bisa dibagi dengan nol!");
  }
  return $a / $b;
}

try {
  echo bagi(10, 2) . "\n";  // sukses
  echo bagi(5, 0) . "\n";   // error, dilempar exception
} catch (Exception $e) {
  echo "Error: " . $e->getMessage() . "\n";
} finally {
  echo "Selesai proses.\n";
}

//5
// Error: Tidak bisa dibagi dengan nol!
// Selesai proses.

?>



//* ==================== Regular Expression ====================
Regular Expression (RegEx) adalah pola (pattern) untuk mencari, mencocokkan (match), atau memanipulasi string (teks).

Di PHP, RegEx bisa digunakan untuk:
=====> Validasi input (email, nomor HP, password, dsb).
=====> Cari dan ganti teks.
=====> Ekstrak informasi dari string.

//* ===== fungsi utama =====
preg_match($pattern, $string)
→ Mencari apakah string sesuai pattern. Hasil true/false.

preg_match_all($pattern, $string)
→ Mencari semua match dalam string. Hasil array.

preg_replace($pattern, $replacement, $string)
→ Cari teks sesuai pattern, lalu ganti.

preg_split($pattern, $string)
→ Memecah string berdasarkan pattern.

//* ===== Contoh utama =====
<?php
// 1. Validasi email
$email = "tino@example.com";
if (preg_match("/^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$/", $email)) {
  echo "Email valid\n";
} else {
  echo "Email tidak valid\n";
}

// 2. Cari kata "PHP" (case-insensitive)
$text = "Saya belajar php dan PHP sangat menyenangkan!";
preg_match_all("/php/i", $text, $matches);
print_r($matches);

// 3. Ganti angka dengan tanda *
$angka = "Nomor saya 082312345678";
echo preg_replace("/[0-9]/", "*", $angka) . "\n";

// 4. Split string berdasarkan spasi
$kalimat = "Belajar PHP itu mudah";
$kata = preg_split("/\s+/", $kalimat);
print_r($kata);
?>



//* ==================== Reflection ====================
Reflection di PHP adalah fitur bawaan yang memungkinkan kita melihat, membaca, dan memanipulasi informasi tentang class, method, property, dan fungsi secara dinamis saat runtime.

//* ===== kapan digunakan =====
Framework: Banyak framework besar (misalnya Laravel, Symfony) menggunakan Reflection untuk membaca class controller, dependency injection, anotasi, dsb.

Debugging: Membaca isi class/fungsi tanpa harus buka kode sumber.

Tooling: Membuat dokumentasi otomatis, testing, atau code analyzer.

//* ===== contoh dasar =====
<?php
class User
{
  public $name;
  private $email;

  public function __construct($name, $email)
  {
    $this->name = $name;
    $this->email = $email;
  }

  public function sayHello($to)
  {
    return "Hello $to, my name is $this->name";
  }
}

// Membuat objek ReflectionClass
$refClass = new ReflectionClass('User');

// 1. Nama class
echo "Nama class: " . $refClass->getName() . "\n";

// 2. List property
echo "Properties:\n";
foreach ($refClass->getProperties() as $prop) {
  echo "- " . $prop->getName() . "\n";
}

// 3. List method
echo "Methods:\n";
foreach ($refClass->getMethods() as $method) {
  echo "- " . $method->getName() . "\n";
}

// 4. Info konstruktor
$constructor = $refClass->getConstructor();
echo "Constructor butuh " . $constructor->getNumberOfParameters() . " parameter\n";

// 5. Panggil method secara dinamis
$refMethod = $refClass->getMethod('sayHello');
$user = new User("Tino", "tino@example.com");
echo $refMethod->invoke($user, "Budi");

// Nama class: User
// Properties:
// - name
// - email
// Methods:
// - __construct
// - sayHello
// Constructor butuh 2 parameter
// Hello Budi, my name is Tino

?>