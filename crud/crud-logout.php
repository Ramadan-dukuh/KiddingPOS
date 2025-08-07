<?php
require_once 'koneksi.php';

// Proses logout
session_start();
if (isset($_SESSION['iduser'])) {
    // Hapus session
    unset($_SESSION['iduser']);
    session_destroy();
    
    // Redirect ke halaman login atau landing page
    echo "<script>alert('Anda telah berhasil logout.');</script>";
    echo "<script>window.location.href = '../pages/login.php';</script>";
} else {
    // Jika tidak ada session, redirect ke halaman login
    echo "<script>alert('Anda belum login.');</script>";
    echo "<script>window.location.href = '../pages/login.php';</script>";
}
?>