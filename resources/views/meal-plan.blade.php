@extends('layouts.app')

@section('content')
    <x-navigation-home />

    <main class="bg-[#061407] w-full min-h-screen pb-16">
        <form action="{{ route('meal-plan.calculate') }}" method="POST" class="container mx-auto px-4 py-8 mt-16 flex flex-col lg:flex-row text-white gap-8">
            @csrf
            <!-- Left Section - Isi Data Diri -->
            <div class="flex flex-col w-full lg:w-1/2">
                <h1 class="text-2xl md:text-3xl font-bold mb-2">Isi Data Diri</h1>
                <hr class="border-t-2 border-white w-32">
                <p class="mb-6 mt-2 italic text-yellow-400">*Data kamu akan digunakan untuk menghitung kebutuhan kalori dan gizi harianmu.</p>

                <div class="space-y-4 md:space-y-6">
                    <!-- Usia -->
                    <div>
                        <label for="age" class="block text-white text-base md:text-lg font-medium mb-2 md:mb-3">Usia</label>
                        <input type="text" id="age" name="age" placeholder="Berapa usia kamu?"
                               class="w-full px-3 md:px-4 py-2 md:py-3 rounded-lg bg-white text-black placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-400 text-sm md:text-base" value="{{ old('age') }}">
                    </div>

                    <!-- Jenis Kelamin -->
                    <div>
                        <label for="gender" class="block text-white text-base md:text-lg font-medium mb-2 md:mb-3">Jenis Kelamin</label>
                        <select id="gender" name="gender" class="w-full px-3 md:px-4 py-2 md:py-3 rounded-lg bg-white text-black focus:outline-none focus:ring-2 focus:ring-green-400 text-sm md:text-base">
                            <option value="">Apa jenis kelamin kamu?</option>
                            <option value="Laki-laki" {{ old('gender') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('gender') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    <!-- Aktivitas Harian -->
                    <div>
                        <label for="activity" class="block text-white text-base md:text-lg font-medium mb-2 md:mb-3">Aktivitas Harian</label>
                        <select id="activity" name="activity" class="w-full px-3 md:px-4 py-2 md:py-3 rounded-lg bg-white text-black focus:outline-none focus:ring-2 focus:ring-green-400 text-sm md:text-base">
                            <option value="">Aktivitas yang kamu lakukan</option>
                            <option value="sedentary">Sangat ringan (sedikit beraktifitas, tidak berolahraga)</option>
                            <option value="lightly_active">Ringan (olahraga ringan 1-3 kali seminggu)</option>
                            <option value="moderately_active">Sedang (olahraga ringan 6-7 kali semiggu)</option>
                            <option value="very_active">Berat (olahraga berat setiap hari/2 kali dalam sehari)</option>
                        </select>
                    </div>

                    <!-- Berat dan Tinggi Badan -->
                    <div class="flex flex-col sm:flex-row gap-4">
                        <div class="flex-1">
                            <label for="weight" class="block text-white text-base md:text-lg font-medium mb-2 md:mb-3">Berat Badan</label>
                            <input type="text" id="weight" name="weight" placeholder="kg"
                                   class="w-full px-3 md:px-4 py-2 md:py-3 rounded-lg bg-white text-black placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-400 text-sm md:text-base" value="{{ old('weight') }}">
                        </div>
                        <div class="flex-1">
                            <label for="height" class="block text-white text-base md:text-lg font-medium mb-2 md:mb-3">Tinggi Badan</label>
                            <input type="text" id="height" name="height" placeholder="cm"
                                   class="w-full px-3 md:px-4 py-2 md:py-3 rounded-lg bg-white text-black placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-400 text-sm md:text-base" value="{{ old('height') }}">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Section - Menu Makanan Hari Ini -->
            <div class="flex flex-col w-full lg:w-1/2 mt-8 lg:mt-0">
                <h1 class="text-2xl md:text-3xl font-bold mb-2">Menu Makanan Hari Ini</h1>
                <hr class="border-t-2 border-white w-48">
                                <p class="mb-6 mt-2 italic text-yellow-400">*Masukkan nama makanan (per 100 gram)</p>


                <div class="space-y-4 md:space-y-6">
                    <!-- Sarapan -->
                    <div x-data="{ searchTerm: '', recommendations: [], selectedFoodId: '', selectedFoodName: '' }">
                        <label for="breakfast" class="block text-white text-base md:text-lg font-medium mb-2 md:mb-3">Sarapan</label>
                        <input type="hidden" name="breakfast" x-model="selectedFoodId">
                        <input type="hidden" name="breakfast_name" x-model="selectedFoodName">
                        <div class="relative">
                            <input type="text" id="breakfast-search" x-model="searchTerm" @keydown.enter.prevent
                                   @input.debounce.300ms="if (searchTerm.length > 2 && searchTerm !== selectedFoodName) { fetch('{{ route('food.search') }}?query=' + encodeURIComponent(searchTerm))
                                       .then(res => res.json()).then(data => recommendations = data).catch(err => console.error(err)); } else { recommendations = [] }"
                                   placeholder="Cari sarapan..."
                                   class="w-full px-3 md:px-4 py-2 md:py-3 rounded-lg bg-white text-black placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-400 text-sm md:text-base">
                            <div x-show="recommendations.length > 0" @click.away="recommendations = []" class="absolute z-10 w-full mt-1 bg-white rounded-lg shadow-lg max-h-60 overflow-auto">
                                <template x-for="food in recommendations" :key="food.id">
                                    <div @click.stop.prevent="
                                       selectedFoodId = food.id;
                                       selectedFoodName = food.name;
                                       searchTerm = food.name;
                                       recommendations = [];
                                   " class="flex items-center p-2 cursor-pointer hover:bg-gray-100">
                                        <img loading="lazy" :src="food.urlimage || '{{ asset('imgs/default-fruits.jpg') }}'" :alt="food.name" class="w-10 h-10 mr-3 rounded">
                                        <span class="text-black" x-text="food.name"></span>
                                    </div>
                                </template>
                            </div>
                            <!-- Not found indicator -->
                            <div x-show="searchTerm.length > 2 && recommendations.length === 0" @click.away="recommendations = []" class="flex w-full items-center justify-between absolute z-10 w-full mt-1 bg-white rounded-lg shadow-lg p-4 text-center">
                                <div class="flex gap-2 items-center justify-center">
                                    <img src="/icons/alert.svg" class="w-5 h-5" alt="">
                                    <p class="text-gray-700">Makanan tidak ditemukan</p>
                                </div>
                                <a href="{{ route('register') }}" class="inline-block bg-yellow-400 text-gray-800 px-3 py-1 rounded">Tambahkan Makanan</a>
                            </div>
                        </div>
                    </div>

                    <!-- Makan Siang -->
                    <div x-data="{ searchTerm: '', recommendations: [], selectedFoodId: '', selectedFoodName: '' }">
                        <label for="lunch" class="block text-white text-base md:text-lg font-medium mb-2 md:mb-3">Makan Siang</label>
                        <input type="hidden" name="lunch" x-model="selectedFoodId">
                        <input type="hidden" name="lunch_name" x-model="selectedFoodName">
                        <div class="relative">
                            <input type="text" id="lunch-search" x-model="searchTerm" @keydown.enter.prevent
                                   @input.debounce.300ms="if (searchTerm.length > 2 && searchTerm !== selectedFoodName) { fetch('{{ route('food.search') }}?query=' + encodeURIComponent(searchTerm))
                                       .then(res => res.json()).then(data => recommendations = data).catch(err => console.error(err)); } else { recommendations = [] }"
                                   placeholder="Cari makan siang..."
                                   class="w-full px-3 md:px-4 py-2 md:py-3 rounded-lg bg-white text-black placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-400 text-sm md:text-base">
                            <div x-show="recommendations.length > 0" @click.away="recommendations = []" class="absolute z-10 w-full mt-1 bg-white rounded-lg shadow-lg max-h-60 overflow-auto">
                                <template x-for="food in recommendations" :key="food.id">
                                    <div @click.stop.prevent="
                                       selectedFoodId = food.id;
                                       selectedFoodName = food.name;
                                       searchTerm = food.name;
                                       recommendations = [];
                                   " class="flex items-center p-2 cursor-pointer hover:bg-gray-100">
                                        <img loading="lazy" :src="food.urlimage || '{{ asset('imgs/default-fruits.jpg') }}'" :alt="food.name" class="w-10 h-10 mr-3 rounded">
                                        <span class="text-black" x-text="food.name"></span>
                                    </div>
                                </template>
                            </div>
                            <!-- Not found indicator for lunch -->
                            <div x-show="searchTerm.length > 2 && recommendations.length === 0" @click.away="recommendations = []" class="flex w-full items-center justify-between absolute z-10 w-full mt-1 bg-white rounded-lg shadow-lg p-4 text-center">
                                <div class="flex gap-2 items-center justify-center">
                                    <img src="/icons/alert.svg" class="w-5 h-5" alt="">
                                    <p class="text-gray-700">Makanan tidak ditemukan</p>
                                </div>
                                <a href="{{ route('register') }}" class="inline-block bg-yellow-400 text-gray-800 px-3 py-1 rounded">Tambahkan Makanan</a>
                            </div>
                        </div>
                    </div>

                    <!-- Makan Malam -->
                    <div x-data="{ searchTerm: '', recommendations: [], selectedFoodId: '', selectedFoodName: '' }">
                        <label for="dinner" class="block text-white text-base md:text-lg font-medium mb-2 md:mb-3">Makan Malam</label>
                        <input type="hidden" name="dinner" x-model="selectedFoodId">
                        <input type="hidden" name="dinner_name" x-model="selectedFoodName">
                        <div class="relative">
                            <input type="text" id="dinner-search" x-model="searchTerm" @keydown.enter.prevent
                                   @input.debounce.300ms=" if (searchTerm.length > 2 && searchTerm !== selectedFoodName) { fetch('{{ route('food.search') }}?query=' + encodeURIComponent(searchTerm))
                                       .then(res => res.json())
                                       .then(data => { console.log('dinner data', data); recommendations = data; })
                                       .catch(err => console.error(err)); } else { recommendations = []; }"
                                   placeholder="Cari makan malam..."
                                   class="w-full px-3 md:px-4 py-2 md:py-3 rounded-lg bg-white text-black placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-green-400 text-sm md:text-base">
                            <div x-show="recommendations.length > 0" @click.away="recommendations = []" class="absolute z-10 w-full mt-1 bg-white rounded-lg shadow-lg max-h-60 overflow-auto">
                                <template x-for="food in recommendations" :key="food.id">
                                    <div @click.stop.prevent="
                                       selectedFoodId = food.id;
                                       selectedFoodName = food.name;
                                       searchTerm = food.name;
                                       recommendations = [];
                                   " class="flex items-center p-2 cursor-pointer hover:bg-gray-100">
                                        <img loading="lazy" :src="food.urlimage || '{{ asset('imgs/default-fruits.jpg') }}'" :alt="food.name" class="w-10 h-10 mr-3 rounded">
                                        <span class="text-black" x-text="food.name"></span>
                                    </div>
                                </template>
                            </div>
                            <!-- Not found indicator -->
                            <div x-show="searchTerm.length > 2 && recommendations.length === 0" @click.away="recommendations = []" class="flex w-full items-center justify-between absolute z-10 w-full mt-1 bg-white rounded-lg shadow-lg p-4 text-center">
                                <div class="flex gap-2 items-center justify-center">
                                    <img src="/icons/alert.svg" class="w-5 h-5" alt="">
                                    <p class="text-gray-700">Makanan tidak ditemukan</p>
                                </div>
                                <a href="{{ route('register') }}" class="inline-block bg-yellow-400 text-gray-800 px-3 py-1 rounded">Tambahkan Makanan</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-8 text-right">
                    <button type="submit" class="w-full sm:w-auto bg-green-500 hover:bg-green-600 text-white px-8 py-3 rounded-full font-semibold transition duration-300 text-sm md:text-base">
                        Hitung Nutrisi
                    </button>
                </div>
            </div>
        </form>

        @php
            // Define nutrients for manual progress display using database requirements
            $nutrients = [
                'Energi'      => ['key' => 'calories',      'unit' => 'kkal', 'total' => $requirements->energi_kkal ?? 0],
                'Protein'     => ['key' => 'protein',       'unit' => 'g',    'total' => $requirements->protein_g ?? 0],
                'Karbohidrat' => ['key' => 'carbohydrates', 'unit' => 'g',    'total' => $requirements->karbohidrat_g ?? 0],
                'Lemak'       => ['key' => 'fat',           'unit' => 'g',    'total' => $requirements->lemak_total_g ?? 0],
                'Vitamin C'   => ['key' => 'vitamin_c',     'unit' => 'mg',   'total' => $requirements->vitamin_c_mg ?? 0],
                'Zat Besi'    => ['key' => 'besi_mg',       'unit' => 'mg',   'total' => $requirements->besi_mg ?? 0],
                'Zink'        => ['key' => 'seng_mg',       'unit' => 'mg',   'total' => $requirements->seng_mg ?? 0],
            ];
        @endphp

        @isset($requirements)
        @isset($totalIntake)
        @isset($meals)
        <!-- Menu Terpilih -->
        <div class="container mx-auto px-4 py-6 text-white">
            <h2 class="text-2xl font-bold mb-2">Menu Terpilih</h2>
            <hr class="border-t-2 border-white w-48 mb-4">
            <div class="bg-[#E8E8E8] text-black rounded-2xl p-6 flex flex-col sm:flex-row justify-between items-start space-y-4 sm:space-y-0">
                @php $mealLabels = ['breakfast' => 'Sarapan', 'lunch' => 'Makan Siang', 'dinner' => 'Makan Malam']; @endphp
                @foreach($mealLabels as $key => $label)
                    <div class="flex flex-col items-start">
                        <p class="font-semibold mb-2">{{ $label }}</p>
                        <div id="selected-{{ $key }}" class="flex flex-wrap gap-4">
                            {{-- Makanan yang dipilih akan ditambahkan di sini --}}
                            @if(isset($meals[$key]))
                                <div class="flex flex-col items-center bg-white rounded-lg p-2 selected-item" data-meal="{{ $key }}" data-id="{{ $meals[$key]->id }}" data-food='@json($meals[$key])'>
                                    <img src="{{ $meals[$key]->urlimage ?? asset('imgs/default-fruits.jpg') }}" alt="{{ $meals[$key]->name }}" class="w-16 h-16 object-cover rounded mb-1">
                                    <p class="text-sm text-black text-center">{{ $meals[$key]->name }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="container mx-auto px-4 py-8 text-white">
            <h2 class="text-3xl font-bold mb-2">Hasil Nutrisi Harian</h2>
            <hr class="border-t-2 border-white w-32 mb-6">
            <div class="bg-[#E8E8E8] text-black rounded-2xl p-8">
                <p class="text-right text-sm text-gray-500 mb-6">Perhitungan berdasarkan 100 gram per makanan</p>

                {{-- Progress bars untuk hasil nutrisi harian --}}
                <div class="space-y-6">
                    @foreach($nutrients as $label => $data)
                        @php
                            $current = isset($totalIntake[$data['key']]) ? $totalIntake[$data['key']] : 0;
                            $total = $data['total'];
                            $percentage = $total > 0 ? round(($current / $total) * 100) : 0;
                            $key = $data['key'];
                        @endphp
                        <div class="grid grid-cols-12 gap-4 items-center">
                            <div class="col-span-3">
                                <p class="font-bold">{{ $label }}</p>
                                <p class="text-sm text-gray-600"><span id="nutrient-current-{{ $key }}">{{ $current }}</span> / {{ $total }} {{ $data['unit'] ?? '' }}</p>
                            </div>
                            <div class="col-span-7">
                                <div class="w-full bg-gray-300 rounded-full h-2.5 overflow-hidden">
                                    <div id="nutrient-bar-{{ $key }}" class="bg-green-600 h-2.5 rounded-full transition-all duration-1000 ease-in-out" style="width: 0%" x-init="setTimeout(() => $el.style.width = '{{ $percentage }}%', {{ $loop->index * 150 }})"></div>
                                </div>
                            </div>
                            <div class="col-span-2 text-right">
                                <p class="font-bold text-lg text-green-600"><span id="nutrient-percent-{{ $key }}">{{ $percentage }}</span>%</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="container mx-auto px-4 py-8 text-white">
            <h2 class="text-3xl font-bold mb-2">Rekomendasi Makanan yang Disesuaikan</h2>
            <hr class="border-t-2 border-white w-80 mb-6">
            <div id="dynamic-recs" class="bg-[#E8E8E8] text-black rounded-2xl p-20 space-y-6">
                @php
                    $combined = $combinedRecommendations ?? collect();
                    $byNutrient = $recommendationsByNutrient ?? [];
                @endphp

                {{-- Tampilkan kombinasi rekomendasi terlebih dahulu (jika ada) --}}
                @if($combined && count($combined) > 0)
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach($combined as $index => $food)
                            <div class="rounded-lg p-4 bg-white text-black flex flex-col recommendation-card" data-id="{{ $food->id }}" data-index="{{ $index }}">
                                <img src="{{ $food->urlimage ?? asset('imgs/default-fruits.jpg') }}" alt="{{ $food->name }}" class="w-full h-40 object-cover rounded mb-4">
                                <h3 class="font-bold text-lg">{{ $food->name }}</h3>
                                <p class="text-gray-600 flex-grow mt-2">{{ $food->description ?? 'Deskripsi tidak tersedia.' }}</p>
                                <div class="mt-4 text-right">
                                    <button type="button" data-meal="breakfast" data-id="{{ $food->id }}" data-name="{{ addslashes($food->name) }}" data-image="{{ $food->urlimage ?? asset('imgs/default-fruits.jpg') }}" data-food='@json($food)' class="add-meal-btn bg-green-500 text-white px-3 py-2 rounded-full text-sm font-semibold hover:bg-green-600 transition">Sarapan</button>
                                    <button type="button" data-meal="lunch" data-id="{{ $food->id }}" data-name="{{ addslashes($food->name) }}" data-image="{{ $food->urlimage ?? asset('imgs/default-fruits.jpg') }}" data-food='@json($food)' class="add-meal-btn bg-green-500 text-white px-3 py-2 rounded-full text-sm font-semibold hover:bg-green-600 transition ml-2">Makan Siang</button>
                                    <button type="button" data-meal="dinner" data-id="{{ $food->id }}" data-name="{{ addslashes($food->name) }}" data-image="{{ $food->urlimage ?? asset('imgs/default-fruits.jpg') }}" data-food='@json($food)' class="add-meal-btn bg-green-500 text-white px-3 py-2 rounded-full text-sm font-semibold hover:bg-green-600 transition ml-2">Makan Malam</button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    {{-- Jika tidak ada kombinasi, tampilkan rekomendasi per nutrisi --}}
                    @foreach($byNutrient as $nutrientKey => $list)
                        @if($list && count($list) > 0)
                            <div>
                                <p class="text-sm text-green-600 font-semibold mb-2">Rekomendasi untuk {{ ucwords(str_replace('_', ' ', $nutrientKey)) }}</p>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    @foreach($list as $food)
                                        <div class="rounded-lg p-4 bg-white text-black flex flex-col recommendation-card" data-id="{{ $food->id }}">
                                            <img src="{{ $food->urlimage ?? asset('imgs/default-fruits.jpg') }}" alt="{{ $food->name }}" class="w-full h-32 object-cover rounded mb-3">
                                            <h4 class="font-semibold">{{ $food->name }}</h4>
                                            <p class="text-gray-600 text-sm flex-grow mt-2">{{ $food->description ?? 'Deskripsi tidak tersedia.' }}</p>
                                            <div class="mt-3 text-right">
                                                <button type="button" data-meal="breakfast" data-id="{{ $food->id }}" data-name="{{ addslashes($food->name) }}" data-image="{{ $food->urlimage ?? asset('imgs/default-fruits.jpg') }}" data-food='@json($food)' class="add-meal-btn bg-green-500 text-white px-3 py-2 rounded-full text-sm font-semibold hover:bg-green-600 transition">Sarapan</button>
                                                <button type="button" data-meal="lunch" data-id="{{ $food->id }}" data-name="{{ addslashes($food->name) }}" data-image="{{ $food->urlimage ?? asset('imgs/default-fruits.jpg') }}" data-food='@json($food)' class="add-meal-btn bg-green-500 text-white px-3 py-2 rounded-full text-sm font-semibold hover:bg-green-600 transition ml-2">Makan Siang</button>
                                                <button type="button" data-meal="dinner" data-id="{{ $food->id }}" data-name="{{ addslashes($food->name) }}" data-image="{{ $food->urlimage ?? asset('imgs/default-fruits.jpg') }}" data-food='@json($food)' class="add-meal-btn bg-green-500 text-white px-3 py-2 rounded-full text-sm font-semibold hover:bg-green-600 transition ml-2">Makan Malam</button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endforeach
                    {{-- Jika sama-sama kosong, tampilkan pesan --}}
                    @if((!$byNutrient || collect($byNutrient)->flatten()->isEmpty()) && (!$combined || count($combined) == 0))
                        <p class="text-gray-700">Tidak ada rekomendasi ditemukan untuk memenuhi defisit nutrisi. Coba pilih makanan lain atau periksa database makanan.</p>
                    @endif
                @endif
            </div>
         </div>
        @endisset
        @endisset
        @endisset
    </main>

    <x-footer-home />

    <script>
        // Data nutrisi awal dari server
        const nutrientTotals = {
            calories: {{ $totalIntake['calories'] ?? 0 }},
            protein: {{ $totalIntake['protein'] ?? 0 }},
            fat: {{ $totalIntake['fat'] ?? 0 }},
            carbohydrates: {{ $totalIntake['carbohydrates'] ?? 0 }},
            vitamin_c: {{ $totalIntake['vitamin_c'] ?? 0 }},
            besi_mg: {{ $totalIntake['besi_mg'] ?? 0 }},
            seng_mg: {{ $totalIntake['seng_mg'] ?? 0 }},
        };

        const nutrientRequirements = {
            calories: {{ $requirements->energi_kkal ?? 0 }},
            protein: {{ $requirements->protein_g ?? 0 }},
            fat: {{ $requirements->lemak_total_g ?? 0 }},
            carbohydrates: {{ $requirements->karbohidrat_g ?? 0 }},
            vitamin_c: {{ $requirements->vitamin_c_mg ?? 0 }},
            besi_mg: {{ $requirements->besi_mg ?? 0 }},
            seng_mg: {{ $requirements->seng_mg ?? 0 }},
        };

        // Melacak data nutrisi: simpan baseline dan array pilihan per meal
        const baseTotals = { ...nutrientTotals };
        const selectedMealNutrients = {
            breakfast: [],
            lunch: [],
            dinner: [],
        };

        function updateNutritionUI() {
            // reset totals to base
            const newTotals = { ...baseTotals };
            // sum selected nutrients
            Object.values(selectedMealNutrients).flat().forEach(food => {
                newTotals.calories += food.calories || 0;
                newTotals.protein += food.protein || 0;
                newTotals.fat += food.fat || 0;
                newTotals.carbohydrates += food.carbohydrates || 0;
                newTotals.vitamin_c += food.vitamin_c_mg || 0;
                newTotals.besi_mg += food.besi_mg || 0;
            });
            Object.keys(newTotals).forEach(key => {
                const currentEl = document.getElementById(`nutrient-current-${key}`);
                const barEl = document.getElementById(`nutrient-bar-${key}`);
                const percentEl = document.getElementById(`nutrient-percent-${key}`);
                if (!currentEl || !barEl || !percentEl) return;
                const current = Math.round(newTotals[key]);
                const required = nutrientRequirements[key] || 0;
                const percentage = required > 0 ? Math.round((current / required) * 100) : 0;
                currentEl.textContent = current;
                barEl.style.width = Math.min(100, percentage) + '%';
                percentEl.textContent = percentage;
            });
        }

        function addToMeal(event, meal, id, name, image, foodData) {
            // Prevent duplicates in the same meal
            if (selectedMealNutrients[meal].some(f => f.id == id)) return;
            const cardElement = event.target.closest('.recommendation-card');
            // Hide the clicked recommendation so it's replaced by new ones if available
            if (cardElement) cardElement.style.display = 'none';
            // tanda pilihan
            selectedMealNutrients[meal].push(foodData);

     // Append UI "Menu Terpilih"
     const container = document.getElementById(`selected-${meal}`);
     if (container) {
         const item = document.createElement('div');
         item.className = 'flex flex-col items-center bg-white rounded-lg p-2 selected-item';
         item.dataset.meal = meal;
         item.dataset.id = id;
         item.dataset.food = JSON.stringify(foodData);
         item.innerHTML = `
             <img src="${image}" alt="${name}" class="w-16 h-16 object-cover rounded mb-1">
             <p class="text-sm text-black text-center">${name}</p>
             <button type="button" class="remove-item-btn text-red-500 mt-1">&times;</button>
         `;
         container.appendChild(item);
     }

     // Tambahkan hidden input baru untuk form
     const form = document.querySelector('form');
     const input = document.createElement('input');
     input.type = 'hidden';
     input.name = `${meal}[]`;
     input.value = id;
     form.appendChild(input);

    updateNutritionUI();
 }
        // Inisialisasi UI saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function () {
            // Mengatur ulang style width progress bar yang di-render server
            // agar animasi CSS dapat berjalan saat halaman dimuat
            @isset($requirements)
                @foreach($nutrients as $label => $data)
                    @php
                        $current = isset($totalIntake[$data['key']]) ? $totalIntake[$data['key']] : 0;
                        $total = $data['total'];
                        $percentage = $total > 0 ? round(($current / $total) * 100) : 0;
                        $key = $data['key'];
                    @endphp
                    const bar{{$loop->index}} = document.getElementById('nutrient-bar-{{ $key }}');
                    if(bar{{$loop->index}}) {
                        setTimeout(() => { bar{{$loop->index}}.style.width = '{{ $percentage }}%'; }, {{ $loop->index * 150 }});
                    }
                @endforeach
            @endisset

            // bind click handlers: add to meal and refresh recommendations
            document.querySelectorAll('.add-meal-btn').forEach(btn => {
                btn.addEventListener('click', async function(event) {
                    const meal = this.dataset.meal;
                    const id = this.dataset.id;
                    const name = this.dataset.name;
                    const image = this.dataset.image;
                    const foodData = JSON.parse(this.dataset.food);
                    addToMeal(event, meal, id, name, image, foodData);
                    // fetch and render new recommendations
                    await loadRecommendations();
                });
            });
            // Handler for removing dynamically added selected items
            document.addEventListener('click', function(event) {
                if (!event.target.classList.contains('remove-item-btn')) return;
                const btn = event.target;
                const itemDiv = btn.closest('.selected-item');
                const meal = itemDiv.dataset.meal;
                const id = itemDiv.dataset.id;
                const foodData = JSON.parse(itemDiv.dataset.food);
                // Clear selected meal tracking
                selectedMealNutrients[meal] = selectedMealNutrients[meal].filter(food => food.id != foodData.id);
                updateNutritionUI();
                // Remove hidden input
                const input = document.querySelector(`input[name="${meal}[]"][value="${id}"]`);
                if (input) input.remove();
                // Remove selected item element
                itemDiv.remove();
                // Re-show recommendation card
                const card = document.querySelector(`.recommendation-card[data-id="${id}"]`);
                if (card) card.style.display = '';
            });
        });

        // Fetch new recommendations after a meal selection
        async function loadRecommendations() {
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const payload = {
                breakfast: selectedMealNutrients.breakfast.map(f => f.id),
                lunch: selectedMealNutrients.lunch.map(f => f.id),
                dinner: selectedMealNutrients.dinner.map(f => f.id),
            };
            const response = await fetch('{{ route('meal-plan.recommendations') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token
                },
                body: JSON.stringify(payload)
            });
            if (!response.ok) return;
            const data = await response.json();
            const container = document.getElementById('dynamic-recs');
            if (!container) return;
            let html = '';
            if (data.recommendations.length > 0) {
                html += `<p class="text-sm text-green-600 font-semibold mb-2">Rekomendasi untuk ${data.focusNutrient.replace('_',' ')}</p>`;
                html += '<div class="grid grid-cols-1 md:grid-cols-3 gap-4">';
                data.recommendations.forEach(food => {
                    html += `
                    <div class="rounded-lg p-4 bg-white text-black flex flex-col recommendation-card" data-id="${food.id}">
                        <img src="${food.urlimage || '{{ asset('imgs/default-fruits.jpg') }}'}" alt="${food.name}" class="w-full h-32 object-cover rounded mb-3">
                        <h4 class="font-semibold">${food.name}</h4>
                        <p class="text-gray-600 text-sm flex-grow mt-2">${food.description || 'Deskripsi tidak tersedia.'}</p>
                        <div class="mt-3 text-right">
                            <button type="button" data-meal="breakfast" data-id="${food.id}" data-name="${food.name}" data-image="${food.urlimage || '{{ asset('imgs/default-fruits.jpg') }}'}" data-food='${JSON.stringify(food)}' class="add-meal-btn bg-green-500 text-white px-3 py-2 rounded-full text-sm font-semibold hover:bg-green-600 transition">Sarapan</button>
                            <button type="button" data-meal="lunch" data-id="${food.id}" data-name="${food.name}" data-image="${food.urlimage || '{{ asset('imgs/default-fruits.jpg') }}'}" data-food='${JSON.stringify(food)}' class="add-meal-btn bg-green-500 text-white px-3 py-2 rounded-full text-sm font-semibold hover:bg-green-600 transition ml-2">Makan Siang</button>
                            <button type="button" data-meal="dinner" data-id="${food.id}" data-name="${food.name}" data-image="${food.urlimage || '{{ asset('imgs/default-fruits.jpg') }}'}" data-food='${JSON.stringify(food)}' class="add-meal-btn bg-green-500 text-white px-3 py-2 rounded-full text-sm font-semibold hover:bg-green-600 transition ml-2">Makan Malam</button>
                        </div>
                    </div>
                    `;
                });
                html += '</div>';
            } else {
                html = '<p class="text-gray-700">Tidak ada rekomendasi ditemukan untuk nutrient ini.</p>';
            }
            container.innerHTML = html;
            // Re-bind add-meal-btn listeners
            document.querySelectorAll('.add-meal-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    const meal = this.dataset.meal;
                    const id = this.dataset.id;
                    const name = this.dataset.name;
                    const image = this.dataset.image;
                    const foodData = JSON.parse(this.dataset.food);
                    addToMeal(e, meal, id, name, image, foodData);
                });
            });
        }

        // Initial load if choosing dynamic recs immediately
        // loadRecommendations();
    </script>
@endsection
