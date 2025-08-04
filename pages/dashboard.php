<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - POS Warung UMKM</title>
    <link rel="shortcut icon" href="../img/Logo-01.png" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Unicons CDN -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css" />
    <style>
        .bg-primary { background-color: #212A3D; }
        .text-primary { color: #212A3D; }
        .border-primary { border-color: #212A3D; }
        .hover\:bg-primary:hover { background-color: #1a2332; }
        .hover\:text-primary:hover { color: #212A3D; }
        .bg-primary-light { background-color: rgba(33, 42, 61, 0.1); }
        .gradient-bg { background: linear-gradient(135deg, #212A3D 0%, #1a2332 100%); }
        .sidebar-transition { transition: transform 0.3s ease-in-out; }
        .admin-only { display: none; }
        .user-only { display: none; }
        .active-menu { background-color: #212A3D; color: white; }
    </style>
</head>
<body class="bg-gray-50 font-sans">

    <!-- Role Selector (Demo Purpose) -->
    <div class="fixed top-4 right-4 z-50 bg-white p-3 rounded-lg shadow-lg">
        <label class="block text-sm font-medium mb-2">Mode Demo:</label>
        <select id="roleSelector" class="border border-gray-300 rounded px-3 py-1 text-sm">
            <option value="admin">Admin</option>
            <option value="user">User (Kasir)</option>
        </select>
    </div>

    <!-- Sidebar -->
    <div id="sidebar" class="fixed left-0 top-0 h-full w-64 bg-white shadow-lg sidebar-transition z-40">
        <div class="p-6 border-b">
            <h1 class="text-xl font-bold text-primary">KIDDING POS</h1>
            <p id="userRole" class="text-sm text-gray-600 mt-1">Admin Dashboard</p>
        </div>
        
        <nav class="p-4">
            <ul class="space-y-2">
                <!-- Dashboard (Both) -->
                <li>
                    <a href="#" class="flex items-center p-3 rounded-lg hover:bg-primary-light text-gray-700 hover:text-primary menu-item active-menu" data-section="dashboard">
                        <i class="uil uil-apps mr-3"></i>
                        Dashboard
                    </a>
                </li>
                
                <!-- Transaksi/Kasir (Both) -->
                <li>
                    <a href="#" class="flex items-center p-3 rounded-lg hover:bg-primary-light text-gray-700 hover:text-primary menu-item" data-section="kasir">
                        <i class="uil uil-shopping-cart mr-3"></i>
                        Kasir
                    </a>
                </li>
                
                <!-- Produk (Both - tapi User hanya lihat) -->
                <li>
                    <a href="#" class="flex items-center p-3 rounded-lg hover:bg-primary-light text-gray-700 hover:text-primary menu-item" data-section="produk">
                        <i class="uil uil-box mr-3"></i>
                        Produk
                    </a>
                </li>
                
                <!-- Laporan (Admin Only) -->
                <li class="admin-only">
                    <a href="#" class="flex items-center p-3 rounded-lg hover:bg-primary-light text-gray-700 hover:text-primary menu-item" data-section="laporan">
                        <i class="uil uil-chart-line mr-3"></i>
                        Laporan
                    </a>
                </li>
                
                <!-- Manajemen User (Admin Only) -->
                <li class="admin-only">
                    <a href="#" class="flex items-center p-3 rounded-lg hover:bg-primary-light text-gray-700 hover:text-primary menu-item" data-section="users">
                        <i class="uil uil-users-alt mr-3"></i>
                        Manajemen User
                    </a>
                </li>
                
                <!-- Pengaturan (Admin Only) -->
                <li class="admin-only">
                    <a href="#" class="flex items-center p-3 rounded-lg hover:bg-primary-light text-gray-700 hover:text-primary menu-item" data-section="settings">
                        <i class="uil uil-setting mr-3"></i>
                        Pengaturan
                    </a>
                </li>
                
                <!-- Riwayat Transaksi (User - hanya transaksi sendiri) -->
                <li class="user-only">
                    <a href="#" class="flex items-center p-3 rounded-lg hover:bg-primary-light text-gray-700 hover:text-primary menu-item" data-section="riwayat">
                        <i class="uil uil-history mr-3"></i>
                        Riwayat Saya
                    </a>
                </li>
            </ul>
        </nav>
        
        <!-- Logout -->
        <div class="absolute bottom-0 w-full p-4 border-t">
            <button id="logoutBtn" class="flex items-center w-full p-3 rounded-lg hover:bg-red-50 text-red-600 hover:text-red-700">
                <i class="uil uil-signout mr-3"></i>
                Logout
            </button>
        </div>
    </div>

    <!-- Mobile Menu Toggle -->
    <button id="menuToggle" class="fixed top-4 left-4 z-50 md:hidden bg-primary text-white p-2 rounded-lg">
        <i class="uil uil-bars"></i>
    </button>

    <!-- Main Content -->
    <div class="ml-64 min-h-screen">
        <!-- Header -->
        <header class="bg-white shadow-sm p-6 border-b">
            <div class="flex justify-between items-center">
                <div>
                    <h2 id="pageTitle" class="text-2xl font-bold text-gray-800">Dashboard</h2>
                    <p id="pageSubtitle" class="text-gray-600">Selamat datang di POS Warung UMKM</p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="text-right">
                        <p class="font-semibold text-gray-800" id="userName">Admin User</p>
                        <p class="text-sm text-gray-600" id="currentDate">-</p>
                    </div>
                    <div class="w-10 h-10 bg-primary rounded-full flex items-center justify-center">
                        <i class="uil uil-user text-white"></i>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content Area -->
        <main class="p-6">
            
            <!-- Dashboard Section -->
            <div id="dashboard-section" class="content-section">
                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white p-6 rounded-lg shadow">
                        <div class="flex items-center">
                            <div class="bg-blue-100 p-3 rounded-full">
                                <i class="uil uil-shopping-cart text-blue-600 text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm text-gray-600">Transaksi Hari Ini</p>
                                <p class="text-2xl font-bold text-gray-800" id="todayTransactions">23</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white p-6 rounded-lg shadow">
                        <div class="flex items-center">
                            <div class="bg-green-100 p-3 rounded-full">
                                <i class="uil uil-money-bill text-green-600 text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm text-gray-600">Pendapatan Hari Ini</p>
                                <p class="text-2xl font-bold text-gray-800">Rp 1.250.000</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white p-6 rounded-lg shadow admin-only">
                        <div class="flex items-center">
                            <div class="bg-purple-100 p-3 rounded-full">
                                <i class="uil uil-box text-purple-600 text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm text-gray-600">Total Produk</p>
                                <p class="text-2xl font-bold text-gray-800">156</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white p-6 rounded-lg shadow admin-only">
                        <div class="flex items-center">
                            <div class="bg-orange-100 p-3 rounded-full">
                                <i class="uil uil-users-alt text-orange-600 text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm text-gray-600">Total User</p>
                                <p class="text-2xl font-bold text-gray-800">5</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Transactions -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="bg-white p-6 rounded-lg shadow">
                        <h3 class="text-lg font-semibold mb-4">Transaksi Terbaru</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded">
                                <div>
                                    <p class="font-semibold">#TRX001</p>
                                    <p class="text-sm text-gray-600">Budi - 10:30</p>
                                </div>
                                <p class="font-semibold text-green-600">Rp 75.000</p>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded">
                                <div>
                                    <p class="font-semibold">#TRX002</p>
                                    <p class="text-sm text-gray-600">Siti - 11:15</p>
                                </div>
                                <p class="font-semibold text-green-600">Rp 125.000</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white p-6 rounded-lg shadow admin-only">
                        <h3 class="text-lg font-semibold mb-4">Stok Menipis</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center p-3 bg-red-50 rounded">
                                <div>
                                    <p class="font-semibold">Beras Premium</p>
                                    <p class="text-sm text-red-600">Stok: 5 kg</p>
                                </div>
                                <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs">Menipis</span>
                            </div>
                            <div class="flex justify-between items-center p-3 bg-yellow-50 rounded">
                                <div>
                                    <p class="font-semibold">Minyak Goreng</p>
                                    <p class="text-sm text-yellow-600">Stok: 8 botol</p>
                                </div>
                                <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs">Perhatian</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kasir Section -->
            <div id="kasir-section" class="content-section hidden">
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold mb-4">Point of Sale (Kasir)</h3>
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Product List -->
                        <div class="lg:col-span-2">
                            <div class="mb-4">
                                <input type="text" placeholder="Cari produk..." class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
                            </div>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 max-h-96 overflow-y-auto">
                                <div class="border rounded-lg p-4 cursor-pointer hover:bg-primary-light">
                                    <img src="https://via.placeholder.com/100x80/212A3D/white?text=Beras" alt="Beras" class="w-full h-20 object-cover rounded mb-2">
                                    <p class="font-semibold">Beras Premium</p>
                                    <p class="text-sm text-gray-600">Rp 15.000/kg</p>
                                </div>
                                <div class="border rounded-lg p-4 cursor-pointer hover:bg-primary-light">
                                    <img src="https://via.placeholder.com/100x80/212A3D/white?text=Minyak" alt="Minyak" class="w-full h-20 object-cover rounded mb-2">
                                    <p class="font-semibold">Minyak Goreng</p>
                                    <p class="text-sm text-gray-600">Rp 18.000/botol</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Cart -->
                        <div class="border-l pl-6">
                            <h4 class="font-semibold mb-4">Keranjang</h4>
                            <div class="space-y-3 mb-4">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="font-semibold">Beras Premium</p>
                                        <p class="text-sm text-gray-600">2 kg × Rp 15.000</p>
                                    </div>
                                    <p class="font-semibold">Rp 30.000</p>
                                </div>
                            </div>
                            <div class="border-t pt-4">
                                <div class="flex justify-between items-center mb-4">
                                    <p class="font-semibold">Total:</p>
                                    <p class="text-xl font-bold text-primary">Rp 30.000</p>
                                </div>
                                <button class="w-full bg-primary text-white py-3 rounded-lg font-semibold hover:bg-primary">
                                    Bayar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Produk Section -->
            <div id="produk-section" class="content-section hidden">
                <div class="bg-white rounded-lg shadow">
                    <div class="p-6 border-b flex justify-between items-center">
                        <h3 class="text-lg font-semibold">Daftar Produk</h3>
                        <button id="addProductBtn" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary admin-only">
                            <i class="uil uil-plus mr-2"></i>Tambah Produk
                        </button>
                    </div>
                    <div class="p-6">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b">
                                    <th class="text-left p-3">Nama Produk</th>
                                    <th class="text-left p-3">Kategori</th>
                                    <th class="text-left p-3">Harga</th>
                                    <th class="text-left p-3">Stok</th>
                                    <th class="text-left p-3 admin-only">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b">
                                    <td class="p-3">Beras Premium</td>
                                    <td class="p-3">Sembako</td>
                                    <td class="p-3">Rp 15.000</td>
                                    <td class="p-3">25 kg</td>
                                    <td class="p-3 admin-only">
                                        <button class="text-blue-600 hover:text-blue-800 mr-2">Edit</button>
                                        <button class="text-red-600 hover:text-red-800">Hapus</button>
                                    </td>
                                </tr>
                                <tr class="border-b">
                                    <td class="p-3">Minyak Goreng</td>
                                    <td class="p-3">Sembako</td>
                                    <td class="p-3">Rp 18.000</td>
                                    <td class="p-3">8 botol</td>
                                    <td class="p-3 admin-only">
                                        <button class="text-blue-600 hover:text-blue-800 mr-2">Edit</button>
                                        <button class="text-red-600 hover:text-red-800">Hapus</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Admin Only Sections -->
            <div id="laporan-section" class="content-section hidden admin-only">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="bg-white p-6 rounded-lg shadow">
                        <h3 class="text-lg font-semibold mb-4">Laporan Penjualan</h3>
                        <p class="text-gray-600">Grafik dan analisis penjualan akan ditampilkan di sini.</p>
                    </div>
                    <div class="bg-white p-6 rounded-lg shadow">
                        <h3 class="text-lg font-semibold mb-4">Laporan Keuangan</h3>
                        <p class="text-gray-600">Detail pendapatan dan pengeluaran.</p>
                    </div>
                </div>
            </div>

            <div id="users-section" class="content-section hidden admin-only">
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold mb-4">Manajemen User</h3>
                    <button class="bg-primary text-white px-4 py-2 rounded-lg mb-4">Tambah User</button>
                    <p class="text-gray-600">Daftar dan pengaturan user akan ditampilkan di sini.</p>
                </div>
            </div>

            <div id="settings-section" class="content-section hidden admin-only">
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold mb-4">Pengaturan Sistem</h3>
                    <p class="text-gray-600">Konfigurasi sistem dan pengaturan warung.</p>
                </div>
            </div>

            <!-- User Only Section -->
            <div id="riwayat-section" class="content-section hidden user-only">
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold mb-4">Riwayat Transaksi Saya</h3>
                    <p class="text-gray-600">Hanya menampilkan transaksi yang dilakukan oleh user ini.</p>
                </div>
            </div>

        </main>
    </div>

    <script>
        // Set current date
        document.getElementById('currentDate').textContent = new Date().toLocaleDateString('id-ID', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });

        // Role management
        const roleSelector = document.getElementById('roleSelector');
        const userRole = document.getElementById('userRole');
        const userName = document.getElementById('userName');

        function updateInterface(role) {
            const adminElements = document.querySelectorAll('.admin-only');
            const userElements = document.querySelectorAll('.user-only');
            
            if (role === 'admin') {
                adminElements.forEach(el => el.style.display = 'block');
                userElements.forEach(el => el.style.display = 'none');
                userRole.textContent = 'Admin Dashboard';
                userName.textContent = 'Admin User';
            } else {
                adminElements.forEach(el => el.style.display = 'none');
                userElements.forEach(el => el.style.display = 'block');
                userRole.textContent = 'Kasir Dashboard';
                userName.textContent = 'Kasir User';
            }
        }

        roleSelector.addEventListener('change', (e) => {
            updateInterface(e.target.value);
        });

        // Initialize with admin role
        updateInterface('admin');

        // Menu navigation
        const menuItems = document.querySelectorAll('.menu-item');
        const contentSections = document.querySelectorAll('.content-section');
        const pageTitle = document.getElementById('pageTitle');
        const pageSubtitle = document.getElementById('pageSubtitle');

        menuItems.forEach(item => {
            item.addEventListener('click', (e) => {
                e.preventDefault();
                
                // Remove active class from all items
                menuItems.forEach(mi => mi.classList.remove('active-menu'));
                
                // Add active class to clicked item
                item.classList.add('active-menu');
                
                // Hide all sections
                contentSections.forEach(section => section.classList.add('hidden'));
                
                // Show selected section
                const sectionName = item.dataset.section;
                const targetSection = document.getElementById(sectionName + '-section');
                if (targetSection) {
                    targetSection.classList.remove('hidden');
                }
                
                // Update page title
                const menuText = item.textContent.trim();
                pageTitle.textContent = menuText;
                
                // Update subtitle based on section
                const subtitles = {
                    'dashboard': 'Ringkasan aktivitas dan statistik',
                    'kasir': 'Transaksi penjualan',
                    'produk': 'Manajemen produk dan stok',
                    'laporan': 'Analisis dan laporan',
                    'users': 'Kelola pengguna sistem',
                    'settings': 'Konfigurasi sistem',
                    'riwayat': 'Riwayat transaksi Anda'
                };
                
                pageSubtitle.textContent = subtitles[sectionName] || '';
            });
        });

        // Mobile menu toggle
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.getElementById('sidebar');

        menuToggle.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
        });

        // Logout
        document.getElementById('logoutBtn').addEventListener('click', () => {
            if (confirm('Apakah Anda yakin ingin logout?')) {
                alert('Logout berhasil!');
                // window.location.href = 'login.html';
            }
        });

        // Demo transaction counter
        let transactionCount = 23;
        setInterval(() => {
            if (Math.random() > 0.7) {
                transactionCount++;
                document.getElementById('todayTransactions').textContent = transactionCount;
            }
        }, 30000);
    </script>

</body>
</html>