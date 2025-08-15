<?php
session_start();
include "connect.php";

$public_pages = ['login.php', 'registrasi.php'];
$current_file = basename($_SERVER['PHP_SELF']);

if (!in_array($current_file, $public_pages)) {
  // Kalau tidak ada session, cek cookie remember
  if (!isset($_SESSION["id"]) && isset($_COOKIE["remember"])) {
    $token = $_COOKIE["remember"];

    $stmt = $koneksi->prepare("SELECT id, username, remember_token FROM user WHERE remember_token IS NOT NULL");
    $stmt->execute();
    $result = $stmt->get_result();

    $valid_user = null;
    while ($row = $result->fetch_assoc()) {
      if (password_verify($token, $row["remember_token"])) {
        $valid_user = $row;
        break;
      }
    }

    if ($valid_user) {
      $_SESSION["id"] = $valid_user["id"];
      $_SESSION["username"] = $valid_user["username"];

      // perpanjang cookie 30 hari lagi
      setcookie(
        "remember",
        $token,
        time() + (30 * 24 * 60 * 60),
        "/",
        "",
        false, // false kalau localhost
        true
      );
    } else {
      // kalau token salah, hapus cookie
      setcookie("remember", "", time() - 3600, "/");
      header("Location: login.php");
      exit();
    }
  }

  // kalau tetap tidak ada session, redirect ke login
  if (!isset($_SESSION["id"])) {
    header("Location: login.php");
    exit();
  }
}
