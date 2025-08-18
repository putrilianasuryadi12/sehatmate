@extends('layouts.superadmin')

@section('title', 'Tambah Makanan Baru')

@section('content')
<div class="min-h-screen bg-gray-50 py-6">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
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

            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Tambah Makanan Baru</h1>
                    <p class="mt-2 text-gray-600">Tambahkan data makanan dengan informasi gizi dasar</p>
                </div>
                <a href="{{ route('superadmin.foods.index') }}"
                   class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors duration-200 shadow-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>

        <!-- Form Container -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <form action="{{ route('superadmin.foods.store') }}" method="POST">
                @csrf

                <div class="p-8">
                    <!-- Informasi Dasar -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-6">Informasi Dasar</h3>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Nama Makanan -->
                            <div class="lg:col-span-2">
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Makanan <span class="text-red-500">*</span>
                                </label>
                                <input type="text"
                                       id="name"
                                       name="name"
                                       value="{{ old('name') }}"
                                       placeholder="Contoh: Nasi Putih"
                                       class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('name') border-red-500 @enderror"
                                       required>
                                @error('name')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- URL Gambar -->
                            <div class="lg:col-span-2">
                                <label for="urlimage" class="block text-sm font-medium text-gray-700 mb-2">
                                    URL Gambar
                                </label>
                                <input type="url"
                                       id="urlimage"
                                       name="urlimage"
                                       value="{{ old('urlimage') }}"
                                       placeholder="https://example.com/gambar.jpg"
                                       class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('urlimage') border-red-500 @enderror"
                                       onchange="previewImage(this.value)">
                                @error('urlimage')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror

                                <!-- Preview Gambar -->
                                <div id="image-preview" class="mt-4 hidden">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Preview Gambar:</label>
                                    <div class="border border-gray-300 rounded-lg p-4 bg-gray-50">
                                        <img id="preview-img" src="" alt="Preview" class="max-w-full h-48 object-cover rounded-lg">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Gizi -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-6">Informasi Gizi (per 100g)</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                            <!-- Energi -->
                            <div>
                                <label for="calories" class="block text-sm font-medium text-gray-700 mb-2">
                                    Energi (kkal) <span class="text-red-500">*</span>
                                </label>
                                <input type="number"
                                       step="0.1"
                                       id="calories"
                                       name="calories"
                                       value="{{ old('calories') }}"
                                       placeholder="0.0"
                                       class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('calories') border-red-500 @enderror"
                                       required>
                                @error('calories')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Protein -->
                            <div>
                                <label for="protein" class="block text-sm font-medium text-gray-700 mb-2">
                                    Protein (g) <span class="text-red-500">*</span>
                                </label>
                                <input type="number"
                                       step="0.1"
                                       id="protein"
                                       name="protein"
                                       value="{{ old('protein') }}"
                                       placeholder="0.0"
                                       class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('protein') border-red-500 @enderror"
                                       required>
                                @error('protein')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Karbohidrat -->
                            <div>
                                <label for="carbohydrates" class="block text-sm font-medium text-gray-700 mb-2">
                                    Karbohidrat (g) <span class="text-red-500">*</span>
                                </label>
                                <input type="number"
                                       step="0.1"
                                       id="carbohydrates"
                                       name="carbohydrates"
                                       value="{{ old('carbohydrates') }}"
                                       placeholder="0.0"
                                       class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('carbohydrates') border-red-500 @enderror"
                                       required>
                                @error('carbohydrates')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Lemak -->
                            <div>
                                <label for="fat" class="block text-sm font-medium text-gray-700 mb-2">
                                    Lemak (g) <span class="text-red-500">*</span>
                                </label>
                                <input type="number"
                                       step="0.1"
                                       id="fat"
                                       name="fat"
                                       value="{{ old('fat') }}"
                                       placeholder="0.0"
                                       class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('fat') border-red-500 @enderror"
                                       required>
                                @error('fat')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Vitamin C -->
                            <div>
                                <label for="vitamin_c_mg" class="block text-sm font-medium text-gray-700 mb-2">
                                    Vitamin C (mg) <span class="text-red-500">*</span>
                                </label>
                                <input type="number"
                                       step="0.1"
                                       id="vitamin_c_mg"
                                       name="vitamin_c_mg"
                                       value="{{ old('vitamin_c_mg') }}"
                                       placeholder="0.0"
                                       class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('vitamin_c_mg') border-red-500 @enderror"
                                       required>
                                @error('vitamin_c_mg')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Besi -->
                            <div>
                                <label for="besi_mg" class="block text-sm font-medium text-gray-700 mb-2">
                                    Besi (mg) <span class="text-red-500">*</span>
                                </label>
                                <input type="number"
                                       step="0.1"
                                       id="besi_mg"
                                       name="besi_mg"
                                       value="{{ old('besi_mg') }}"
                                       placeholder="0.0"
                                       class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('besi_mg') border-red-500 @enderror"
                                       required>
                                @error('besi_mg')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Iodium -->
                            <div>
                                <label for="iodium_mg" class="block text-sm font-medium text-gray-700 mb-2">
                                    Iodium (mg) <span class="text-red-500">*</span>
                                </label>
                                <input type="number"
                                       step="0.1"
                                       id="iodium_mg"
                                       name="iodium_mg"
                                       value="{{ old('iodium_mg') }}"
                                       placeholder="0.0"
                                       class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('iodium_mg') border-red-500 @enderror"
                                       required>
                                @error('iodium_mg')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="px-8 py-6 bg-gray-50 border-t border-gray-200 flex items-center justify-between">
                    <div class="text-sm text-gray-500">
                        <span class="text-red-500">*</span> Field wajib diisi
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('superadmin.foods.index') }}"
                           class="inline-flex items-center px-6 py-3 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors duration-200 font-medium">
                            Batal
                        </a>
                        <button type="submit"
                                class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-medium rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Simpan Makanan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JavaScript untuk preview gambar -->
<script>
function previewImage(url) {
    const previewContainer = document.getElementById('image-preview');
    const previewImg = document.getElementById('preview-img');

    if (url && url.trim() !== '') {
        previewImg.src = url;
        previewImg.onload = function() {
            previewContainer.classList.remove('hidden');
        };
        previewImg.onerror = function() {
            previewContainer.classList.add('hidden');
        };
    } else {
        previewContainer.classList.add('hidden');
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
});
</script>
@endsection
