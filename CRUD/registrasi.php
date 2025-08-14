<?php
session_start();
include "connect.php";

if (isset($_POST['registrasi'])) {
  $username = trim($_POST["username"]);
  $email = trim($_POST["email"]);
  $password = $_POST["password"];
  $konfpassword = $_POST["konfpassword"];

  // Cek apakah email sudah ada
  $stmt = $koneksi->prepare("SELECT id FROM user WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $stmt->store_result();  // Cukup simpan hasil di memori

  if ($stmt->num_rows > 0) {
    echo "<script>alert('Email sudah digunakan, silahkan gunakan yang lain!'); window.location.href='registrasi.php';</script>";
    $stmt->close();
    exit;
  }
  $stmt->close();

  // Cek konfirmasi password
  if ($password !== $konfpassword) {
    echo "<script>alert('Pastikan kata sandi yang kamu masukkan sama!'); window.location.href='registrasi.php';</script>";
    exit;
  }

  // Hash password jangan pakai md5
  $hashed_password = password_hash($password, PASSWORD_DEFAULT);

  // Simpan ke database
  $stmt_insert = $koneksi->prepare("INSERT INTO user (username, email, password) VALUES (?, ?, ?)");
  $stmt_insert->bind_param("sss", $username, $email, $hashed_password);

  if ($stmt_insert->execute()) {
    echo "<script>alert('Berhasil mendaftar! Silakan login.'); window.location.href='login.php';</script>";
  } else {
    echo "<script>alert('Terjadi kesalahan saat mendaftar.'); window.location.href='registrasi.php';</script>";
  }

  $stmt_insert->close();
  $koneksi->close();
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
  <title>Registrasi</title>
</head>

<body class="bg-light">
  <div class="container pt-5">
    <h1>Selamat datang</h1>

    <div class="card mb-4">
      <div class="card-header text-center font-weight-bold">Registrasi</div>
      <div class="card-body">
        <form method="post">
          <div class="mb-3">
            <label for="username">Nama</label>
            <input type="text" name="username" class="form-control" required id="username" autofocus placeholder="Masukkan username">
          </div>
          <div class="mb-3">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" required id="email" autofocus placeholder="Masukkan email">
          </div>
          <div class="mb-3">
            <label for="password">Password</label>
            <input type="password" name="password" class="form-control" required id="password">
          </div>
          <div class="mb-3">
            <label for="konfpassword">Konfirmasi password </label>
            <input type="password" name="konfpassword" class="form-control" required id="konfpassword">
          </div>

          <button type="submit" name="registrasi" class="btn btn-outline-primary">
            <i class="fas fa-paper-plane"></i> Kirim
          </button>
        </form>
      </div>
      <p class="text-end me-3 pe-3">Sudah punya akun? <a href="login.php">Login</a></p>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
</body>

</html>