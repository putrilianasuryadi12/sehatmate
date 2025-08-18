@extends('layouts.app')

@section('content')
    <div class="min-h-screen flex flex-col">
        <x-navigation />

        <main class="container mx-auto px-4 py-8 mt-16 my-auto flex-grow flex items-center justify-center">
            <div class="w-full text-center flex flex-col items-center">
                <h1 class="text-4xl font-bold">Daftar ke Sehat<span class="text-yellow-400">Mate</span></h1>
                <p class="text-gray-600 mt-2">Pelacak nutrisi harian Anda. Daftar atau masuk untuk memulai.</p>

                <form action="/register" method="POST" class="space-y-6 mt-10 text-left max-w-md w-full">
                    @csrf
                    <div>
                        <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Nama</label>
                        <input type="text" name="name" id="name" placeholder="Siapa nama kamu?" required
                            class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-yellow-500 focus:border-yellow-500">
                    </div>
                    <div>
                        <label for="usia" class="block text-sm font-bold text-gray-700 mb-2">Usia</label>
                        <input type="number" name="usia" id="usia" placeholder="Berapa usia kamu?" required
                            class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-yellow-500 focus:border-yellow-500">
                    </div>
                    <div>
                        <label for="jenis_kelamin" class="block text-sm font-bold text-gray-700 mb-2">Jenis Kelamin</label>
                        <select name="jenis_kelamin" id="jenis_kelamin" required
                            class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-yellow-500 focus:border-yellow-500">
                            <option value="">Pilih jenis kelamin</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div>
                        <label for="nomor_str" class="block text-sm font-bold text-gray-700 mb-2">Nomor STR</label>
                        <input type="text" name="nomor_str" id="nomor_str" placeholder="15 digit angka" required
                            class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-yellow-500 focus:border-yellow-500">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-bold text-gray-700 mb-2">Email</label>
                        <input type="email" name="email" id="email" placeholder="Masukkan email kamu" required
                            class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-yellow-500 focus:border-yellow-500">
                    </div>
                    <div>
                        <label for="password" class="block text-sm font-bold text-gray-700 mb-2">Password</label>
                        <input type="password" name="password" id="password" placeholder="Masukkan password" required
                            class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-yellow-500 focus:border-yellow-500">
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-bold text-gray-700 mb-2">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Konfirmasi password" required
                            class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-yellow-500 focus:border-yellow-500">
                    </div>
                    <div>
                        <button type="submit"
                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-black bg-gray-300 hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            Daftar
                        </button>
                    </div>
                </form>

                <div class="mt-6">
                    <p class="text-sm">
                        Sudah punya akun?
                        <a href="/login" class="font-medium text-black underline hover:text-gray-700">
                            Masuk
                        </a>
                    </p>
                </div>
            </div>
        </main>

        <div class="w-full mt-auto">
            <x-footer />
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Validate STR number length on registration form -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form[action="/register"]');
            const strInput = document.getElementById('nomor_str');
            form.addEventListener('submit', function(e) {
                const len = strInput.value.trim().length;
                if (len < 13 || len > 16) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Nomor STR tidak valid',
                        text: 'Nomor STR harus terdiri dari 13-16 karakter.',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });
    </script>
    @if(!empty($pending))
    <script>
        Swal.fire({
            icon: 'info',
            title: 'Pendaftaran Berhasil',
            text: 'Akun Anda berhasil dibuat dan menunggu persetujuan Superadmin.',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{ route('login') }}";
            }
        });
    </script>
    @endif
@endsection
