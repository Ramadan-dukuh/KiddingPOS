<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login - POS Warung UMKM</title>
  <link rel="shortcut icon" href="../img/Logo-01.png" type="image/x-icon">
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Unicons CDN -->
  <link
    rel="stylesheet"
    href="https://unicons.iconscout.com/release/v4.0.8/css/line.css"
  />
  <style>
    .bg-primary { background-color: #212A3D; }
    .text-primary { color: #212A3D; }
    .border-primary { border-color: #212A3D; }
    .hover\:bg-primary:hover { background-color: #1a2332; }
    .hover\:text-primary:hover { color: #212A3D; }
    .focus\:ring-primary:focus { 
      --tw-ring-color: #212A3D; 
      --tw-ring-opacity: 0.5;
    }
    .focus\:border-primary:focus { border-color: #212A3D; }
    .bg-primary-light { background-color: rgba(33, 42, 61, 0.05); }
    .gradient-bg {
      background: linear-gradient(135deg, #212A3D 0%, #1a2332 100%);
    }
  </style>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center font-sans">

  <!-- Background Pattern -->
  <div class="absolute inset-0 bg-gray-50">
    <div class="absolute inset-0 opacity-5">
      <div class="h-screen w-full" style="background-image: url('data:image/svg+xml,%3Csvg width=%2260%22 height=%2260%22 viewBox=%220 0 60 60%22 xmlns=%22http://www.w3.org/2000/svg%22%3E%3Cg fill=%22none%22 fill-rule=%22evenodd%22%3E%3Cg fill=%22%23212A3D%22 fill-opacity=%220.1%22%3E%3Ccircle cx=%2230%22 cy=%2230%22 r=%221.5%22/%3E%3C/g%3E%3C/g%3E%3C/svg%3E'); background-size: 60px 60px;"></div>
    </div>
  </div>

  <!-- Login Container -->
  <div class="relative z-10 w-full max-w-md">        
   

    <!-- Login Card -->
    <div class="bg-white rounded-2xl shadow-xl p-8 mx-2 mt-8">
      
      <!-- Header -->
      <div class="text-center mb-8">
         <div class="text-start ">
      <a href="landing.php" class="inline-flex items-center text-gray-600 hover:text-primary transition-colors">
        <i class="uil uil-arrow-left mr-2"></i>
        <span>Back</span>
      </a>
    </div>
        <div class="gradient-bg w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
          <i class="uil uil-user text-white text-2xl"></i>
        </div>
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Selamat Datang</h1>
        <p class="text-gray-600">Masuk ke akun POS Warung UMKM Anda</p>
      </div>

      <!-- Login Form -->
      <form id="loginForm" method="POST" action="../crud/crud-login.php" class="space-y-6">
        
        <!-- Email Field -->
        <div>
          <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
            <i class="uil uil-envelope mr-1"></i>
            Email
          </label>
          <input 
            type="email" 
            id="email" 
            name="email"
            required
            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-colors"
            placeholder="Masukkan email Anda"
          >
        </div>

        <!-- Password Field -->
        <div>
          <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
            <i class="uil uil-lock mr-1"></i>
            Password
          </label>
          <div class="relative">
            <input 
              type="password" 
              id="password" 
              name="password"
              required
              class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-colors"
              placeholder="Masukkan password Anda"
            >
            <button 
              type="button" 
              id="togglePassword"
              class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-primary transition-colors"
            >
              <i class="uil uil-eye" id="eyeIcon"></i>
            </button>
          </div>
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between">
          <label class="flex items-center">
            <input type="checkbox" class="rounded border-gray-300 text-primary focus:ring-primary">
            <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
          </label>
          <a href="#" class="text-sm text-primary hover:underline">Lupa password?</a>
        </div>

        <!-- Login Button -->
        <button 
          type="submit" 
          class="w-full gradient-bg text-white py-3 px-4 rounded-lg font-semibold hover:shadow-lg transform hover:scale-[1.02] transition-all duration-200"
        >
          <i class="uil uil-signin mr-2"></i>
          Masuk
        </button>

      </form>

      <!-- Divider -->
      <div class="flex items-center my-6">
        <div class="flex-1 border-t border-gray-300"></div>
        <span class="px-4 text-gray-500 text-sm">atau</span>
        <div class="flex-1 border-t border-gray-300"></div>
      </div>
      

      <!-- Register Link -->
      <div class="text-center mt-6">
        <p class="text-gray-600">
          Belum punya akun? 
          <a href="regis.php" class="text-primary font-semibold hover:underline">Daftar sekarang</a>
        </p>
      </div>

    </div>

    <!-- Footer -->
    <div class="text-center mt-8 text-gray-500 text-sm">
      <p>&copy; <span id="year"></span> Kidding POS. All rights reserved.</p>
    </div>

  </div>

  <script>
    // Update tahun otomatis
    document.getElementById('year').textContent = new Date().getFullYear();

    // Toggle password visibility
    document.getElementById('togglePassword').addEventListener('click', function() {
      const passwordInput = document.getElementById('password');
      const eyeIcon = document.getElementById('eyeIcon');
      
      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.className = 'uil uil-eye-slash';
      } else {
        passwordInput.type = 'password';
        eyeIcon.className = 'uil uil-eye';
      }
    });

    // Handle form submission
   document.getElementById('regisForm').addEventListener('submit', function(e) {
    const button = this.querySelector('button[type="submit"]');
    const originalText = button.innerHTML;
     button.innerHTML = '<i class="uil uil-spinner-alt animate-spin mr-2"></i>Memproses...';
    button.disabled = true;
  });  


    // Demo login
    document.getElementById('demoLogin').addEventListener('click', function() {
      document.getElementById('email').value = 'demo@warung.com';
      document.getElementById('password').value = 'demo123';
      
      const button = this;
      const originalText = button.innerHTML;
      
      button.innerHTML = '<i class="uil uil-spinner-alt animate-spin mr-2"></i>Loading Demo...';
      button.disabled = true;
      
      setTimeout(() => {
        alert('Demo login berhasil! Selamat datang di POS Warung UMKM.');
        button.innerHTML = originalText;
        button.disabled = false;
      }, 1500);
    });

    // Add input focus effects
    const inputs = document.querySelectorAll('input[type="email"], input[type="password"]');
    inputs.forEach(input => {
      input.addEventListener('focus', function() {
        this.parentElement.classList.add('ring-2', 'ring-primary', 'ring-opacity-20');
      });
    
      input.addEventListener('blur', function() {
        this.parentElement.classList.remove('ring-2', 'ring-primary', 'ring-opacity-20');
      });
    });
  </script>

</body>
</html>