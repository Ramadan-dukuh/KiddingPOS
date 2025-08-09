<?php
require_once '../crud/crud-barang.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Stok</title>
    <link rel="shortcut icon" href="../img/Logo_Submark.png" type="image/x-icon">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Cropper.js for image cropping -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" rel="stylesheet">
    
    <style>
        .bg-primary { background-color: #212A3D; }
        .text-primary { color: #212A3D; }
        .border-primary { border-color: #212A3D; }
        .hover\:bg-primary:hover { background-color: #1a2332; }
        .hover\:text-primary:hover { color: #212A3D; }
        .focus\:ring-primary:focus { --tw-ring-color: #212A3D; }

        * { scroll-behavior: smooth; }
        
        /* Image preview and cropping styles */
        #imagePreviewContainer {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.8);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }
        
        #imagePreview {
            max-width: 80%;
            max-height: 80%;
        }
        
       /* Perbaikan CSS untuk modal kamera */
    #cameraModal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.8);
        z-index: 1000;
        align-items: center;
        justify-content: center;
    }
    
    #cameraModal .modal-content {
        background: white;
        border-radius: 0.5rem;
        width: 90%;
        max-width: 500px;
        padding: 1rem;
    }
    
    #video {
        width: 100%;
        background: black;
        border-radius: 0.25rem;
    }
    
    .camera-buttons {
        display: flex;
        gap: 1rem;
        margin-top: 1rem;
        justify-content: center;
    }
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
        <!-- Success/Error Messages -->
        <?php if (isset($success)): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline"><?php echo $success; ?></span>
            </div>
        <?php endif; ?>
        
        <?php if (isset($error)): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline"><?php echo $error; ?></span>
            </div>
        <?php endif; ?>

        <!-- Add/Edit Product Form -->
        <section class="bg-white p-6 rounded-lg shadow mb-6">
            <h2 class="text-lg font-semibold text-white bg-primary px-4 py-2 rounded-t-md mb-4">
                <?php echo isset($_GET['edit']) ? 'Edit Produk' : 'Tambah Produk Baru'; ?>
            </h2>

            <form method="POST" enctype="multipart/form-data">
                <?php if (isset($_GET['edit'])): ?>
                    <input type="hidden" name="edit" value="1">
                    <input type="hidden" name="kode" value="<?php echo $_GET['edit']; ?>">
                <?php endif; ?>
                
                <!-- Product Name -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Produk</label>
                    <input
                        type="text"
                        name="nama"
                        placeholder="Masukkan nama produk"
                        required
                        value="<?php echo isset($editProduct) ? $editProduct['namaBarang'] : ''; ?>"
                        class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary"
                    />
                </div>

                <!-- Product Price -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Harga Produk</label>
                    <input
                        type="number"
                        name="harga"
                        placeholder="Masukkan harga produk"
                        required
                        min="0"
                        value="<?php echo isset($editProduct) ? $editProduct['hargaBarang'] : ''; ?>"
                        class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary"
                    />
                </div>

                <!-- Stock -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Stok</label>
                    <input
                        type="number"
                        name="stok"
                        placeholder="Masukkan jumlah stok"
                        required
                        min="0"
                        value="<?php echo isset($editProduct) ? $editProduct['stok'] : ''; ?>"
                        class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-primary"
                    />
                </div>

                <!-- Category Dropdown -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                    <select 
                        name="kategori"
                        required
                        class="w-full border border-gray-300 rounded px-4 py-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-primary">
                        <option disabled <?php echo !isset($editProduct) ? 'selected' : ''; ?> value="">-- Pilih Kategori --</option>
                        <?php 
                        $categories = getAllKategori();
                        mysqli_data_seek($categories, 0); // Reset pointer
                        while ($kategori = mysqli_fetch_assoc($categories)): ?>
                            <option 
                                value="<?= $kategori['idKategori']; ?>"
                                <?php echo (isset($editProduct) && $editProduct['idKategori'] == $kategori['idKategori']) ? 'selected' : ''; ?>
                            >
                                <?= $kategori['namaKategori']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <!-- Image Upload -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Gambar Produk</label>
                    <div class="border border-dashed border-gray-400 rounded p-4 text-center text-gray-600 relative">
                        <?php if (isset($editProduct) && !empty($editProduct['gambar'])): ?>
                            <img id="imageThumbnail" class="mt-2 mx-auto max-h-40" src="<?php echo $editProduct['gambar']; ?>" alt="Current Image">
                        <?php else: ?>
                            <i class="fas fa-image text-3xl mb-2 text-primary"></i>
                            <p class="text-sm">Klik untuk upload gambar</p>
                            <p class="text-xs text-gray-400">Format: JPG, PNG, GIF (Max: 5MB)</p>
                            <img id="imageThumbnail" class="mt-2 mx-auto max-h-40 hidden" src="#" alt="Preview">
                        <?php endif; ?>
                        <input 
                            type="file" 
                            id="gambarInput"
                            name="gambar"
                            accept="image/*"
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                            onchange="previewImage(this)"
                        />
                    </div>
                </div>

                <!-- Camera Buttons -->
                <div class="flex gap-4 mb-6">
                    <button 
                        type="button" 
                        onclick="openCamera()"
                        class="flex-1 bg-gray-300 text-gray-800 py-2 rounded hover:bg-gray-400">
                        <i class="fas fa-camera mr-2"></i> Buka Kamera
                    </button>
                    <button 
                        type="button" 
                        id="cancelCameraBtn"
                        class="flex-1 bg-gray-300 text-gray-800 py-2 rounded hover:bg-gray-400 hidden">
                        <i class="fas fa-times mr-2"></i> Tutup Kamera
                    </button>
                </div>

                <div id="cameraModal">
                    <div class="modal-content">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold">Ambil Foto</h3>
                            <button onclick="closeCamera()" class="text-gray-500 hover:text-gray-700">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <video id="video" width="100%" autoplay playsinline></video>
                        <canvas id="canvas" class="hidden"></canvas>
                        <div class="camera-buttons">
                            <button 
                                onclick="capturePhoto()"
                                class="bg-primary text-white px-4 py-2 rounded hover:bg-gray-800">
                                <i class="fas fa-camera mr-2"></i> Ambil Foto
                            </button>
                            <button 
                                onclick="closeCamera()"
                                class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">
                                Batal
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Image Preview and Cropping Modal -->
                <div id="imagePreviewContainer" class="hidden">
                    <div class="bg-white rounded-lg p-4 max-w-4xl">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold">Edit Gambar</h3>
                            <button onclick="closePreview()" class="text-gray-500 hover:text-gray-700">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <div class="flex">
                            <div class="w-3/4">
                                <img id="imagePreview" src="#" alt="Preview">
                            </div>
                            <div class="w-1/4 pl-4">
                                <div class="mb-4">
                                    <h4 class="font-medium mb-2">Preview</h4>
                                    <div id="croppedPreview" class="border border-gray-300 w-full h-32 overflow-hidden"></div>
                                </div>
                                <button 
                                    onclick="saveCroppedImage()"
                                    class="w-full bg-primary text-white px-4 py-2 rounded hover:bg-gray-800 mb-2">
                                    Simpan
                                </button>
                                <button 
                                    onclick="closePreview()"
                                    class="w-full bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">
                                    Batal
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Save/Cancel Buttons -->
                <div class="flex gap-4">
                    <button type="submit" class="bg-primary text-white px-4 py-2 rounded hover:bg-gray-800">
                        <i class="fas fa-save mr-2"></i> <?php echo isset($_GET['edit']) ? 'Update Produk' : 'Simpan Produk'; ?>
                    </button>
                    <button type="reset" onclick="resetForm()" class="bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">
                        <i class="fas fa-ban mr-2"></i> Batal
                    </button>
                    <?php if (isset($_GET['edit'])): ?>
                        <a href="stok.php" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
                            <i class="fas fa-times mr-2"></i> Batalkan Edit
                        </a>
                    <?php endif; ?>
                </div>
            </form>
        </section>

        <!-- Product List -->
        <section class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-lg font-semibold text-white bg-primary px-4 py-2 rounded-t-md mb-4">
                Daftar Produk (<?php echo $productCount; ?> produk)
            </h2>

            <?php if ($productCount > 0): ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Gambar</th>
                                <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kode</th>
                                <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama</th>
                                <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Harga</th>
                                <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Stok</th>
                                <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kategori</th>
                                <th class="py-2 px-4 border-b border-gray-200 bg-gray-50 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            mysqli_data_seek($products, 0); // Reset pointer
                            while ($row = mysqli_fetch_assoc($products)): ?>
                                <tr>
                                    <td class="py-2 px-4 border-b border-gray-200">
                                        <?php if (!empty($row['gambar'])): ?>
                                            <img src="<?php echo $row['gambar']; ?>" alt="Product Image" class="h-16 w-16 object-cover rounded">
                                        <?php else: ?>
                                            <div class="h-16 w-16 bg-gray-200 rounded flex items-center justify-center">
                                                <i class="fas fa-box-open text-gray-400"></i>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td class="py-2 px-4 border-b border-gray-200"><?php echo $row['kodeBarang']; ?></td>
                                    <td class="py-2 px-4 border-b border-gray-200"><?php echo $row['namaBarang']; ?></td>
                                    <td class="py-2 px-4 border-b border-gray-200">Rp <?php echo number_format($row['hargaBarang'], 0, ',', '.'); ?></td>
                                    <td class="py-2 px-4 border-b border-gray-200"><?php echo $row['stok']; ?></td>
                                    <td class="py-2 px-4 border-b border-gray-200"><?php echo $row['namaKategori']; ?></td>
                                    <td class="py-2 px-4 border-b border-gray-200">
                                        <a 
                                            href="stok.php?edit=<?= $row['kodeBarang']; ?>" 
                                            class="text-blue-500 hover:text-blue-700 mr-2"
                                        >
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button 
                                            onclick="confirmDelete('<?= $row['kodeBarang']; ?>', '<?= $row['namaBarang']; ?>')" 
                                            class="text-red-500 hover:text-red-700"
                                        >
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-gray-400 text-center py-10">
                    <i class="fas fa-box-open text-4xl mb-2"></i>
                    <p>Tidak ada produk yang ditampilkan</p>
                </div>
            <?php endif; ?>
        </section>
    </main>

    <!-- JavaScript Libraries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
    
    <script>
        // Profile dropdown and mobile menu toggle
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

        // Image handling variables
        let cropper;
        let currentImageSource;
        let videoStream;

        // Preview uploaded image
        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    // Show thumbnail
                    const thumbnail = document.getElementById('imageThumbnail');
                    thumbnail.src = e.target.result;
                    thumbnail.classList.remove('hidden');
                    
                    // Open the image in the cropping modal
                    openImageEditor(e.target.result);
                }
                
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Open image editor/cropper
        function openImageEditor(imageSrc) {
            currentImageSource = imageSrc;
            const preview = document.getElementById('imagePreview');
            preview.src = imageSrc;
            
            // Show the modal
            document.getElementById('imagePreviewContainer').style.display = 'flex';
            
            // Initialize cropper
            setTimeout(() => {
                if (cropper) {
                    cropper.destroy();
                }
                
                preview.style.display = 'block';
                cropper = new Cropper(preview, {
                    aspectRatio: 1,
                    viewMode: 1,
                    autoCropArea: 0.8,
                    responsive: true,
                    preview: document.getElementById('croppedPreview')
                });
            }, 100);
        }

        // Save cropped image
        function saveCroppedImage() {
            if (cropper) {
                // Get the cropped canvas
                const canvas = cropper.getCroppedCanvas({
                    width: 800,
                    height: 800,
                    minWidth: 256,
                    minHeight: 256,
                    maxWidth: 4096,
                    maxHeight: 4096,
                    fillColor: '#fff',
                    imageSmoothingEnabled: true,
                    imageSmoothingQuality: 'high',
                });
                
                // Convert canvas to blob
                canvas.toBlob((blob) => {
                    // Create a new File object
                    const file = new File([blob], 'cropped_image.jpg', { type: 'image/jpeg' });
                    
                    // Create a data transfer object to simulate file input
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    
                    // Update the file input
                    const fileInput = document.getElementById('gambarInput');
                    fileInput.files = dataTransfer.files;
                    
                    // Update the thumbnail
                    const thumbnail = document.getElementById('imageThumbnail');
                    thumbnail.src = URL.createObjectURL(blob);
                    thumbnail.classList.remove('hidden');
                    
                    // Close the editor
                    closePreview();
                }, 'image/jpeg', 0.9);
            }
        }

        // Close image preview
        function closePreview() {
            document.getElementById('imagePreviewContainer').style.display = 'none';
            if (cropper) {
                cropper.destroy();
                cropper = null;
            }
        }

        // Camera functions
        function openCamera() {
            const video = document.getElementById('video');
            const cameraModal = document.getElementById('cameraModal');
            
            cameraModal.style.display = 'flex';
            document.getElementById('cancelCameraBtn').classList.remove('hidden');
            
            navigator.mediaDevices.getUserMedia({ video: true })
                .then(function(stream) {
                    videoStream = stream;
                    video.srcObject = stream;
                })
                .catch(function(err) {
                    console.error("Error accessing camera: ", err);
                    alert("Tidak dapat mengakses kamera. Pastikan Anda memberikan izin.");
                });
        }

        function closeCamera() {
            const video = document.getElementById('video');
            
            if (videoStream) {
                videoStream.getTracks().forEach(track => track.stop());
                videoStream = null;
            }
            
            video.srcObject = null;
            document.getElementById('cameraModal').style.display = 'none';
            document.getElementById('cancelCameraBtn').classList.add('hidden');
        }

        function capturePhoto() {
            const video = document.getElementById('video');
            const canvas = document.getElementById('canvas');
            const context = canvas.getContext('2d');
            
            // Set canvas dimensions to match video
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            
            // Draw video frame to canvas
            context.drawImage(video, 0, 0, canvas.width, canvas.height);
            
            // Convert canvas to data URL and open in editor
            const imageDataUrl = canvas.toDataURL('image/jpeg');
            openImageEditor(imageDataUrl);
            
            // Close camera
            closeCamera();
        }

        // Reset form
        function resetForm() {
            document.getElementById('imageThumbnail').src = '#';
            document.getElementById('imageThumbnail').classList.add('hidden');
            if (cropper) {
                cropper.destroy();
                cropper = null;
            }
        }

        // Close modals when clicking outside
        window.addEventListener('click', function(event) {
            const imagePreviewContainer = document.getElementById('imagePreviewContainer');
            const cameraModal = document.getElementById('cameraModal');
            
            if (event.target === imagePreviewContainer) {
                closePreview();
            }
            
            if (event.target === cameraModal) {
                closeCamera();
            }
        });

        // Function to confirm product deletion
        function confirmDelete(kode, nama) {
            if (confirm(`Apakah Anda yakin ingin menghapus produk ${nama}?`)) {
                window.location.href = `stok.php?delete=${kode}`;
            }
        }

        // Scroll to form when editing
        <?php if (isset($_GET['edit'])): ?>
            window.addEventListener('load', function() {
                document.querySelector('form').scrollIntoView({ behavior: 'smooth' });
            });
        <?php endif; ?>
    </script>
</body>
</html>

