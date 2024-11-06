@extends('layouts.app')

@section('title', 'Operator Dashboard')

@section('content')
@php
    $bidangOptions = [
        7 => 'Pimpinan',
        6 => 'Fungsi IPDS',
        5 => 'Fungsi Nerwilis',
        4 => 'Fungsi Statistik Distribusi',
        3 => 'Fungsi Statistik Produksi',
        2 => 'Fungsi Statistik Sosial',
        1 => 'Bagian Umum',
    ];

    $userBidang = $bidangOptions[Auth::user()->bidang_id] ?? 'Unknown';
@endphp
<div class="w-full p-5 h-full">
    <h2 class="text-gray-600 font-semibold text-2xl">Isikan Capaian Kinerja</h2>
    <p class="text-gray-600 font-light text-lg mt-2">{{ $userBidang }}</p>

    <div class="mt-4 mb-2 flex items-center gap-2">
        <p class="text-gray-800">Pilih Minggu:</p>
        <div class="flex items-center">
            <select name="triwulan_id" id="triwulan" onchange="selectTriwulan()"
                    class="px-4 py-2 pr-4 w-full rounded-md shadow-sm border-gray-300 text-gray-800">
                <option selected value="0">Pilih Minggu</option>
                @foreach ($triwulan as $data)
                    <option value="{{ $data->id }}" @if($data->status === 'close') disabled @endif>
                        {{ $data->triwulan }} {{ $data->status === 'close' ? '(Closed)' : '' }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Form tambah data yang tersembunyi -->
    <div id="formContainer" class="hidden mt-10 bg-white p-5 rounded shadow">
        <form action="{{ route('operator.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="triwulan_id" id="selectedTriwulanId" value="">
            <!-- Field Kriteria Kebersihan -->
            <div>
                <p class="w-full font-semibold border-b-2 py-2 mb-4 text-gray-600">Kriteria Kebersihan</p>
                <div class="flex flex-col gap-y-3 w-full">
                    <div class="mb-5 w-full">
                        <label for="kriteria_kebersihan" class="block mb-2 text-sm font-medium text-gray-900">Kriteria Kebersihan</label>
                        <select name="kriteria_kebersihan" id="kriteria_kebersihan"
                                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                            <option value="" disabled selected>Pilih Kriteria</option>
                            <option value="harum">Harum</option>
                            <option value="wangi">Wangi</option>
                            <option value="bau">Bau</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Field Kedisiplinan -->
            <div class="border-b-2">
                <p class="w-full font-semibold border-b-2 py-2 mb-4 text-gray-600">Kedisiplinan</p>
                <div class="flex gap-x-10 gap-y-3 w-full items-center justify-between">
                    <div class="mb-5 w-1/2">
                        <label for="tanggal" class="block mb-2 text-sm font-medium text-gray-900">Tanggal</label>
                        <input type="date" name="tanggal" id="tanggal"
                               class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                               required />
                    </div>
                    <div class="mb-5 w-1/2">
                        <label for="waktu" class="block mb-2 text-sm font-medium text-gray-900">Waktu</label>
                        <input type="time" name="waktu" id="waktu"
                               class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                               required />
                    </div>
                </div>
            </div>

            <!-- Upload Foto -->
            <div class="border-b-2">
                <p class="w-full font-semibold border-b-2 py-2 mb-4 text-gray-600">Upload Foto</p>
                <div class="flex gap-x-10 gap-y-3 w-full items-center justify-between">
                    <div class="mb-5 w-1/2">
                        <label for="foto_before" class="block mb-2 text-sm font-medium text-gray-900">Foto Before</label>
                        <input type="file" name="foto_before" id="foto_before" accept="image/*"
                               class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                               required />
                    </div>
                    <div class="mb-5 w-1/2">
                        <label for="foto_after" class="block mb-2 text-sm font-medium text-gray-900">Foto After</label>
                        <input type="file" name="foto_after" id="foto_after" accept="image/*"
                               class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                               required />
                    </div>
                </div>
            </div>

            <button type="submit"
                    class="text-white bg-blue-500 hover:bg-blue-600 transition-all focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Simpan</button>
        </form>
    </div>
</div>

<script>
    // JavaScript function to handle triwulan selection
    function selectTriwulan() {
        const triwulanSelect = document.getElementById('triwulan');
        const formContainer = document.getElementById('formContainer');
        const selectedTriwulanId = document.getElementById('selectedTriwulanId');

        if (triwulanSelect.value !== '0') {
            localStorage.setItem('selectedTriwulan', triwulanSelect.value);
            selectedTriwulanId.value = triwulanSelect.value;
            formContainer.classList.remove('hidden');
        } else {
            localStorage.removeItem('selectedTriwulan');
            formContainer.classList.add('hidden');
        }
    }

    // Load previous selection on page load
    function loadTriwulanSelection() {
        const savedTriwulan = localStorage.getItem('selectedTriwulan');
        const triwulanSelect = document.getElementById('triwulan');
        const formContainer = document.getElementById('formContainer');
        const selectedTriwulanId = document.getElementById('selectedTriwulanId');

        if (savedTriwulan) {
            triwulanSelect.value = savedTriwulan;
            selectedTriwulanId.value = savedTriwulan;
            formContainer.classList.remove('hidden');
        }
    }

    document.addEventListener('DOMContentLoaded', loadTriwulanSelection);
</script>
@endsection
