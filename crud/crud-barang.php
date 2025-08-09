<?php
require_once 'koneksi.php';

// Function to get all products with category names
function getAllBarang() {
    global $conn;
    $query = "SELECT barang.*, kategori.namaKategori 
              FROM barang 
              LEFT JOIN kategori ON barang.idKategori = kategori.idKategori";
    $result = mysqli_query($conn, $query);
    return $result;
}

// Function to get all categories for dropdown
function getAllKategori() {
    global $conn;
    $query = "SELECT * FROM kategori";
    $result = mysqli_query($conn, $query);
    return $result;
}

// Function to add new product
function tambahBarang($kode, $nama, $harga, $stok, $idKategori, $gambar) {
    global $conn;
    $query = "INSERT INTO barang (kodeBarang, namaBarang, hargaBarang, stok, idKategori, gambar) 
              VALUES ('$kode', '$nama', '$harga', '$stok', '$idKategori', '$gambar')";
    $result = mysqli_query($conn, $query);
    return $result;
}

// Function to get single product by ID
function getBarangById($id) {
    global $conn;
    $query = "SELECT * FROM barang WHERE kodeBarang = '$id'";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_assoc($result);
}

// Function to update product
function updateBarang($kode, $nama, $harga, $stok, $idKategori, $gambar = null) {
    global $conn;
    
    // If new image is uploaded
    if ($gambar) {
        $query = "UPDATE barang SET 
                  namaBarang = '$nama',
                  hargaBarang = '$harga',
                  stok = '$stok',
                  idKategori = '$idKategori',
                  gambar = '$gambar'
                  WHERE kodeBarang = '$kode'";
    } else {
        // Keep the existing image
        $query = "UPDATE barang SET 
                  namaBarang = '$nama',
                  hargaBarang = '$harga',
                  stok = '$stok',
                  idKategori = '$idKategori'
                  WHERE kodeBarang = '$kode'";
    }
    
    return mysqli_query($conn, $query);
}

// Function to delete product
function deleteBarang($kode) {
    global $conn;
    $query = "DELETE FROM barang WHERE kodeBarang = '$kode'";
    return mysqli_query($conn, $query);
}

// Handle form submission
function handleFormSubmission() {
    global $conn;
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nama = mysqli_real_escape_string($conn, $_POST['nama']);
        $harga = mysqli_real_escape_string($conn, $_POST['harga']);
        $stok = mysqli_real_escape_string($conn, $_POST['stok']);
        $idKategori = mysqli_real_escape_string($conn, $_POST['kategori']);
        
        // Handle image upload
        $gambar = '';
        if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = '../uploads/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            
            $fileExt = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
            $fileName = 'product_' . time() . '.' . $fileExt;
            $targetPath = $uploadDir . $fileName;
            
            if (move_uploaded_file($_FILES['gambar']['tmp_name'], $targetPath)) {
                $gambar = $targetPath;
            }
        }
        
        // Check if it's an edit or add operation
        if (isset($_POST['edit'])) {
            $kode = $_POST['kode'];
            
            // If no new image uploaded but existing image exists, keep the old one
            if (empty($gambar)) {
                $existingProduct = getBarangById($kode);
                if ($existingProduct && !empty($existingProduct['gambar'])) {
                    $gambar = $existingProduct['gambar'];
                }
            }
            
            // Update product
            if (updateBarang($kode, $nama, $harga, $stok, $idKategori, $gambar)) {
                $_SESSION['success'] = "Produk berhasil diperbarui!";
            } else {
                $_SESSION['error'] = "Gagal memperbarui produk: " . mysqli_error($conn);
            }
        } else {
            // Add new product
            $kode = 'PRD' . date('YmdHis') . rand(100, 999);
            
            if (tambahBarang($kode, $nama, $harga, $stok, $idKategori, $gambar)) {
                $_SESSION['success'] = "Produk berhasil ditambahkan!";
            } else {
                $_SESSION['error'] = "Gagal menambahkan produk: " . mysqli_error($conn);
            }
        }
        
        header("Location: ../pages/stok.php");
        exit();
    }
}

// Handle delete action
if (isset($_GET['delete'])) {
    $kode = $_GET['delete'];
    if (deleteBarang($kode)) {
        $_SESSION['success'] = "Produk berhasil dihapus!";
    } else {
        $_SESSION['error'] = "Gagal menghapus produk: " . mysqli_error($conn);
    }
    header("Location: ../pages/stok.php");
    exit();
}

session_start();
handleFormSubmission();

// Get all products and categories
$products = getAllBarang();
$categories = getAllKategori();
$productCount = mysqli_num_rows($products);

// Check if we're editing a product
if (isset($_GET['edit'])) {
    $editProduct = getBarangById($_GET['edit']);
    if (!$editProduct) {
        $_SESSION['error'] = "Produk tidak ditemukan!";
        header("Location: ../pages/stok.php");
        exit();
    }
}
?>