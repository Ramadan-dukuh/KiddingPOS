<?php
require_once 'koneksi.php';
$conn = koneksi();

//untuk login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = trim($_POST['email']);
  $password = trim($_POST['password']);

  // Validasi input
  if (empty($email) || empty($password)) {
    echo "Semua field harus diisi!";
    exit;
  }

  // Cek apakah email ada di database
  $stmt = mysqli_prepare($conn, "SELECT iduser, password FROM user WHERE email = ?");
  mysqli_stmt_bind_param($stmt, "s", $email);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_store_result($stmt);

  if (mysqli_stmt_num_rows($stmt) === 0) {
    echo "<script>alert('Email tidak terdaftar!');</script>";
    exit;
  }

  mysqli_stmt_bind_result($stmt, $iduser, $hashedPassword);
  mysqli_stmt_fetch($stmt);
  
  // Verifikasi password
  if (!password_verify($password, $hashedPassword)) {
    echo "<script>alert('Password salah!');</script>";
    exit;
  }

  // Login berhasil
  session_start();
  $_SESSION['iduser'] = $iduser;
  
  echo "<script>alert('Login berhasil! Selamat datang di POS Warung UMKM.');</script>";
    // Redirect ke halaman dashboard atau halaman utama
    echo "<script>window.location.href = '../pages/dashboard.php';</script>";
  
  mysqli_stmt_close($stmt);
}

?>