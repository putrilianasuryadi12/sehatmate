@extends('layouts.app')

@section('content')
    <div class="min-h-screen flex flex-col">
        <x-navigation />

        <main class="container mx-auto px-4 py-8 mt-16 my-auto flex-grow flex items-center justify-center">
            <div class="w-full text-center flex flex-col items-center">
                <h1 class="text-4xl font-bold">Selamat datang di Sehat<span class="text-yellow-400">Mate</span></h1>
                <p class="text-gray-600 mt-2">Pelacak nutrisi harian Anda. Daftar atau masuk untuk memulai.</p>

                <form action="/login" method="POST" class="space-y-6 mt-10 text-left max-w-md w-full">
                    @csrf
                    <div>
                        <label for="email" class="block text-sm font-bold text-gray-700 mb-2">Email</label>
                        <input type="email" name="email" id="email" autocomplete="email" required
                            class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-yellow-500 focus:border-yellow-500"
                            placeholder="Masukkan email kamu">
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-bold text-gray-700 mb-2">Kata Sandi</label>
                        <input type="password" name="password" id="password" autocomplete="current-password" required
                            class="appearance-none block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-yellow-500 focus:border-yellow-500"
                            placeholder="Masukkan kata sandi kamu">
                    </div>

                    <div id="response-message" class="text-sm mt-2"></div>

                    <div>
                        <button type="submit"
                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-black bg-gray-300 hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            Masuk
                        </button>
                    </div>
                </form>

                <div class="mt-6">
                    <p class="text-sm">
                        Tidak punya akun?
                        <a href="/register" class="font-medium text-black underline hover:text-gray-700">
                            Daftar
                        </a>
                    </p>
                </div>
            </div>
        </main>

        <div class="w-full mt-auto">
            <x-footer />
        </div>
    </div> <!-- end main container -->

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.querySelector('form');
            const responseMessageContainer = document.getElementById('response-message');

            form.addEventListener('submit', async function (event) {
                event.preventDefault();

                const formData = new FormData(form);
                const data = Object.fromEntries(formData.entries());

                try {
                    // Debug: log payload before sending
                    console.debug('Login payload:', data);

                    const response = await fetch('/login', {
                        method: 'POST',
                        credentials: 'same-origin', // send cookies for CSRF
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify(data),
                    });
                    // Debug: log raw response
                    console.debug('Response status:', response.status, response);

                     const result = await response.json();
                    // Debug: log parsed result
                    console.debug('Parsed result:', result);

                    if (response.ok && result.success) {
                        responseMessageContainer.className = 'text-green-500 text-sm mt-2';
                        responseMessageContainer.textContent = result.message;

                        // Redirect all users to foods management
                        window.location.href = '{{ route("superadmin.foods.index") }}';
                    } else {
                        responseMessageContainer.className = 'text-red-500 text-sm mt-2';
                        responseMessageContainer.textContent = result.message || 'Terjadi kesalahan.';
                    }
                } catch (error) {
                    responseMessageContainer.className = 'text-red-500 text-sm mt-2';
                    responseMessageContainer.textContent = 'Tidak dapat terhubung ke server.';
                    console.error('Error:', error);
                }
            });
        });
    </script>
@endsection
