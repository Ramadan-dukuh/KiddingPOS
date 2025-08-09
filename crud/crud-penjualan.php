<?php
require_once 'koneksi.php';
$conn = koneksi();
function getAllBarang() {
    global $conn;
    $query = "
        SELECT 
            barang.*, 
            kategori.namakategori
        FROM barang
        LEFT JOIN kategori ON barang.idkategori = kategori.idkategori
    ";
    $result = mysqli_query($conn, $query);
    return $result;
}

function getAllKategori() {
    global $conn;
    $result = $conn->query("SELECT * FROM kategori ORDER BY idKategori DESC");
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    return $data;
}

function insertTransaksi($total, $bayar) {
    global $conn;
    $tanggal = date('Y-m-d H:i:s');
    $kembalian = $bayar - $total;

    // Mulai transaction
    mysqli_begin_transaction($conn);
    
    try {
        // Simpan transaksi utama
        $query = "INSERT INTO transaksi (tanggal, total, bayar, kembalian) 
                  VALUES ('$tanggal', $total, $bayar, $kembalian)";
        mysqli_query($conn, $query);
        $idTransaksi = mysqli_insert_id($conn);
        
        // Commit transaksi jika semua berhasil
        mysqli_commit($conn);
        return $idTransaksi;
    } catch (Exception $e) {
        // Rollback jika ada error
        mysqli_rollback($conn);
        return false;
    }
}

function insertDetailTransaksi($idTransaksi, $kodeBarang, $jumlah, $harga) {
    global $conn;
    $subtotal = $jumlah * $harga;

    // Mulai transaction
    mysqli_begin_transaction($conn);
    
    try {
        // Simpan detail transaksi
        $query = "INSERT INTO detail_transaksi (idTransaksi, kodeBarang, jumlah, harga, subtotal) 
                  VALUES ($idTransaksi, '$kodeBarang', $jumlah, $harga, $subtotal)";
        mysqli_query($conn, $query);
        
        // Update stok barang
        $updateStok = "UPDATE barang SET stok = stok - $jumlah WHERE kodeBarang = '$kodeBarang'";
        mysqli_query($conn, $updateStok);
        
        // Commit jika semua berhasil
        mysqli_commit($conn);
        return true;
    } catch (Exception $e) {
        // Rollback jika ada error
        mysqli_rollback($conn);
        return false;
    }
}
?>
