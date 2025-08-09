<?php
require_once 'koneksi.php';
$conn = koneksi();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {  
  $email = trim($_POST['email']);
  $password = trim($_POST['password']);

  // Validasi input
  if (empty($email) || empty($password)) {
    echo "<script>alert('Semua field harus diisi!');</script>";
    exit;
  }

  // Cek apakah email sudah digunakan
  $cek = mysqli_prepare($conn, "SELECT iduser FROM user WHERE email = ?");
  mysqli_stmt_bind_param($cek, "s", $email);
  mysqli_stmt_execute($cek);
  mysqli_stmt_store_result($cek);

  if (mysqli_stmt_num_rows($cek) > 0) {
    echo "<script>alert('Email sudah terdaftar!');</script>";
    exit;
  }

  mysqli_stmt_close($cek);

  // Hash password
  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

  // Simpan data ke database (menggunakan prepared statement)
  $stmt = mysqli_prepare($conn, "INSERT INTO user (email, password, level) VALUES (?, ?, 'user')");
  mysqli_stmt_bind_param($stmt, "ss", $email, $hashedPassword);

  if (mysqli_stmt_execute($stmt)) {
    echo "<script>alert('Registrasi berhasil!');</script>";
    // Redirect to login page
    echo "<script>window.location.href = 'login.php';</script>";
  } else {
    echo "Error: " . mysqli_error($conn);
  }

  mysqli_stmt_close($stmt);
}
?>
