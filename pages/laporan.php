<?php
require_once '../crud/koneksi.php';
session_start();

// Fungsi untuk mendapatkan data transaksi terakhir
function getTransaksiTerakhir($limit = 5) {
    global $conn;
    $query = "SELECT t.idTransaksi, t.tanggal, t.total, 
                     GROUP_CONCAT(b.namaBarang SEPARATOR ', ') AS produk,
                     GROUP_CONCAT(dt.jumlah SEPARATOR ', ') AS jumlah
              FROM transaksi t
              JOIN detail_transaksi dt ON t.idTransaksi = dt.idTransaksi
              JOIN barang b ON dt.kodeBarang = b.kodeBarang
              GROUP BY t.idTransaksi
              ORDER BY t.tanggal DESC
              LIMIT $limit";
    return mysqli_query($conn, $query);
}

// Fungsi untuk mendapatkan data penjualan harian
function getPenjualanHarian() {
    global $conn;
    $query = "SELECT DAYNAME(tanggal) AS hari, 
                     COUNT(*) AS jumlah_transaksi, 
                     SUM(total) AS total_penjualan
              FROM transaksi
              WHERE tanggal >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
              GROUP BY DAYNAME(tanggal)
              ORDER BY tanggal";
    return mysqli_query($conn, $query);
}

// Fungsi untuk mendapatkan produk terlaris
function getProdukTerlaris($limit = 5) {
    global $conn;
    $query = "SELECT b.namaBarang, SUM(dt.jumlah) AS total_terjual
              FROM detail_transaksi dt
              JOIN barang b ON dt.kodeBarang = b.kodeBarang
              GROUP BY b.namaBarang
              ORDER BY total_terjual DESC
              LIMIT $limit";
    return mysqli_query($conn, $query);
}

// Fungsi untuk export ke Excel
function exportToExcel() {
    global $conn;
    
    // Header untuk file Excel
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="laporan_penjualan_'.date('Ymd').'.xls"');
    
    // Query data untuk export
    $query = "SELECT t.idTransaksi, t.tanggal, 
                     b.namaBarang AS produk, 
                     dt.jumlah, 
                     dt.harga,
                     (dt.jumlah * dt.harga) AS subtotal,
                     t.total
              FROM transaksi t
              JOIN detail_transaksi dt ON t.idTransaksi = dt.idTransaksi
              JOIN barang b ON dt.kodeBarang = b.kodeBarang
              ORDER BY t.tanggal DESC";
    $result = mysqli_query($conn, $query);
    
    echo '<table border="1">
            <tr>
                <th>ID Transaksi</th>
                <th>Tanggal</th>
                <th>Produk</th>
                <th>Jumlah</th>
                <th>Harga Satuan</th>
                <th>Subtotal</th>
                <th>Total Transaksi</th>
            </tr>';
    
    while($row = mysqli_fetch_assoc($result)) {
        echo '<tr>
                <td>'.$row['idTransaksi'].'</td>
                <td>'.$row['tanggal'].'</td>
                <td>'.$row['produk'].'</td>
                <td>'.$row['jumlah'].'</td>
                <td>Rp '.number_format($row['harga'], 0, ',', '.').'</td>
                <td>Rp '.number_format($row['subtotal'], 0, ',', '.').'</td>
                <td>Rp '.number_format($row['total'], 0, ',', '.').'</td>
              </tr>';
    }
    
    echo '</table>';
    exit();
}

// Handle export request
if(isset($_GET['export'])) {
    exportToExcel();
}

// Ambil data dari database
$transaksiTerakhir = getTransaksiTerakhir();
$penjualanHarian = getPenjualanHarian();
$produkTerlaris = getProdukTerlaris();

// Siapkan data untuk chart
$labelsHarian = [];
$dataHarian = [];

$labelsProduk = [];
$dataProduk = [];

// Proses data penjualan harian
while ($row = mysqli_fetch_assoc($penjualanHarian)) {
    $labelsHarian[] = $row['hari'];
    $dataHarian[] = $row['total_penjualan'];
}

// Proses data produk terlaris
while ($row = mysqli_fetch_assoc($produkTerlaris)) {
    $labelsProduk[] = $row['namaBarang'];
    $dataProduk[] = $row['total_terjual'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Laporan</title>
  <link rel="shortcut icon" href="../img/Logo_Submark.png" type="image/x-icon">

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <style>
    .bg-primary { background-color: #212A3D; }
    .text-primary { color: #212A3D; }
    .border-primary { border-color: #212A3D; }
    .hover\:bg-primary:hover { background-color: #1a2332; }
    .hover\:text-primary:hover { color: #212A3D; }
    .focus\:ring-primary:focus { --tw-ring-color: #212A3D; }
    * { scroll-behavior: smooth; }
  </style>
</head>
<body class="bg-gray-100">
  <!-- Navbar -->
  <nav class="bg-white shadow">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-16">
        <div class="flex items-center">
          <img class="h-8 w-auto" src="../img/Logo-01.png" alt="Logo" />
          <div class="hidden md:block ml-6">
            <div class="flex space-x-4">
              <a href="dashboard.php" class="text-primary hover:bg-gray-200 px-3 py-2 rounded-md text-sm font-medium">Dashboard</a>
              <a href="penjualan.php" class="text-primary hover:bg-gray-200 px-3 py-2 rounded-md text-sm font-medium">Penjualan</a>
              <a href="stok.php" class="text-primary hover:bg-gray-200 px-3 py-2 rounded-md text-sm font-medium">Manajemen Stok</a>
              <a href="laporan.php" class="bg-primary text-white px-3 py-2 rounded-md text-sm font-medium">Laporan</a>
              <a href="kategori.php" class="text-primary hover:bg-gray-200 px-3 py-2 rounded-md text-sm font-medium">Kategori</a>
            </div>
          </div>
        </div>

        <div class="flex items-center space-x-4">
          <button class="p-2 text-primary hover:text-gray-700 focus:outline-none">
            <i class="fas fa-bell text-lg"></i>
          </button>

          <div class="relative">
            <button id="profile-button" class="rounded-full focus:outline-none">
              <img class="h-8 w-8 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
            </button>
            <div id="profile-menu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
              <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Your Profile</a>
              <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
              <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Sign out</a>
            </div>
          </div>

          <div class="md:hidden">
            <button id="mobile-menu-button" class="text-primary focus:outline-none">
              <i class="fas fa-bars text-xl" id="hamburger"></i>
              <i class="fas fa-times hidden text-xl" id="close"></i>
            </button>
          </div>
        </div>
      </div>
    </div>

    <div id="mobile-menu" class="hidden md:hidden px-2 pt-2 pb-3 space-y-1">
      <a href="dashboard.php" class="block text-primary hover:bg-gray-200 px-3 py-2 rounded-md text-base font-medium">Dashboard</a>
      <a href="penjualan.php" class="block text-primary hover:bg-gray-200 px-3 py-2 rounded-md text-base font-medium">Penjualan</a>
      <a href="stok.php" class="block text-primary hover:bg-gray-200 px-3 py-2 rounded-md text-base font-medium">Manajemen Stok</a>
      <a href="laporan.php" class="block bg-primary text-white px-3 py-2 rounded-md text-base font-medium">Laporan</a>
      <a href="kategori.php" class="block text-primary hover:bg-gray-200 px-3 py-2 rounded-md text-base font-medium">Kategori</a>
    </div>
  </nav>

  <!-- Main Content -->
  <main class="max-w-7xl mx-auto px-4 py-8 space-y-8">
    <!-- Header dan Tombol Export -->
    <div class="flex justify-between items-center">
      <h1 class="text-2xl font-bold text-primary">Laporan Penjualan</h1>
      <a href="?export=1" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg flex items-center gap-2">
        <i class="fas fa-file-excel"></i> Export to Excel
      </a>
    </div>

    <!-- Transaksi Terakhir -->
    <section class="bg-white p-6 rounded-lg shadow">
      <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold text-primary">Transaksi Terakhir</h2>
      </div>
      <div class="overflow-x-auto">
        <table class="min-w-full table-auto text-sm text-left">
          <thead class="bg-gray-100">
            <tr>
              <th class="px-4 py-2">Tanggal</th>
              <th class="px-4 py-2">ID Transaksi</th>
              <th class="px-4 py-2">Produk</th>
              <th class="px-4 py-2">Jumlah</th>
              <th class="px-4 py-2">Total</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($transaksi = mysqli_fetch_assoc($transaksiTerakhir)): ?>
              <tr class="border-t">
                <td class="px-4 py-2"><?= date('d/m/Y', strtotime($transaksi['tanggal'])) ?></td>
                <td class="px-4 py-2"><?= $transaksi['idTransaksi'] ?></td>
                <td class="px-4 py-2"><?= $transaksi['produk'] ?></td>
                <td class="px-4 py-2"><?= $transaksi['jumlah'] ?></td>
                <td class="px-4 py-2">Rp <?= number_format($transaksi['total'], 0, ',', '.') ?></td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </section>

    <!-- Grafik Penjualan dan Produk Terlaris -->
    <section class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <!-- Grafik Penjualan -->
      <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-semibold text-primary mb-4">Grafik Penjualan 7 Hari Terakhir</h2>
        <canvas id="salesChart" height="200"></canvas>
      </div>

      <!-- Grafik Produk Terlaris -->
      <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-semibold text-primary mb-4">5 Produk Terlaris</h2>
        <canvas id="topProductsChart" height="200"></canvas>
      </div>
    </section>
  </main>

  <script>
    // Toggle profile dropdown
    const profileBtn = document.getElementById('profile-button');
    const profileMenu = document.getElementById('profile-menu');
    profileBtn.addEventListener('click', () => {
      profileMenu.classList.toggle('hidden');
    });

    // Toggle mobile menu
    const mobileMenuBtn = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    const hamburgerIcon = document.getElementById('hamburger');
    const closeIcon = document.getElementById('close');

    mobileMenuBtn.addEventListener('click', () => {
      mobileMenu.classList.toggle('hidden');
      hamburgerIcon.classList.toggle('hidden');
      closeIcon.classList.toggle('hidden');
    });

    // Optional: close profile dropdown when clicking outside
    document.addEventListener('click', (e) => {
      if (!profileBtn.contains(e.target) && !profileMenu.contains(e.target)) {
        profileMenu.classList.add('hidden');
      }
    });

    // Grafik Penjualan
    const salesChart = new Chart(document.getElementById('salesChart').getContext('2d'), {
      type: 'line',
      data: {
        labels: <?= json_encode($labelsHarian) ?>,
        datasets: [{
          label: 'Total Penjualan (Rp)',
          data: <?= json_encode($dataHarian) ?>,
          borderColor: '#212A3D',
          backgroundColor: 'rgba(33, 42, 61, 0.1)',
          tension: 0.4
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              callback: function(value) {
                return 'Rp ' + value.toLocaleString('id-ID');
              }
            }
          }
        }
      }
    });

    // Grafik Produk Terlaris
    const topProductsChart = new Chart(document.getElementById('topProductsChart').getContext('2d'), {
      type: 'bar',
      data: {
        labels: <?= json_encode($labelsProduk) ?>,
        datasets: [{
          label: 'Jumlah Terjual',
          data: <?= json_encode($dataProduk) ?>,
          backgroundColor: '#212A3D'
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });
  </script>
</body>
</html>