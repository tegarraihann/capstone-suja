@extends('layouts.app')

@section('title', 'Tambah IKU')

@section('content')
<div class="w-full p-5 h-full">
    <a class="text-gray-600 font-semibold text-2xl flex items-center gap-3" href="{{ url('operator/dashboard') }}"><i
            class="fa-solid fa-angle-left text-lg"></i> Tambah Master Data</a>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg p-5 bg-white mt-5">
        <p class="font-medium text-gray-600 mb-3 ">Jumlah pengunjung eksternal yang mengakses data dan informasi
            statistik melalui website BPS</p>
        <p class="font-medium text-gray-600 mb-10">Triwulan I</p>
        <form class="mx-auto" method="post">
            {{ csrf_field() }}
            <div class="">
                <p class="w-full font-medium mb-4">Perjanjian Kinerja</p>
                <div class="flex gap-x-10 gap-y-3 w-full items-center justify-between">
                    <div class="mb-5 w-1/2">
                        <label for="nama" class="block mb-2 text-sm font-medium text-gray-900 ">Target komulatif</label>
                        <input type="text" name="name" id="nama"
                            class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                            placeholder="Masukkan target komulatif" />
                    </div>
                    <div class="mb-5 w-1/2">
                        <label for="nama" class="block mb-2 text-sm font-medium text-gray-900 ">Realisasi
                            komulatif</label>
                        <input type="text" name="name" id="nama"
                            class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                            placeholder="Masukkan realisasi komulatif" />
                    </div>
                </div>
            </div>
            <div class="">
                <p class="w-full font-medium mb-4">Capaian Kinerja</p>
                <div class="flex gap-x-10 gap-y-3 w-full items-center justify-between">
                    <div class="mb-5 w-1/2">
                        <label for="nama" class="block mb-2 text-sm font-medium text-gray-900 ">Komulatif</label>
                        <input type="text" name="name" id="nama"
                            class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                            placeholder="Masukkan target komulatif" />
                    </div>
                    <div class="mb-5 w-1/2">
                        <label for="nama" class="block mb-2 text-sm font-medium text-gray-900 ">Terhadap target
                            setahun</label>
                        <input type="text" name="name" id="nama"
                            class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                            placeholder="Masukkan realisasi komulatif" />
                    </div>
                </div>
            </div>
            <div class="">
                <p class="w-full font-medium mb-4">Analisis Pencapaian Kinerja di Triwulan Berjalan</p>
                <div class="grid grid-cols-2 gap-x-10 gap-y-3 w-full items-center justify-between">
                    <div class="mb-5 w-full">
                        <label for="nama" class="block mb-2 text-sm font-medium text-gray-900 ">Kendala</label>
                        <textarea type="text" name="name" id="nama"
                            class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                            placeholder="Masukkan target komulatif" rows="6"></textarea>
                    </div>
                    <div class="mb-5 w-full">
                        <label for="nama" class="block mb-2 text-sm font-medium text-gray-900 ">Solusi</label>
                        <textarea type="text" name="name" id="nama"
                            class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                            placeholder="Masukkan realisasi komulatif" rows="6"></textarea>
                    </div>
                    <div class="mb-5 w-full">
                        <label for="nama" class="block mb-2 text-sm font-medium text-gray-900 ">Rencana tindak
                            lanjut</label>
                        <textarea type="text" name="name" id="nama"
                            class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                            placeholder="Masukkan realisasi komulatif" rows="6"></textarea>
                    </div>
                    <div class="mb-5 w-full">
                        <label for="nama" class="block mb-2 text-sm font-medium text-gray-900 ">PIC tindak
                            lanjut</label>
                        <textarea type="text" name="name" id="nama"
                            class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                            placeholder="Masukkan realisasi komulatif" rows="6"></textarea>
                    </div>
                    <div class="mb-5 w-full">
                        <label for="nama" class="block mb-2 text-sm font-medium text-gray-900 ">Batas waktu tindak
                            lanjut</label>
                        <input type="date" name="name" id="nama"
                            class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                            placeholder="Masukkan realisasi komulatif" rows="6"></input>
                    </div>
                </div>
            </div>

            <button type="submit"
                class="text-white bg-blue-500 hover:bg-blue-600 transition-all focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Simpan</button>
        </form>
    </div>

</div>
@endsection