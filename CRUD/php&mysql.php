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