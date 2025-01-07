@extends('layouts.app')

@section('title', 'Edit IKU')

@section('content')
    <div class="w-full p-5 h-full">
        <h2 class="text-gray-600 font-semibold text-2xl">Edit Capaian Kinerja</h2>

        <div class="relative overflow-x-auto shadow-md sm:rounded-lg p-5 bg-white mt-5">
            <form action="{{ url('operator/update-master-data/' . $dataKinerja->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-5">
                    <label for="kriteria_kebersihan" class="block mb-2 text-sm font-medium text-gray-900">Kriteria Kebersihan</label>
                    <select name="kriteria_kebersihan" id="kriteria_kebersihan"
                        class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required>
                        <option value="harum" {{ $dataKinerja->perjanjian_kinerja_target_kumulatif == 3 ? 'selected' : '' }}>Harum</option>
                        <option value="wangi" {{ $dataKinerja->perjanjian_kinerja_target_kumulatif == 2 ? 'selected' : '' }}>Wangi</option>
                        <option value="bau" {{ $dataKinerja->perjanjian_kinerja_target_kumulatif == 1 ? 'selected' : '' }}>Bau</option>
                    </select>
                </div>

                <div class="mb-5">
                    <label for="tanggal" class="block mb-2 text-sm font-medium text-gray-900">Tanggal</label>
                    <input type="date" name="tanggal" id="tanggal" value="{{ \Carbon\Carbon::parse($dataKinerja->tanggal)->format('Y-m-d') }}"
                        class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required />
                </div>

                <div class="mb-5">
                    <label for="waktu" class="block mb-2 text-sm font-medium text-gray-900">Waktu</label>
                    <input type="time" name="waktu" id="waktu" value="{{ \Carbon\Carbon::parse($dataKinerja->waktu)->format('H:i') }}"
                        class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" required />
                </div>

                <div class="mb-5">
                    <label for="foto_before" class="block mb-2 text-sm font-medium text-gray-900">Foto Before</label>
                    <input type="file" name="foto_before" id="foto_before" accept="image/*"
                        class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" />
                    <img src="{{ asset($dataKinerja->foto_before) }}" alt="Foto Before" class="mt-2 w-32">
                </div>

                <div class="mb-5">
                    <label for="foto_after" class="block mb-2 text-sm font-medium text-gray-900">Foto After</label>
                    <input type="file" name="foto_after" id="foto_after" accept="image/*"
                        class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" />
                    <img src="{{ asset($dataKinerja->foto_after) }}" alt="Foto After" class="mt-2 w-32">
                </div>

                <button type="submit"
                    class="text-white bg-blue-500 hover:bg-blue-600 transition-all focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Simpan Perubahan</button>
            </form>
        </div>
    </div>
@endsection
