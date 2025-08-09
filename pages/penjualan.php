<?php
require_once '../crud/crud-penjualan.php';

// Ambil semua kategori
$kategoriList = getAllKategori();

// Ambil barang sesuai kategori & pencarian
$barangList = [];

$kategori_id = isset($_GET['kategori_id']) ? $_GET['kategori_id'] : '';
$search = isset($_GET['search']) ? $_GET['search'] : '';

$where = [];

if ($kategori_id != '') {
    $where[] = "idKategori = '" . mysqli_real_escape_string($conn, $kategori_id) . "'";
}
if ($search != '') {
    $where[] = "namaBarang LIKE '%" . mysqli_real_escape_string($conn, $search) . "%'";
}

$whereSql = '';
if (count($where) > 0) {
    $whereSql = "WHERE " . implode(' AND ', $where);
}

$query = "SELECT * FROM barang $whereSql ORDER BY namaBarang ASC";
$barangList = mysqli_query($conn, $query);

// Proses transaksi
if (isset($_POST['simpan_transaksi'])) {
    // Validasi stok sebelum menyimpan
    $valid = true;
    foreach ($_POST['barang'] as $barang) {
        $checkStok = mysqli_query($conn, "SELECT stok FROM barang WHERE kodeBarang = '".$barang['kode']."'");
        $stok = mysqli_fetch_assoc($checkStok)['stok'];
        
        if ($stok < $barang['jumlah']) {
            $valid = false;
            echo "<script>alert('Stok barang ".$barang['kode']." tidak mencukupi!');</script>";
            break;
        }
    }
    
    if ($valid) {
        // Hitung total
        $total = 0;
        foreach ($_POST['barang'] as $barang) {
            $total += $barang['harga'] * $barang['jumlah'];
        }
        
        // Simpan transaksi
        $idTransaksi = insertTransaksi($total, $_POST['bayar']);
        
        if ($idTransaksi) {
            // Simpan detail transaksi
            foreach ($_POST['barang'] as $barang) {
                insertDetailTransaksi(
                    $idTransaksi, 
                    $barang['kode'], 
                    $barang['jumlah'], 
                    $barang['harga']
                );
            }
            
            echo "<script>
                alert('Transaksi berhasil disimpan!');
                window.location='penjualan.php';
            </script>";
        } else {
            echo "<script>alert('Gagal menyimpan transaksi!');</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Penjualan</title>
  <link rel="shortcut icon" href="../img/Logo_Submark.png" type="image/x-icon">

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>

  <style>
    .bg-primary { background-color: #212A3D; }
    .text-primary { color: #212A3D; }
    .border-primary { border-color: #212A3D; }
    .hover\:bg-primary:hover { background-color: #1a2332; }
    .focus\:ring-primary:focus { --tw-ring-color: #212A3D; }
    * { scroll-behavior: smooth; }
  </style>
</head>
<body class="bg-gray-100">

<!-- Navbar -->
<nav class="bg-white shadow sticky top-0 z-50">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between h-16">
      <!-- Logo & Menu -->
      <div class="flex items-center">
        <img class="h-8 w-auto" src="../img/Logo-01.png" alt="Logo" />
        <div class="hidden md:block ml-6">
          <div class="flex space-x-4">
            <a href="dashboard.php" class="text-primary hover:bg-gray-200 px-3 py-2 rounded-md text-sm font-medium">Dashboard</a>
            <a href="penjualan.php" class="bg-primary text-white px-3 py-2 rounded-md text-sm font-medium">Penjualan</a>
            <a href="stok.php" class="text-primary hover:bg-gray-200 px-3 py-2 rounded-md text-sm font-medium">Manajemen Stok</a>
            <a href="laporan.php" class="text-primary hover:bg-gray-200 px-3 py-2 rounded-md text-sm font-medium">Laporan</a>
            <a href="kategori.php" class="text-primary hover:bg-gray-200 px-3 py-2 rounded-md text-sm font-medium">Kategori</a>
          </div>
        </div>
      </div>

      <!-- Aksi -->
      <div class="flex items-center space-x-4">
        <button class="p-2 text-primary hover:text-gray-700 focus:outline-none">
          <i class="fas fa-bell text-lg"></i>
        </button>

        <!-- Profile -->
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

        <!-- Mobile Menu Button -->
        <div class="md:hidden">
          <button id="mobile-menu-button" class="text-primary focus:outline-none">
            <i class="fas fa-bars text-xl" id="hamburger"></i>
            <i class="fas fa-times hidden text-xl" id="close"></i>
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Mobile Menu -->
  <div id="mobile-menu" class="hidden md:hidden px-2 pt-2 pb-3 space-y-1">
    <a href="dashboard.php" class="block text-primary hover:bg-gray-200 px-3 py-2 rounded-md text-base font-medium">Dashboard</a>
    <a href="penjualan.php" class="block bg-primary text-white px-3 py-2 rounded-md text-base font-medium">Penjualan</a>
    <a href="stok.php" class="block text-primary hover:bg-gray-200 px-3 py-2 rounded-md text-base font-medium">Manajemen Stok</a>
    <a href="laporan.php" class="block text-primary hover:bg-gray-200 px-3 py-2 rounded-md text-base font-medium">Laporan</a>
    <a href="kategori.php" class="block text-primary hover:bg-gray-200 px-3 py-2 rounded-md text-base font-medium">Kategori</a>
  </div>
</nav>

<!-- Main Content -->
<main class="max-w-7xl mx-auto px-4 py-8 grid grid-cols-1 lg:grid-cols-3 gap-6">

  <!-- Kiri: Produk -->
<section class="lg:col-span-2 bg-white p-6 rounded-lg shadow">
  <!-- Form Pencarian & Filter -->
  <form method="get" action="" class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    
    <!-- Input Pencarian -->
    <div class="relative col-span-1 md:col-span-1">
      <input 
        type="text" 
        name="search" 
        value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>" 
        placeholder="Cari produk..." 
        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary"
      />
    </div>

    <!-- Filter Kategori -->
    <div class="col-span-1">
      <select 
        name="kategori_id" 
        onchange="this.form.submit()" 
        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary"
      >
        <option value="">-- Semua Kategori --</option>
        <?php foreach ($kategoriList as $kategori) { ?>
          <option value="<?= $kategori['idKategori']; ?>" <?= ($kategori_id == $kategori['idKategori']) ? 'selected' : ''; ?>>
            <?= $kategori['namaKategori']; ?>
          </option>
        <?php } ?>
      </select>
    </div>

    <!-- Tombol Cari -->
    <div class="col-span-1 flex items-center">
      <button 
        type="submit" 
        class="w-full bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg flex items-center justify-center gap-2"
      >
        <i class="fas fa-search"></i> Cari
      </button>
    </div>
    
  </form>


    <!-- Daftar Produk -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
      <?php if (!empty($barangList) && mysqli_num_rows($barangList) > 0) { ?>
        <!-- Di bagian tampilan produk (ubah bagian while loop) -->
<?php while ($barang = mysqli_fetch_assoc($barangList)) { ?>
    <div class="bg-white border border-gray-200 rounded-lg shadow hover:shadow-lg transition duration-200 p-4 text-center">
        <?php if (!empty($barang['gambar'])): ?>
            <img src="<?php echo $barang['gambar']; ?>" class="w-24 h-24 mx-auto object-cover rounded mb-3">
        <?php else: ?>
            <div class="w-24 h-24 mx-auto bg-gray-100 rounded-full flex items-center justify-center mb-3">
                <i class="fas fa-box text-3xl text-gray-400"></i>
            </div>
        <?php endif; ?>
        <h3 class="font-semibold text-gray-800"><?= $barang['namaBarang']; ?></h3>
        <p class="text-gray-500 mb-1">Rp <?= number_format($barang['hargaBarang'], 0, ',', '.'); ?></p>
        <p class="text-sm mb-2 <?= $barang['stok'] > 0 ? 'text-green-600' : 'text-red-600' ?>">
            Stok: <?= $barang['stok']; ?>
        </p>
        <button 
            type="button" 
            onclick="tambahKeKeranjang('<?= $barang['kodeBarang']; ?>','<?= $barang['namaBarang']; ?>',<?= $barang['hargaBarang']; ?>,<?= $barang['stok']; ?>)" 
            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg shadow-sm transition duration-200 <?= $barang['stok'] <= 0 ? 'opacity-50 cursor-not-allowed' : '' ?>"
            <?= $barang['stok'] <= 0 ? 'disabled' : '' ?>
        >
            <i class="fas fa-plus mr-1"></i> Tambah
        </button>
    </div>
<?php } ?>
      <?php } else { ?>
        <div class="col-span-full text-center text-gray-400 py-10">
          <i class="fas fa-box-open text-5xl mb-3"></i>
          <p class="text-lg">Produk akan muncul di sini...</p>
        </div>
      <?php } ?>
    </div>
  </section>

  <!-- Kanan: Keranjang -->
  <aside class="bg-white p-6 rounded-lg shadow-lg flex flex-col sticky top-6 h-fit">
    <div class="flex justify-between items-center mb-4 border-b pb-2">
      <h2 class="text-xl font-semibold flex items-center gap-2 text-primary">
        <i class="fas fa-cart-shopping"></i> Keranjang
      </h2>
      <button type="button" onclick="kosongkanKeranjang()" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm flex items-center gap-1">
        <i class="fas fa-trash-alt"></i> Kosongkan
      </button>
    </div>

    <div id="keranjangList" class="text-gray-500 mb-4 space-y-2">Keranjang kosong</div>

    <div class="border-t pt-3 text-sm">
      <p>Subtotal: <span id="subtotal" class="float-right text-gray-700">Rp 0</span></p>
      <p class="font-bold text-blue-600 mt-2">Total: <span id="total" class="float-right text-blue-600">Rp 0</span></p>
    </div>

    <div class="mt-4">
      <label class="block text-sm font-semibold mb-1">Jumlah Bayar:</label>
      <input type="number" id="jumlahBayar" oninput="hitungKembalian()" placeholder="Masukkan jumlah bayar" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary">
      <p class="text-sm mt-2">Kembalian: <span id="kembalian" class="font-semibold text-green-600">Rp 0</span></p>
    </div>

    <button onclick="prosesPembayaran()" class="mt-4 w-full bg-green-500 hover:bg-green-600 text-white font-semibold py-2 rounded-lg flex items-center justify-center gap-2">
      <i class="fas fa-credit-card"></i> Proses Pembayaran
    </button>
  </aside>
</main>

<script>
let keranjang = [];

function formatRupiah(angka) {
    return 'Rp ' + angka.toLocaleString('id-ID');
}

function renderKeranjang() {
    let list = document.getElementById('keranjangList');
    if (keranjang.length === 0) {
        list.innerHTML = 'Keranjang kosong';
        document.getElementById('subtotal').innerText = 'Rp 0';
        document.getElementById('total').innerText = 'Rp 0';
        return;
    }
    
    let html = '';
    let subtotal = 0;
    keranjang.forEach((item, index) => {
        let totalItem = item.harga * item.jumlah;
        subtotal += totalItem;
        html += `
            <div class="flex justify-between items-center mb-2 border-b pb-2">
                <div class="w-3/4">
                    <p class="font-medium">${item.nama}</p>
                    <p class="text-sm text-gray-500">${item.jumlah} x ${formatRupiah(item.harga)}</p>
                    <p class="text-xs text-gray-400">Stok tersedia: ${item.stok}</p>
                </div>
                <div class="flex items-center gap-2">
                    <button onclick="kurangiJumlah(${index})" class="bg-gray-200 hover:bg-gray-300 w-6 h-6 rounded flex items-center justify-center">
                        -
                    </button>
                    <span>${item.jumlah}</span>
                    <button onclick="tambahJumlah(${index})" class="bg-gray-200 hover:bg-gray-300 w-6 h-6 rounded flex items-center justify-center ${item.jumlah >= item.stok ? 'opacity-50 cursor-not-allowed' : ''}" ${item.jumlah >= item.stok ? 'disabled' : ''}>
                        +
                    </button>
                </div>
                <p class="w-1/4 text-right">${formatRupiah(totalItem)}</p>
            </div>
        `;
    });
    list.innerHTML = html;
    document.getElementById('subtotal').innerText = formatRupiah(subtotal);
    document.getElementById('total').innerText = formatRupiah(subtotal);
}

function tambahKeKeranjang(kode, nama, harga, stok) {
    let produk = keranjang.find(p => p.kode === kode);
    
    if (produk) {
        if (produk.jumlah >= produk.stok) {
            alert('Stok tidak mencukupi!');
            return;
        }
        produk.jumlah += 1;
    } else {
        if (stok <= 0) {
            alert('Stok habis!');
            return;
        }
        keranjang.push({ kode, nama, harga, stok, jumlah: 1 });
    }
    renderKeranjang();
}

function tambahJumlah(index) {
    if (keranjang[index].jumlah < keranjang[index].stok) {
        keranjang[index].jumlah += 1;
        renderKeranjang();
    }
}

function kurangiJumlah(index) {
    keranjang[index].jumlah -= 1;
    if (keranjang[index].jumlah <= 0) {
        keranjang.splice(index, 1);
    }
    renderKeranjang();
}

function kosongkanKeranjang() {
    keranjang = [];
    renderKeranjang();
}

function hitungKembalian() {
    let bayar = parseInt(document.getElementById('jumlahBayar').value) || 0;
    let total = keranjang.reduce((sum, item) => sum + (item.harga * item.jumlah), 0);
    let kembali = bayar - total;
    document.getElementById('kembalian').innerText = formatRupiah(kembali > 0 ? kembali : 0);
}

function prosesPembayaran() {
    if (keranjang.length === 0) {
        alert('Keranjang masih kosong!');
        return;
    }
    
    let total = keranjang.reduce((sum, item) => sum + (item.harga * item.jumlah), 0);
    let bayar = parseInt(document.getElementById('jumlahBayar').value) || 0;
    
    if (bayar < total) {
        alert('Jumlah bayar kurang dari total!');
        return;
    }
    
    // Buat form data
    let formData = new FormData();
    formData.append('simpan_transaksi', true);
    formData.append('total', total);
    formData.append('bayar', bayar);
    
    // Tambahkan barang ke formData
    keranjang.forEach((item, index) => {
        formData.append(`barang[${index}][kode]`, item.kode);
        formData.append(`barang[${index}][jumlah]`, item.jumlah);
        formData.append(`barang[${index}][harga]`, item.harga);
    });
    
    // Kirim ke server
    fetch('penjualan.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        alert('Transaksi berhasil!');
        window.location.reload();
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat menyimpan transaksi');
    });
}
</script>

<script>
const profileBtn = document.getElementById('profile-button');
const profileMenu = document.getElementById('profile-menu');
profileBtn.addEventListener('click', () => {
  profileMenu.classList.toggle('hidden');
});

const mobileMenuBtn = document.getElementById('mobile-menu-button');
const mobileMenu = document.getElementById('mobile-menu');
const hamburgerIcon = document.getElementById('hamburger');
const closeIcon = document.getElementById('close');

mobileMenuBtn.addEventListener('click', () => {
  mobileMenu.classList.toggle('hidden');
  hamburgerIcon.classList.toggle('hidden');
  closeIcon.classList.toggle('hidden');
});

document.addEventListener('click', (e) => {
  if (!profileBtn.contains(e.target) && !profileMenu.contains(e.target)) {
    profileMenu.classList.add('hidden');
  }
});
</script>
</body>
</html>
