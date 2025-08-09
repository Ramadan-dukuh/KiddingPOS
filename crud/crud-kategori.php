<?php
require_once 'koneksi.php';
$conn = koneksi();

// Function to get all categories
function getKategori() {
    global $conn;
    $result = $conn->query("SELECT * FROM kategori ORDER BY idKategori DESC");
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    return $data;
}

// Handle CRUD operations
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        
        if ($action === 'add') {
            // Add new category
            $namaKategori = trim($_POST['namaKategori']);
            if (!empty($namaKategori)) {
                $stmt = $conn->prepare("INSERT INTO kategori (namaKategori) VALUES (?)");
                $stmt->bind_param("s", $namaKategori);
                $stmt->execute();
                $stmt->close();
            }
        } elseif ($action === 'edit') {
            // Edit category
            $id = intval($_POST['id']);
            $namaKategori = trim($_POST['namaKategori']);
            if (!empty($namaKategori) && $id > 0) {
                $stmt = $conn->prepare("UPDATE kategori SET namaKategori = ? WHERE idKategori = ?");
                $stmt->bind_param("si", $namaKategori, $id);
                $stmt->execute();
                $stmt->close();
            }
        }
    }
    header("Location: ../pages/kategori.php");
    exit;
}

// Handle delete action
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    if ($id > 0) {
        $stmt = $conn->prepare("DELETE FROM kategori WHERE idKategori = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
    header("Location: ../pages/kategori.php");
    exit;
}
?>