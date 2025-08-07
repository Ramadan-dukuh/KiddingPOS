<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kategori</title>
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
              <a href="laporan.php" class="text-primary hover:bg-gray-200 px-3 py-2 rounded-md text-sm font-medium">Laporan</a>
              <a href="kategori.php" class="bg-primary text-white px-3 py-2 rounded-md text-sm font-medium">Kategori</a>
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
      <a href="laporan.php" class="block text-primary hover:bg-gray-200 px-3 py-2 rounded-md text-base font-medium">Laporan</a>
      <a href="kategori.php" class="block bg-primary text-white px-3 py-2 rounded-md text-base font-medium">Kategori</a>
    </div>
  </nav>

  <!-- Main Content -->
  <main class="max-w-4xl mx-auto px-4 py-8 space-y-8">
    <!-- Tambah Kategori -->
    <section class="bg-white p-6 rounded-lg shadow">
      <h2 class="text-xl font-semibold text-primary mb-4">Tambah Kategori</h2>
      <form action="#" method="POST" class="space-y-4">
        <div>
          <label for="kategori" class="block mb-1 text-sm font-medium text-gray-700">Nama Kategori</label>
          <input type="text" id="kategori" name="kategori" class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary" placeholder="Contoh: Minuman">
        </div>        
        <button type="submit" class="bg-primary text-white px-4 py-2 rounded-md hover:bg-gray-800">Simpan</button>
      </form>
    </section>

    <!-- Daftar Kategori -->
    <section class="bg-white p-6 rounded-lg shadow">
      <h2 class="text-xl font-semibold text-primary mb-4">Daftar Kategori</h2>
      <div class="overflow-x-auto">
        <table class="min-w-full text-sm text-left">
          <thead class="bg-gray-100">
            <tr>
              <th class="px-4 py-2">#</th>
              <th class="px-4 py-2">Nama Kategori</th>              
              <th class="px-4 py-2">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr class="border-t">
              <td class="px-4 py-2">1</td>
              <td class="px-4 py-2">Minuman</td>              
              <td class="px-4 py-2 space-x-2">
                <button class="text-blue-600 hover:underline"><i class="fas fa-edit"></i></button>
                <button class="text-red-600 hover:underline"><i class="fas fa-trash"></i></button>
              </td>
            </tr>
            <!-- Tambahkan data dinamis di sini -->
          </tbody>
        </table>
      </div>
    </section>
  </main>

  <script>
    document.getElementById("mobile-menu-button").addEventListener("click", function () {
      document.getElementById("mobile-menu").classList.toggle("hidden");
      document.getElementById("hamburger").classList.toggle("hidden");
      document.getElementById("close").classList.toggle("hidden");
    });
  </script>
</body>
</html>