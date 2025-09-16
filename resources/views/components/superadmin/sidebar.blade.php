<div class="fixed left-0 top-0 w-64 bg-white shadow-md h-screen flex flex-col justify-between">
    <nav class="mt-10">
        <div class="mb-6 w-full px-6 py-3">
            <a href="/" class="text-2xl font-bold">Sehat<span class="text-yellow-400">Mate</span></a>
        </div>

        <a href="{{ route('superadmin.users.index') }}"
            class="{{ request()->routeIs('superadmin.users.*') ? 'bg-gray-200' : '' }} flex items-center px-6 py-3 text-gray-700 hover:bg-gray-200">
            <img src="/icons/Users.svg" class="w-6 h-6" alt="">
            <span class="mx-3">Pengguna</span>
        </a>
        <a href="{{ route('superadmin.verification.index') }}"
            class="{{ request()->routeIs('superadmin.verification.*') ? 'bg-gray-200' : '' }} flex items-center px-6 py-3 text-gray-700 hover:bg-gray-200">
            <img src="/icons/Book.svg" class="w-6 h-6" alt="">
            <span class="mx-3">Persetujuan</span>
        </a>
        <a href="{{ route('superadmin.foods.index') }}"
            class="{{ request()->routeIs('superadmin.foods.*') ? 'bg-gray-200' : '' }} flex items-center px-6 py-3 text-gray-700 hover:bg-gray-200">
            <img src="/icons/Bookopen.svg" class="w-6 h-6" alt="">
            <span class="mx-3">Makanan</span>
        </a>
    </nav>
    <form action="{{ route('logout') }}" method="POST" class="w-full px-6 mb-6">
        @csrf
        <button type="submit" class="w-full flex items-center px-6 py-3 text-gray-700 hover:bg-gray-200">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                </path>
            </svg>
            <span class="mx-3">Logout</span>
        </button>
    </form>
</div>
