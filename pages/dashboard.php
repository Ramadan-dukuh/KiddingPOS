<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard</title>
  <link rel="shortcut icon" href="../img/Logo_Submark.png" type="image/x-icon">
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    /* Custom Tailwind CSS */
    .bg-primary { background-color: #212A3D; }
    .text-primary { color: #212A3D; }
    .border-primary { border-color: #212A3D; }
    .hover\:bg-primary:hover { background-color: #1a2332; }
    .hover\:text-primary:hover { color: #212A3D; }
    .focus\:ring-primary:focus { --tw-ring-color: #212A3D; }

    *{
        scroll-behavior: smooth;
    }
  </style>
</head>
<body class="bg-gray-100">
  <nav class="bg-white">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-16">
        <!-- Logo -->
        <div class="flex items-center">
          <img class="h-8 w-auto" src="../img/Logo-01.png" alt="Logo">
          <div class="hidden md:block ml-6">
            <div class="flex space-x-4">
              <a href="dashboard.php" class="text-primary bg-gray-100 px-3 py-2 rounded-md text-sm font-medium">Dashboard</a>
              <a href="penjualan.php" class="text-primary-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Penjualan</a>
              <a href="stok.php" class="text-primary-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Manajemen Stok</a>
              <a href="laporan.php" class="text-primary-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Laporan</a>
              <a href="kategori.php" class="text-primary-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Kategori</a>
            </div>
          </div>
        </div>

        <!-- Profile & Hamburger -->
        <div class="flex items-center space-x-4">
          <!-- Notification Bell -->
          <button class="p-1 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none rounded-full">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a3 3 0 1 1-5.714 0"/>
            </svg>
          </button>

          <!-- Profile Dropdown -->
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
            <button id="mobile-menu-button" class="text-primary-400 hover:text-gray-500 focus:outline-none">
              <svg id="hamburger" class="h-6 w-6 block" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5"/>
              </svg>
              <svg id="close" class="h-6 w-6 hidden" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M6 18L18 6M6 6l12 12"/>
              </svg>
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden md:hidden px-2 pt-2 pb-3 space-y-1">
      <a href="dashboard.php" class="block text-primary bg-gray-100 px-3 py-2 rounded-md text-base font-medium">Dashboard</a>
      <a href="penjualan.php" class="block text-primary-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-base font-medium">Penjualan</a>
      <a href="stok.php" class="block text-primary-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-base font-medium">Manajemen Stok</a>
      <a href="laporan.php" class="block text-primary-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-base font-medium">Laporan</a>
      <a href="kategori.php" class="block text-primary-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-base font-medium">Kategori</a>
    </div>
  </nav>

  <main class="px-4 py-6">
    <!-- Contoh layout cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
  <div class="bg-white shadow rounded-lg p-4">
    <h3 class="text-gray-700 text-sm font-semibold">Total Penjualan Hari Ini</h3>
    <p class="text-2xl font-bold text-primary mt-2">Rp 1.250.000</p>
  </div>
  
  <div class="bg-white shadow rounded-lg p-4">
    <h3 class="text-gray-700 text-sm font-semibold">Jumlah Produk</h3>
    <p class="text-2xl font-bold text-primary mt-2">152</p>
  </div>

  <div class="bg-white shadow rounded-lg p-4">
    <h3 class="text-gray-700 text-sm font-semibold">Jumlah Produk</h3>
    <p class="text-2xl font-bold text-primary mt-2">152</p>
  </div>
  <!-- Tambah card lainnya -->
</div>

<div class="mt-6 bg-white rounded-lg shadow p-4">
  <h2 class="text-lg font-semibold mb-4">Transaksi Terbaru</h2>
  <table class="w-full text-sm text-left">
    <thead class="text-gray-500 border-b">
      <tr>
        <th class="py-2">Tanggal</th>
        <th class="py-2">ID Transaksi</th>
        <th class="py-2">Pelanggan</th>
        <th class="py-2">Total</th>
      </tr>
    </thead>
    <tbody>
      <tr class="border-b hover:bg-gray-50">
        <td class="py-2">2025-08-07</td>
        <td class="py-2">#TRX00123</td>
        <td class="py-2">Budi</td>
        <td class="py-2">Rp 150.000</td>
      </tr>
      <!-- Tambah baris lainnya -->
    </tbody>
  </table>
</div>

<div class="mt-6 flex space-x-4">
  <a href="#tambah-produk" class="bg-primary text-white px-4 py-2 rounded shadow hover:bg-gray-900">+ Tambah Produk</a>
  <a href="#tambah-transaksi" class="bg-primary text-white px-4 py-2 rounded shadow hover:bg-gray-900">+ Transaksi Baru</a>
</div>

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
  </script>
</body>
</html>
