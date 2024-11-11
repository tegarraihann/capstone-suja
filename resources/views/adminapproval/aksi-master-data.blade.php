@extends('layouts.app')

@section('title', 'Detail IKU')

@section('content')

    @php
        $day = request()->query('day');
    @endphp

    <div class="w-full p-5 h-full">
        <a class="text-gray-600 font-semibold text-2xl flex items-center gap-3"
            href="{{ url('adminapproval/dashboard') }}">
            <i class="fa-solid fa-angle-left text-lg"></i> Keterangan Master Data
        </a>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg p-5 bg-white mt-5">
            <p class="font-semibold text-lg text-gray-600 mb-3">
                Detail Capaian Kinerja
            </p>
            <p class="font-medium text-gray-600 mb-10">Hari Ke-{{ $day }}</p>

            <!-- Form -->
            <form action="{{ route('adminapproval.update-master-data', $dataKinerja->id) }}" method="POST" class="mx-auto">
                @csrf
                @method('PUT')

                <!-- Kriteria Kebersihan -->
                <div class="mb-5 w-full">
                    <label for="kriteria_kebersihan" class="block mb-2 text-sm font-medium text-gray-900">Kriteria Kebersihan</label>
                    <select name="kriteria_kebersihan" id="kriteria_kebersihan"
                            class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            disabled>
                        <option value="3" {{ old('kriteria_kebersihan', $dataKinerja->kriteria_kebersihan) == 3 ? 'selected' : '' }}>Harum</option>
                        <option value="2" {{ old('kriteria_kebersihan', $dataKinerja->kriteria_kebersihan) == 2 ? 'selected' : '' }}>Wangi</option>
                        <option value="1" {{ old('kriteria_kebersihan', $dataKinerja->kriteria_kebersihan) == 1 ? 'selected' : '' }}>Bau</option>
                    </select>
                </div>

                <!-- Tanggal -->
                <div class="mb-5 w-full">
                    <label for="tanggal" class="block mb-2 text-sm font-medium text-gray-900">Tanggal</label>
                    <input type="date" name="tanggal" id="tanggal"
                           class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                           value="{{ old('tanggal', \Carbon\Carbon::parse($dataKinerja->tanggal)->format('Y-m-d')) }}"
                           readonly>
                </div>

                <!-- Waktu -->
                <div class="mb-5 w-full">
                    <label for="waktu" class="block mb-2 text-sm font-medium text-gray-900">Waktu</label>
                    <input type="time" name="waktu" id="waktu"
                           class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                           value="{{ old('waktu', \Carbon\Carbon::parse($dataKinerja->waktu)->format('H:i')) }}"
                           readonly>
                </div>

                <!-- Foto Before -->
                <div class="mb-5 w-full">
                    <label for="foto_before" class="block mb-2 text-sm font-medium text-gray-900">Foto Sebelum</label>
                    <div class="flex items-center">
                        @if ($dataKinerja->foto_before)
                            <img src="{{ $dataKinerja->foto_before }}" alt="Foto Sebelum" class="max-w-xs max-h-40 object-cover">
                        @else
                            <p class="text-gray-500">Tidak ada foto sebelum</p>
                        @endif
                    </div>
                </div>

                <!-- Foto After -->
                <div class="mb-5 w-full">
                    <label for="foto_after" class="block mb-2 text-sm font-medium text-gray-900">Foto Setelah</label>
                    <div class="flex items-center">
                        @if ($dataKinerja->foto_after)
                            <img src="{{ $dataKinerja->foto_after }}" alt="Foto Setelah" class="max-w-xs max-h-40 object-cover">
                        @else
                            <p class="text-gray-500">Tidak ada foto setelah</p>
                        @endif
                    </div>
                </div>

                <!-- Tombol Approve dan Reject -->
                <div class="flex gap-4">
                    <i
                        class="approve-approval not-italic cursor-pointer text-white bg-green-500 hover:bg-green-600 transition-all focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                        data-id="{{$dataKinerja->id}}"
                        data-text="Capaian Kinerja"
                        data-day="{{$day}}">
                        Disetujui
                    </i>
                    <i
                        class="reject-approval not-italic cursor-pointer text-white bg-red-500 hover:bg-red-600 transition-all focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                        data-id="{{$dataKinerja->id}}"
                        data-text="Capaian Kinerja"
                        data-day="{{$day}}">
                        Ditolak
                    </i>
                </div>
            </form>
        </div>
    </div>

@endsection
