<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Stok</title>
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
              <a href="penjualan.php" class="text-primary hover:bg-gray-200 px-3 py-2 rounded-md text-sm font-medium">Penjualan</a>
              <a href="stok.php" class="bg-primary text-white px-3 py-2 rounded-md text-sm font-medium">Manajemen Stok</a>
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
      <a href="penjualan.php" class="block text-primary hover:bg-gray-200 px-3 py-2 rounded-md text-base font-medium">Penjualan</a>
      <a href="stok.php" class="block bg-primary text-white px-3 py-2 rounded-md text-base font-medium">Manajemen Stok</a>
      <a href="laporan.php" class="block text-primary hover:bg-gray-200 px-3 py-2 rounded-md text-base font-medium">Laporan</a>
      <a href="kategori.php" class="block text-primary hover:bg-gray-200 px-3 py-2 rounded-md text-base font-medium">Kategori</a>
    </div>
  </nav>
    <main class="px-4 py-6">
        <!-- Tambah Produk -->
<section class="bg-white p-6 rounded-lg shadow mb-6">
  <h2 class="text-lg font-semibold text-white bg-primary px-4 py-2 rounded-t-md mb-4">
    Tambah Produk Baru
  </h2>

  <form>
    <!-- Nama Produk -->
    <div class="mb-4">
      <label class="block text-sm font-medium text-gray-700 mb-1">Nama Produk</label>
      <input
        type="text"
        placeholder="Masukkan nama produk"
        class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary"
      />
    </div>

    <!-- Harga Produk -->
    <div class="mb-4">
      <label class="block text-sm font-medium text-gray-700 mb-1">Harga Produk</label>
      <input
        type="number"
        placeholder="Masukkan harga produk"
        class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary"
      />
    </div>

    <!-- Stok -->
    <div class="mb-4">
      <label class="block text-sm font-medium text-gray-700 mb-1">Stok</label>
      <input
        type="number"
        placeholder="Masukkan jumlah stok"
        class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary"
      />
    </div>

    <!-- Kategori -->
    <div class="mb-4">
      <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
      <select class="w-full border border-gray-300 rounded px-4 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-primary">
        <option disabled selected>-- Pilih Kategori --</option>
        <option>Makanan</option>
        <option>Minuman</option>
        <option>Snack</option>
      </select>
    </div>

    <!-- Upload Gambar -->
    <div class="mb-4">
      <label class="block text-sm font-medium text-gray-700 mb-1">Gambar Produk</label>
      <div class="border border-dashed border-gray-400 rounded p-4 text-center text-gray-600">
        <i class="fas fa-image text-3xl mb-2 text-primary"></i>
        <p class="text-sm">Klik untuk upload gambar</p>
        <p class="text-xs text-gray-400">Format: JPG, PNG, GIF (Max: 5MB)</p>
        <input type="file" class="hidden" />
      </div>
    </div>

    <!-- Tombol Kamera -->
    <div class="flex gap-4 mb-6">
      <button type="button" class="flex-1 bg-gray-300 text-gray-800 py-2 rounded hover:bg-gray-400">
        <i class="fas fa-camera mr-2"></i> Buka Kamera
      </button>
      <button type="button" class="flex-1 bg-gray-300 text-gray-800 py-2 rounded hover:bg-gray-400">
        <i class="fas fa-times mr-2"></i> Tutup Kamera
      </button>
    </div>

    <!-- Tombol Simpan & Batal -->
    <div class="flex gap-4">
      <button type="submit" class="bg-primary text-white px-4 py-2 rounded hover:bg-gray-800">
        <i class="fas fa-save mr-2"></i> Simpan Produk
      </button>
      <button type="reset" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">
        <i class="fas fa-ban mr-2"></i> Batal
      </button>
    </div>
  </form>
</section>


<!-- Daftar Produk -->
<section class="bg-white p-6 rounded-lg shadow">
  <h2 class="text-lg font-semibold text-white bg-primary px-4 py-2 rounded-t-md mb-4">
    Daftar Produk (0 produk)
  </h2>

  <div class="text-gray-400 text-center py-10">
    <i class="fas fa-box-open text-4xl mb-2"></i>
    <p>Tidak ada produk yang ditampilkan</p>
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
  </script>
</body>
</html>