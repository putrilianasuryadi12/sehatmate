@extends('layouts.app')

@section('content')
    <x-navigation-home />

    <main class="bg-[#061407] w-full min-h-screen pb-16">
        <div class="container mx-auto px-4 py-8 mt-16">
            <div class="text-center mb-12">
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">Daftar Makanan</h1>
                <p class="text-yellow-400 text-lg">Temukan informasi nutrisi lengkap untuk berbagai jenis makanan</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($foods as $food)
                    <a href="{{ route('foods.show', $food) }}" class="block">
                        <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition-all duration-300 cursor-pointer hover:bg-gray-50 hover:scale-105">
                            <div class="mb-4">
                                <img src="{{ $food->urlimage ?? asset('imgs/default-fruits.jpg') }}"
                                     alt="{{ $food->name }}"
                                     class="w-full h-48 object-cover rounded-lg">
                            </div>
                            <h2 class="text-xl font-bold text-gray-900 mb-2">{{ $food->name }}</h2>
                            <div class="grid grid-cols-2 gap-2 text-sm text-gray-600 mb-3">
                                <span>Kalori: {{ $food->calories }} kkal</span>
                                <span>Protein: {{ $food->protein }} g</span>
                            </div>
                            <div class="mt-4 text-green-600 font-semibold text-sm flex items-center">
                                Lihat Detail
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </main>

    <x-footer-home />
@endsection
