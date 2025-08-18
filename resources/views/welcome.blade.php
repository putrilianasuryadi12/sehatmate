@extends('layouts.app')

@section('content')
    <x-navigation-home />

    <!-- Hero Section -->
    <header class="bg-green-50 w-full h-screen object-cover relative" style="min-height: 350px;">
        <div class="w-full bg-gray-900/50 h-full relative">
            <img class="w-full h-full object-cover" src="{{ asset('imgs/hero.png') }}" alt="">
            <div class="absolute top-0 left-0 h-full w-full h-full bg-black/50"></div>
        </div>

        <div class="absolute top-0 left-0 w-full h-full flex items-center justify-center px-4">
            <div class="container mx-auto text-center flex flex-col items-center gap-4 max-w-6xl">
                <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-6xl font-bold mb-2 md:mb-4 text-white leading-tight">Sudah Cukup Gizimu Hari Ini?</h1>
                <p class="text-sm sm:text-base md:text-lg lg:text-2xl max-w-5xl mb-4 md:mb-8 text-white px-4 leading-relaxed">SehatMate membantumu mengetahui apakah asupan nutrisi harianmu sudah cukup, sekaligus menyusun rencana makan yang sesuai kebutuhanmu.</p>
                <a href="/rencana-makan" class="bg-white text-gray-800 px-6 sm:px-8 py-2 sm:py-3 rounded-lg font-bold hover:bg-gray-300 transition duration-300 text-sm sm:text-base">Mulai Rencana</a>
            </div>
        </div>
    </header>

    <!-- Features Section -->
    <section class="py-8 md:py-16 bg-[#061407]">
        <div class="container mx-auto px-4">

            <div class="text-left text-white mb-10 md:mb-20 mt-5 md:mt-10">
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-white mb-2 md:mb-4">Mengapa memilih Sehat<span class="text-yellow-400">Mate</span>?</h2>
                <p class="text-sm sm:text-base md:text-lg leading-relaxed">Dengan rencana makan yang disesuaikan untuk remaja dan dewasa, Sehat<span class="text-yellow-400">Mate</span> membantu Anda menjaga kesehatan Anda.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-8 text-left">
                <!-- Feature 1 -->
                <div class="text-white p-4 md:p-8 rounded-lg shadow-md bg-[#023A02]">
                    <img class="mb-3 md:mb-4 w-8 h-8 md:w-auto md:h-auto" src="{{ asset('icons/book.svg') }}" alt="">
                    <h3 class="text-lg md:text-xl font-bold mb-2">Rencana Makan yang Disesuaikan</h3>
                    <p class="text-sm md:text-base leading-relaxed">Dapatkan rencana makan yang disesuaikan dengan preferensi, alergi, dan tujuan kesehatan Anda.</p>
                </div>
                <!-- Feature 2 -->
                <div class="bg-[#023A02] text-white p-4 md:p-8 rounded-lg shadow-md">
                    <img class="mb-3 md:mb-4 w-8 h-8 md:w-auto md:h-auto" src="{{ asset('icons/book.svg') }}" alt="">
                    <h3 class="text-lg md:text-xl font-bold mb-2">Pelacakan Nutrisi Harian</h3>
                    <p class="text-sm md:text-base leading-relaxed">Lacak asupan kalori, makro, dan mikronutrien Anda dengan mudah untuk tetap di jalur.</p>
                </div>
                <!-- Feature 3 -->
                <div class="bg-[#023A02] text-white p-4 md:p-8 rounded-lg shadow-md sm:col-span-2 lg:col-span-1">
                    <img class="mb-3 md:mb-4 w-8 h-8 md:w-auto md:h-auto" src="{{ asset('icons/book.svg') }}" alt="">
                    <h3 class="text-lg md:text-xl font-bold mb-2">Dukungan Ahli</h3>
                    <p class="text-sm md:text-base leading-relaxed">Terhubung dengan ahli gizi dan pelatih kebugaran untuk mendapatkan saran dan dukungan ahli.</p>
                </div>
            </div>
        </div>
    </section>

    <x-footer-home />

    <script>
        document.getElementById('mobile-menu-button').onclick = function() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        };
    </script>
@endsection
