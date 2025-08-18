@extends('layouts.superadmin')

@section('title', 'Tambah Makanan Baru')

@section('content')
<div class="min-h-screen bg-gray-50 py-6">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <nav class="flex items-center space-x-2 text-sm text-gray-600 mb-4">
                <a href="{{ route('superadmin.dashboard') }}" class="hover:text-gray-900">Dashboard</a>
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 111.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                <a href="{{ route('superadmin.foods.index') }}" class="hover:text-gray-900">Data Makanan</a>
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 111.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
                <span class="text-gray-900">Tambah Makanan</span>
            </nav>
        </div>

        <!-- Form Container dengan Layout 2 Kolom -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-8">Menambahkan Menu Makanan Baru</h2>

                <form action="{{ route('superadmin.foods.store') }}" method="POST">
                    @csrf

                    <!-- Layout 2 Kolom: Form Kiri, Preview Kanan -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                        <!-- Kolom Kiri - Form Input -->
                        <div class="lg:col-span-2 space-y-6">

                            <!-- Nama Makanan -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Makanan
                                </label>
                                <input type="text"
                                       id="name"
                                       name="name"
                                       value="{{ old('name') }}"
                                       class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('name') border-red-500 @enderror"
                                       required>
                                @error('name')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Energi -->
                            <div>
                                <label for="calories" class="block text-sm font-medium text-gray-700 mb-2">
                                    Energi
                                </label>
                                <input type="number"
                                       step="0.1"
                                       id="calories"
                                       name="calories"
                                       value="{{ old('calories') }}"
                                       class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('calories') border-red-500 @enderror"
                                       required>
                                @error('calories')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Protein -->
                            <div>
                                <label for="protein" class="block text-sm font-medium text-gray-700 mb-2">
                                    Protein
                                </label>
                                <input type="number"
                                       step="0.1"
                                       id="protein"
                                       name="protein"
                                       value="{{ old('protein') }}"
                                       class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('protein') border-red-500 @enderror"
                                       required>
                                @error('protein')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Karbohidrat -->
                            <div>
                                <label for="carbohydrates" class="block text-sm font-medium text-gray-700 mb-2">
                                    Karbohidrat
                                </label>
                                <input type="number"
                                       step="0.1"
                                       id="carbohydrates"
                                       name="carbohydrates"
                                       value="{{ old('carbohydrates') }}"
                                       class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('carbohydrates') border-red-500 @enderror"
                                       required>
                                @error('carbohydrates')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Lemak -->
                            <div>
                                <label for="fat" class="block text-sm font-medium text-gray-700 mb-2">
                                    Lemak
                                </label>
                                <input type="number"
                                       step="0.1"
                                       id="fat"
                                       name="fat"
                                       value="{{ old('fat') }}"
                                       class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('fat') border-red-500 @enderror"
                                       required>
                                @error('fat')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Vitamin C -->
                            <div>
                                <label for="vitamin_c_mg" class="block text-sm font-medium text-gray-700 mb-2">
                                    Vitamin C
                                </label>
                                <input type="number"
                                       step="0.1"
                                       id="vitamin_c_mg"
                                       name="vitamin_c_mg"
                                       value="{{ old('vitamin_c_mg') }}"
                                       class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('vitamin_c_mg') border-red-500 @enderror"
                                       required>
                                @error('vitamin_c_mg')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Besi -->
                            <div>
                                <label for="besi_mg" class="block text-sm font-medium text-gray-700 mb-2">
                                    Besi
                                </label>
                                <input type="number"
                                       step="0.1"
                                       id="besi_mg"
                                       name="besi_mg"
                                       value="{{ old('besi_mg') }}"
                                       class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('besi_mg') border-red-500 @enderror"
                                       required>
                                @error('besi_mg')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Iodium -->
                            <div>
                                <label for="iodium_mg" class="block text-sm font-medium text-gray-700 mb-2">
                                    Iodium
                                </label>
                                <input type="number"
                                       step="0.1"
                                       id="iodium_mg"
                                       name="iodium_mg"
                                       value="{{ old('iodium_mg') }}"
                                       class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('iodium_mg') border-red-500 @enderror"
                                       required>
                                @error('iodium_mg')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Kolom Kanan - Preview Gambar -->
                        <div class="lg:col-span-1">
                            <div class="sticky top-8">
                                <label for="urlimage" class="block text-sm font-medium text-gray-700 mb-2">
                                    Gambar
                                </label>
                                <input type="url"
                                       id="urlimage"
                                       name="urlimage"
                                       value="{{ old('urlimage') }}"
                                       placeholder="URL..."
                                       class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('urlimage') border-red-500 @enderror"
                                       oninput="previewImage(this.value)"
                                       onpaste="setTimeout(() => previewImage(this.value), 100)">
                                @error('urlimage')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror

                                <!-- Preview Container -->
                                <div class="mt-4">
                                    <div id="image-preview-container" class="w-full h-64 border-2 border-dashed border-gray-300 rounded-lg flex items-center justify-center bg-gray-50">
                                        <!-- Default state -->
                                        <div id="default-preview" class="text-center text-gray-400">
                                            <svg class="w-16 h-16 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            <p class="text-sm">((preview gambar))</p>
                                        </div>

                                        <!-- Loading indicator -->
                                        <div id="loading-indicator" class="hidden text-center">
                                            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600 mx-auto mb-2"></div>
                                            <p class="text-sm text-gray-600">Loading...</p>
                                        </div>

                                        <!-- Image preview -->
                                        <img id="preview-img"
                                             src=""
                                             alt="Preview"
                                             class="hidden w-full h-full object-cover rounded-lg">

                                        <!-- Error message -->
                                        <div id="error-message" class="hidden text-center text-red-500">
                                            <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                            </svg>
                                            <p class="text-sm">Error loading image</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="mt-8 flex justify-end space-x-4">
                        <button type="button"
                                onclick="window.history.back()"
                                class="px-6 py-3 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors">
                            Simpan
                        </button>
                        <button type="submit"
                                class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            Publish
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript untuk preview gambar -->
<script>
let currentTimeout = null;

function previewImage(url) {
    // Clear previous timeout
    if (currentTimeout) {
        clearTimeout(currentTimeout);
    }

    const defaultPreview = document.getElementById('default-preview');
    const loadingIndicator = document.getElementById('loading-indicator');
    const previewImg = document.getElementById('preview-img');
    const errorMessage = document.getElementById('error-message');

    // Reset semua state
    showDefault();

    if (!url || url.trim() === '') {
        return;
    }

    // Validasi URL format
    if (!isValidImageUrl(url)) {
        showError('URL tidak valid');
        return;
    }

    // Show loading
    showLoading();

    // Delay untuk menghindari terlalu banyak request saat mengetik
    currentTimeout = setTimeout(() => {
        loadImage(url);
    }, 500);
}

function loadImage(url) {
    const previewImg = document.getElementById('preview-img');

    // Create new image object to test loading
    const testImg = new Image();

    testImg.onload = function() {
        previewImg.src = url;
        showImage();
    };

    testImg.onerror = function() {
        showError('Gagal memuat gambar');
    };

    // Set timeout untuk loading yang terlalu lama
    setTimeout(() => {
        const loadingIndicator = document.getElementById('loading-indicator');
        if (loadingIndicator && !loadingIndicator.classList.contains('hidden')) {
            showError('Timeout: Gambar membutuhkan waktu terlalu lama');
        }
    }, 10000);

    testImg.src = url;
}

function showDefault() {
    document.getElementById('default-preview').classList.remove('hidden');
    document.getElementById('loading-indicator').classList.add('hidden');
    document.getElementById('preview-img').classList.add('hidden');
    document.getElementById('error-message').classList.add('hidden');
}

function showLoading() {
    document.getElementById('default-preview').classList.add('hidden');
    document.getElementById('loading-indicator').classList.remove('hidden');
    document.getElementById('preview-img').classList.add('hidden');
    document.getElementById('error-message').classList.add('hidden');
}

function showImage() {
    document.getElementById('default-preview').classList.add('hidden');
    document.getElementById('loading-indicator').classList.add('hidden');
    document.getElementById('preview-img').classList.remove('hidden');
    document.getElementById('error-message').classList.add('hidden');
}

function showError(message) {
    document.getElementById('default-preview').classList.add('hidden');
    document.getElementById('loading-indicator').classList.add('hidden');
    document.getElementById('preview-img').classList.add('hidden');
    document.getElementById('error-message').classList.remove('hidden');
    document.getElementById('error-message').querySelector('p').textContent = message;
}

function isValidImageUrl(url) {
    try {
        const urlObj = new URL(url);
        const pathname = urlObj.pathname.toLowerCase();
        const validExtensions = ['.jpg', '.jpeg', '.png', '.gif', '.webp', '.svg', '.bmp'];

        // Check if URL has valid image extension or common image hosting domains
        const hasValidExtension = validExtensions.some(ext => pathname.endsWith(ext));
        const isImageHost = ['imgur.com', 'cloudinary.com', 'unsplash.com', 'pexels.com'].some(host =>
            urlObj.hostname.includes(host));

        return hasValidExtension || isImageHost || pathname.includes('image') || pathname.includes('photo');
    } catch {
        return false;
    }
}

// Auto-scroll to first error
document.addEventListener('DOMContentLoaded', function() {
    @if ($errors->any())
        const firstError = document.querySelector('.border-red-500');
        if (firstError) {
            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            firstError.focus();
        }
    @endif

    // Initialize preview if there's an old value
    const urlInput = document.getElementById('urlimage');
    if (urlInput && urlInput.value) {
        previewImage(urlInput.value);
    }
});
</script>
@endsection
