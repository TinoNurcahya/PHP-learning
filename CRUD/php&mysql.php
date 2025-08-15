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

//* ===== Gaya prosedural (mysqli_connect()) =====
// mencacah data hasil query
// 4 cara :
// mysqli_fetch_row() : array numerik
// mysqli_fetch_assoc() : array associative
// mysqli_fetch_array() : keduanya
// mysqli_fetch_object() : object

//* ===== Gaya OOP ($conn = new mysqli) =====
// 4 cara :
// $result->fetch_row() : array numerik
// $result->fetch_assoc : array associative
// $result->fetch_array : keduanya
// $result->fetch_object : object

<?php
$stmt = $conn->prepare("SELECT * FROM admin WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$data_user = $result->fetch_assoc();
$stmt->close();
?>

<?php if ($data_user): ?>
  <table border="1" cellpadding="5" cellspacing="0">
    <tr>
      <th>Username</th>
      <th>Password</th>
    </tr>
    <tr>
      <td><?= htmlspecialchars($data_user["username"]) ?></td>
      <td><?= htmlspecialchars($data_user["password"]) ?></td>
    </tr>
  </table>
<?php else: ?>
  <p>Data tidak ditemukan.</p>
<?php endif; ?>

========== $_SERVER["REQUEST_METHOD"] == "POST"
Kapan benar : Saat request pakai POST (form, API, dsb)
Kelebihan : Tidak tergantung nama tombol submit
Kekurangan: Akan true walaupun POST datang dari tempat lain (bukan form yang dimaksud)

========== isset($_POST['submit'])
Kapan benar : Saat tombol submit dengan name=submit diklik
Kelebihan : Lebih spesifik ke tombol tertentu
Kekurangan: Kalau tombol submit tidak punya name, tidak akan bekerja

========== trim() dan real_escape_string
Kalau pakai Prepared Statement ($stmt->bind_param()), kamu tidak perlu real_escape_string() karena binding parameter sudah aman.
Biasanya:

Gunakan trim() untuk membersihkan input teks.

Gunakan password_hash() untuk password.

Gunakan Prepared Statement untuk query agar tidak perlu escape manual.

//* ===== SESSION =====
//* ===== COOKIE =====