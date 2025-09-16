@extends('layouts.superadmin')

@section('title', $food->name)

@section('content')
    <main class="w-full min-h-screen pb-16">
        <div class="container mx-auto px-4 py-8">
         <!-- Back button -->
            <div class="mb-6">
             <a href="{{ route('superadmin.foods.index') }}" class="text-green-600 hover:underline flex items-center">
                 <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                 </svg>
                 <span class="ml-2 font-medium">Kembali</span>
             </a>
            </div>

         <!-- Food detail card -->
            <div class="rounded-lg overflow-hidden md:flex gap-8">
              <!-- Image -->
              <div class="flex items-center flex-col">
                  <img src="{{ $food->urlimage ?? asset('imgs/default-fruits.jpg') }}" alt="{{ $food->name }}" class="w-80 h-60 object-cover rounded-lg shadow-md">
                  <h1 class="text-xl font-bold text-gray-900 mt-6">{{ $food->name }}</h1>
              </div>
              <!-- Details -->
             <div class="p-8 md:w-1/2 border-2 border-gray-200 rounded-lg">

                  <h1 class="text-2xl font-bold text-gray-900 mb-6 border-b pb-2">Kandungan Nutrisi</h1>

                  <div class="space-y-4 text-gray-700">
                    <div class="flex justify-between border-b pb-2">
                        <span>Energi</span>
                        <span class="font-semibold">{{ $food->calories }} kcal</span>
                    </div>
                    <div class="flex justify-between border-b pb-2">
                        <span>Protein</span>
                        <span class="font-semibold">{{ $food->protein }} gram</span>
                    </div>
                    <div class="flex justify-between border-b pb-2">
                        <span>Karbohidrat</span>
                        <span class="font-semibold">{{ $food->carbohydrates }} gram</span>
                    </div>
                    <div class="flex justify-between border-b pb-2">
                        <span>Lemak</span>
                        <span class="font-semibold">{{ $food->fat }} gram</span>
                    </div>
                    <div class="flex justify-between border-b pb-2">
                        <span>Vitamin C</span>
                        <span class="font-semibold">{{ $food->vitamin_c_mg ?? 0 }} miligram</span>
                    </div>
                    <div class="flex justify-between border-b pb-2">
                        <span>Besi</span>
                        <span class="font-semibold">{{ $food->besi_mg ?? 0 }} miligram</span>
                    </div>
                    <div class="flex justify-between border-b pb-2">
                        <span>Zink</span>
                        <span class="font-semibold">{{ $food->seng_mg ?? 0 }} miligram</span>
                    </div>
                  </div>
            </div>
        </div>
    </main>
@endsection
