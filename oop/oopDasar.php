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





//* ==================== Static keyword ====================
=====> static dalam OOP PHP artinya property atau method yang dimiliki oleh class itu sendiri, bukan oleh object.
=====> Jadi, untuk mengaksesnya tidak perlu bikin objek dengan new, tapi langsung lewat nama class.

//* ===== static property =====
<?php
class Contoh {
  public static $angka = 0;
  
  public static function tambah() {
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
class Config {
  const APP_VERSION = "1.0.0";
}

echo Config::APP_VERSION; // 1.0.0
?>



//* ==================== Abstract Class ====================
Abstract class adalah class dasar yang tidak bisa dibuat objek langsung, hanya bisa diturunkan.

<?php 
abstract class Hewan {
  abstract public function suara(); // harus di-override child class

  public function info() {
    return "Ini adalah hewan.";
  }
}

class Kucing extends Hewan {
  public function suara() {
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
interface Kendaraan {
  public function jalan();   // hanya deklarasi
}

class Mobil implements Kendaraan {
  public function jalan() {
    return "Mobil sedang melaju 🚗";
  }
}

class Motor implements Kendaraan {
  public function jalan() {
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

class User {
  public function getName() {
    return "User dari Models";
  }
}
?>

<?php
// File: Controllers/User.php
namespace App\Controllers;

class User {
  public function getName() {
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