@extends('layouts.superadmin')

@section('title', 'Akses Ditolak')

@section('content')
<div class="flex flex-col items-center justify-center h-full space-y-6 p-6">
    <img src="{{ asset('icons/Akses-Ditolak.svg') }}" alt="Akses Ditolak" class="w-48 h-auto">
    <h1 class="text-4xl font-bold text-gray-800">Akses Ditolak</h1>
    <p class="text-center text-lg text-gray-600">Maaf, Anda tidak diizinkan melihat halaman ini.</p>
    <!-- <a href="{{ url('/') }}" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded">Kembali ke Beranda</a> -->
</div>
@endsection
