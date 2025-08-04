<?php
// koneksi ke database
$host = "localhost";
$username = "root";
$password = "";
$database = "bmcwarung";
// membuat koneksi
$conn = mysqli_connect($host, $username, $password, $database);
// cek koneksi
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}    
?>