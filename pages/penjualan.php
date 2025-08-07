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
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
  />

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
              <a href="penjualan.php" class="bg-primary text-white px-3 py-2 rounded-md text-sm font-medium">Penjualan</a>
              <a href="stok.php" class="text-primary hover:bg-gray-200 px-3 py-2 rounded-md text-sm font-medium">Manajemen Stok</a>
              <a href="laporan.php" class="text-primary hover:bg-gray-200 px-3 py-2 rounded-md text-sm font-medium">Laporan</a>
              <a href="kategori.php" class="text-primary hover:bg-gray-200 px-3 py-2 rounded-md text-sm font-medium">Kategori</a>
            </div>
          </div>
        </div>

        <div class="flex items-center space-x-4">
          <!-- Notification -->
          <button class="p-2 text-primary hover:text-gray-700 focus:outline-none">
            <i class="fas fa-bell text-lg"></i>
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
    <!-- Kiri: Pencarian Produk -->
    <section class="lg:col-span-2 bg-white p-6 rounded-lg shadow">
      <div class="flex items-center gap-4 mb-4">
        <div class="relative flex-1">
          <input
            type="text"
            placeholder="Cari produk..."
            class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary"
          />
        </div>
        <select class="border border-gray-300 rounded px-3 py-2 text-gray-700">
          <option>Semua Kategori</option>
          <option>Makanan</option>
          <option>Minuman</option>
          <option>Snack</option>
        </select>
      </div>

      <div class="text-center text-gray-400 py-10">
        <i class="fas fa-box-open text-4xl mb-2"></i>
        <p>Produk akan muncul di sini...</p>
      </div>
    </section>

    <!-- Kanan: Keranjang -->
    <aside class="bg-white p-6 rounded-lg shadow">
      <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold flex items-center gap-2">
          <i class="fas fa-cart-shopping text-primary"></i> Keranjang
        </h2>
        <button class="bg-primary text-white px-3 py-1 rounded text-sm hover:bg-gray-800">
          <i class="fas fa-trash-alt mr-1"></i> Kosongkan
        </button>
      </div>

      <div class="text-gray-500 mb-4">
        Keranjang kosong
      </div>

      <hr class="my-4" />
      <div class="text-sm">
        <p>Subtotal: <span class="float-right text-gray-700">Rp 0</span></p>
        <p class="font-bold text-blue-600 mt-2">Total: <span class="float-right text-blue-600">Rp 0</span></p>
      </div>

      <hr class="my-4" />
      <label class="block text-sm font-semibold mb-1 mt-2">Jumlah Bayar:</label>
      <input
        type="number"
        placeholder="Masukkan jumlah bayar"
        class="w-full border border-gray-300 rounded px-3 py-2 mb-4 focus:outline-none focus:ring-2 focus:ring-primary"
      />

      <button class="w-full bg-green-500 hover:bg-green-600 text-white font-semibold py-2 rounded flex items-center justify-center gap-2">
        <i class="fas fa-credit-card"></i> Proses Pembayaran
      </button>
    </aside>
  </main>

  <script>
    // Simple toggle mobile menu
    document.getElementById("mobile-menu-button").addEventListener("click", function () {
      document.getElementById("mobile-menu").classList.toggle("hidden");
      document.getElementById("hamburger").classList.toggle("hidden");
      document.getElementById("close").classList.toggle("hidden");
    });
  </script>
</body>
</html>
