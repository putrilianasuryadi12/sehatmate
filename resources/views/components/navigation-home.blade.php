<!-- Navbar -->
<nav class="bg-[#102810] text-white font-bold shadow-md fixed top-0 left-0 right-0 z-10">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center py-4">
            <a href="/" class="text-2xl font-bold">Sehat<span class="text-yellow-400">Mate</span></a>
            <div class="hidden md:flex items-center space-x-8">
                <a href="/" class="hover:text-black {{ request()->is('/') ? 'underline underline-offset-4 decoration-white' : '' }}">Beranda</a>
                <a href="/rencana-makan" class="hover:text-black {{ request()->is('rencana-makan') ? 'underline underline-offset-4 decoration-white' : '' }}">Rencana Makanan</a>
                <a href="/register" class="bg-gray-200 text-black px-4 py-2 rounded-md hover:bg-gray-300 {{ request()->is('register') ? 'underline underline-offset-4 decoration-white' : '' }}">Daftar</a>
                <a href="/login" class="bg-gray-200 text-black px-4 py-2 rounded-md hover:bg-gray-300 {{ request()->is('login') ? 'underline underline-offset-4 decoration-white' : '' }}">Masuk</a>
            </div>
            <div class="md:hidden">
                <button id="mobile-menu-button" class="text-gray-600 hover:text-green-600 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden md:hidden">
        <a href="/" class="block py-2 px-4 text-sm text-gray-600 hover:bg-gray-100">Beranda</a>
        <a href="/rencana-makan" class="block py-2 px-4 text-sm text-gray-600 hover:bg-gray-100">Rencana Makanan</a>
        <a href="#" class="block py-2 px-4 text-sm text-black bg-gray-200 hover:bg-gray-300">Daftar</a>
        <a href="/login" class="block py-2 px-4 text-sm text-black bg-yellow-400 hover:bg-yellow-500">Masuk</a>
    </div>
</nav>
