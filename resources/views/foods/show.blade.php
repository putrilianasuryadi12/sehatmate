@extends('layouts.app')

@section('title', $food->name)

@section('content')
    <x-navigation-home />

    <main class="bg-[#061407] w-full min-h-screen pb-16">
        <div class="container mx-auto px-4 py-8 mt-16">
            <!-- Back button -->
            <div class="mb-6">
                <a href="{{ route('foods.index') }}" class="text-yellow-400 hover:underline flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    <span class="ml-2 font-medium">Kembali</span>
                </a>
            </div>

            <!-- Food detail card -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden md:flex">
                <!-- Image -->
                <div class="md:w-1/2 h-64 md:h-auto">
                    <img src="{{ $food->urlimage ?? asset('imgs/default-fruits.jpg') }}" alt="{{ $food->name }}" class="w-full h-full object-cover">
                </div>
                <!-- Details -->
                <div class="p-8 md:w-1/2">
                    <h1 class="text-3xl font-bold text-gray-900 mb-6">{{ $food->name }}</h1>

                    <!-- Macronutrients -->
                    <div class="grid grid-cols-2 gap-4 text-gray-700 mb-6">
                        <div><span class="font-semibold">Kalori</span>: {{ $food->calories }} kkal</div>
                        <div><span class="font-semibold">Protein</span>: {{ $food->protein }} g</div>
                        <div><span class="font-semibold">Lemak</span>: {{ $food->fat }} g</div>
                        <div><span class="font-semibold">Karbohidrat</span>: {{ $food->carbohydrates }} g</div>
                        <div><span class="font-semibold">Serat</span>: {{ $food->serat_g ?? '-' }} g</div>
                        <div><span class="font-semibold">Air</span>: {{ $food->air_g ?? '-' }} g</div>
                        <div><span class="font-semibold">Abu</span>: {{ $food->abu_g ?? '-' }} g</div>
                        <div><span class="font-semibold">BDD</span>: {{ $food->bdd_persen ?? '-' }} %</div>
                    </div>

                    <hr class="my-6">

                    <!-- Minerals -->
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Mineral</h2>
                    <div class="grid grid-cols-2 gap-4 text-gray-700 mb-6">
                        <div><span class="font-semibold">Kalsium</span>: {{ $food->kalsium_mg ?? '-' }} mg</div>
                        <div><span class="font-semibold">Fosfor</span>: {{ $food->fosfor_mg ?? '-' }} mg</div>
                        <div><span class="font-semibold">Besi</span>: {{ $food->besi_mg ?? '-' }} mg</div>
                        <div><span class="font-semibold">Natrium</span>: {{ $food->natrium_mg ?? '-' }} mg</div>
                        <div><span class="font-semibold">Kalium</span>: {{ $food->kalium_mg ?? '-' }} mg</div>
                        <div><span class="font-semibold">Tembaga</span>: {{ $food->tembaga_mg ?? '-' }} mg</div>
                        <div><span class="font-semibold">Seng</span>: {{ $food->seng_mg ?? '-' }} mg</div>
                    </div>

                    <hr class="my-6">

                    <!-- Vitamins & Others -->
                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Vitamin & Lainnya</h2>
                    <div class="grid grid-cols-2 gap-4 text-gray-700">
                        <div><span class="font-semibold">Retinol</span>: {{ $food->retinol_mcg ?? '-' }} mcg</div>
                        <div><span class="font-semibold">Beta Karoten</span>: {{ $food->b_kar_mcg ?? '-' }} mcg</div>
                        <div><span class="font-semibold">Karotenoid Total</span>: {{ $food->kar_total_mcg ?? '-' }} mcg</div>
                        <div><span class="font-semibold">Thiamin</span>: {{ $food->thiamin_mg ?? '-' }} mg</div>
                        <div><span class="font-semibold">Riboflavin</span>: {{ $food->riboflavin_mg ?? '-' }} mg</div>
                        <div><span class="font-semibold">Niasin</span>: {{ $food->niasin_mg ?? '-' }} mg</div>
                        <div><span class="font-semibold">Vitamin C</span>: {{ $food->vitamin_c_mg ?? '-' }} mg</div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <x-footer-home />
@endsection
