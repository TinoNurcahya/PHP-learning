<?php
session_start();
include "connect.php";

$error = null;

if (isset($_POST['login'])) {
  $username = trim($_POST["username"]);
  $password = $_POST["password"];

  // Validasi input
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

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
  <script src="https://kit.fontawesome.com/c8f4e6dde8.js" crossorigin="anonymous"></script>
  <link rel="shortcut icon" href="img/gajah.png" type="image/x-icon">
  <link rel="stylesheet" href="style.css">
  <title>Login</title>
</head>

<body class="bg-light">
  <div class="container pt-5">
    <h1>Selamat datang kembali</h1>

    <div class="card mb-4">
      <div class="card-header text-center font-weight-bold">Login</div>
      <div class="card-body">
        <form method="post">
          <div class="mb-3">
            <label for="username">Nama</label>
            <input type="text" name="username" class="form-control" required id="username" autofocus placeholder="Masukkan username/email">
          </div>

          <?php if (isset($error)) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <i class="fas fa-exclamation-circle me-2"></i>
              <?php echo htmlspecialchars($error); ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          <?php endif; ?>

          <div class="mb-3">
            <label for="password">Password</label>
            <input type="password" name="password" class="form-control" required id="password">
          </div>

          <button type="submit" name="login" class="btn btn-outline-primary">
            <i class="fas fa-paper-plane"></i> Masuk
          </button>
        </form>
      </div>
      <p class="text-end me-3 pe-3">Belum punya akun? <a href="registrasi.php">Registrasi</a></p>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
</body>

</html>