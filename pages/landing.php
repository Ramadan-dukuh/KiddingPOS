<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>POS Warung UMKM - Kidding</title>
  <link rel="shortcut icon" href="../img/Logo_Submark.png" type="image/x-icon">
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Unicons CDN -->
  <link
    rel="stylesheet"
    href="https://unicons.iconscout.com/release/v4.0.8/css/line.css"
  />
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
<body class="bg-gray-50 text-gray-800 font-sans">

  <!-- Navbar -->
  <nav class="bg-white shadow sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
      <a href="#" class="w-32"><img src="../img/Logo_Submark White.png" alt="Logo"></a>
      <ul class="hidden md:flex gap-6 text-gray-700 font-medium">
        <li><a href="#fitur" class="hover:text-primary">Fitur</a></li>
        <li><a href="#chat-ai" class="hover:text-primary">Chat AI</a></li>
        <li><a href="#testimoni" class="hover:text-primary">Testimoni</a></li>
      </ul>
      <a href="login.php" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary transition text-sm">
        Login
      </a>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="bg-primary text-white">
    <div class="max-w-7xl mx-auto px-6 py-20 flex flex-col md:flex-row items-center justify-between">
      <div class="max-w-xl">
        <h1 class="text-4xl font-bold mb-4">POS Warung UMKM</h1>
        <p class="text-lg mb-6">Sistem kasir digital fleksibel dengan Chat AI yang memudahkan operasional harian warung Anda.</p>
        <a href="#chat-ai" class="inline-block bg-white text-primary font-semibold px-6 py-3 rounded-lg shadow hover:bg-gray-100 transition">Mulai Gratis</a>
      </div>
      <img src="../img/contoh.jpg" alt="POS Warung" class="rounded-lg shadow-lg mt-10 md:mt-0 w-full md:w-1/2">
    </div>
  </section>

  <!-- Fitur Utama -->
  <section id="fitur" class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-6">
      <h2 class="text-3xl font-bold text-center mb-12">Fitur Unggulan</h2>
      <div class="grid md:grid-cols-3 gap-10 text-center">
        <div>
          <i class="uil uil-box text-5xl text-primary mb-4"></i>
          <h3 class="text-xl font-semibold mb-2">Manajemen Barang</h3>
          <p>Kelola stok produk dengan cepat dan efisien.</p>
        </div>
        <div>
          <i class="uil uil-chart-line text-5xl text-primary mb-4"></i>
          <h3 class="text-xl font-semibold mb-2">Laporan Penjualan</h3>
          <p>Analisis performa penjualan Anda dengan laporan real-time.</p>
        </div>
        <div>
          <i class="uil uil-robot text-5xl text-primary mb-4"></i>
          <h3 class="text-xl font-semibold mb-2">Chat AI Asisten</h3>
          <p>Tanyakan apapun ke AI, mulai dari penggunaan fitur hingga strategi penjualan.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Chat AI Section -->
  <section id="chat-ai" class="py-16 bg-gray-100">
  <div class="max-w-4xl mx-auto px-6">
    <h2 class="text-3xl font-bold text-center mb-8">Bicara dengan Asisten AI</h2>
    <div class="bg-white p-6 rounded-xl shadow-md">
      <div id="chatbox" class="h-64 overflow-y-auto border border-gray-200 p-4 mb-4 rounded-lg"></div>
      <div class="flex items-center gap-4">
        <input id="user-input" type="text" class="flex-1 border border-gray-300 px-4 py-2 rounded-lg" placeholder="Tulis pertanyaan Anda...">
        <button id="send-btn" class="bg-primary text-white px-4 py-2 rounded-lg">Kirim</button>
      </div>
    </div>
  </div>
</section>
<script src="js/chat.js"></script>


  <!-- Testimoni -->
  <section id="testimoni" class="py-16 bg-white">
    <div class="max-w-5xl mx-auto px-6">
      <h2 class="text-3xl font-bold text-center mb-8">Apa Kata Mereka?</h2>
      <div class="grid md:grid-cols-2 gap-10">
        <div class="bg-gray-100 p-6 rounded-lg shadow">
          <p>"POS ini sangat membantu saya dalam mencatat penjualan dan mengelola stok barang warung saya!"</p>
          <p class="mt-4 font-semibold">– Bu Siti, Pemilik Warung Sembako</p>
        </div>
        <div class="bg-gray-100 p-6 rounded-lg shadow">
          <p>"Fitur AI-nya keren banget! Saya bisa tanya langsung tanpa ribet baca manual."</p>
          <p class="mt-4 font-semibold">– Pak Agus, UMKM Kopi</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="text-white text-center py-6" style="background-color: #1a2332;">
    <p>&copy; <span id="year"></span> Kidding POS. All rights reserved.</p>
  </footer>

  <script>
    // Update tahun otomatis
    document.getElementById('year').textContent = new Date().getFullYear();
  </script>

</body>
</html>