@extends('layouts.app')

@section('title', 'Operator dashboard')

@section('content')
<div class="bg-gray-50 w-full p-5 h-full">
    <div class="flex w-full justify-between items-center gap-4">
        <div
            class="bg-white w-[350px] h-[250px] shadow-md flex flex-col items-center justify-center p-5 rounded-md relative overflow-hidden">
            <p class="text-gray-500 text-sm self-start">AKUN BARU</p>
            <div class="flex justify-center items-center gap-2 flex-col w-full h-4/5">
                <div class="flex items-center gap-4">
                    <p class="font-medium text-6xl">159</p>
                </div>
                <div class="flex items-center gap-2 text-green-400">
                    <i class="fa-solid fa-angle-up text-2xl "></i>
                    <p class="font-medium text-3xl">15%</p>
                </div>
                <p class="text-sm text-gray-500 mt-5">Dalam 30 hari terakhir</p>
            </div>
            <div class="absolute h-[3px] w-full bg-primary-500 bottom-0">

            </div>
        </div>
        <div
            class="bg-white w-[350px] h-[250px] shadow-md flex flex-col items-center justify-center p-5 rounded-md relative overflow-hidden">
            <p class="text-gray-500 text-sm self-start">AKUN BARU</p>
            <div class="flex justify-center items-center gap-2 flex-col w-full h-4/5">
                <div class="flex items-center gap-4">
                    <p class="font-medium text-6xl">159</p>
                </div>
                <div class="flex items-center gap-2 text-green-400">
                    <i class="fa-solid fa-angle-up text-2xl "></i>
                    <p class="font-medium text-3xl">15%</p>
                </div>
                <p class="text-sm text-gray-500 mt-5">Dalam 30 hari terakhir</p>
            </div>
            <div class="absolute h-[3px] w-full bg-red-500 bottom-0">

            </div>
        </div>
        <div
            class="bg-white w-[350px] h-[250px] shadow-md flex flex-col items-center justify-center p-5 rounded-md relative overflow-hidden">
            <p class="text-gray-500 text-sm self-start">AKUN BARU</p>
            <div class="flex justify-center items-center gap-2 flex-col w-full h-4/5">
                <div class="flex items-center gap-4">
                    <p class="font-medium text-6xl">159</p>
                </div>
                <div class="flex items-center gap-2 text-green-400">
                    <i class="fa-solid fa-angle-up text-2xl "></i>
                    <p class="font-medium text-3xl">15%</p>
                </div>
                <p class="text-sm text-gray-500 mt-5">Dalam 30 hari terakhir</p>
            </div>
            <div class="absolute h-[3px] w-full bg-green-500 bottom-0">

            </div>
        </div>
        <div
            class="bg-white w-[350px] h-[250px] shadow-md flex flex-col items-center justify-center p-5 rounded-md relative overflow-hidden">
            <p class="text-gray-500 text-sm self-start">AKUN BARU</p>
            <div class="flex justify-center items-center gap-2 flex-col w-full h-4/5">
                <div class="flex items-center gap-4">
                    <p class="font-medium text-6xl">159</p>
                </div>
                <div class="flex items-center gap-2 text-green-400">
                    <i class="fa-solid fa-angle-up text-2xl "></i>
                    <p class="font-medium text-3xl">15%</p>
                </div>
                <p class="text-sm text-gray-500 mt-5">Dalam 30 hari terakhir</p>
            </div>
            <div class="absolute h-[3px] w-full bg-orange-500 bottom-0">

            </div>
        </div>
    </div>
    <div class="w-full flex justify-end mt-10">
        <button
            class="flex items-center gap-2 bg-blue-50 text-blue-600 py-3 px-6 rounded-md font-medium hover:bg-blue-200 transition-all">
            Tambah Akun
            <i class="fa solid fa-plus"></i>
        </button>
    </div>
    <table class="table-fixed mt-10 w-full">
        <thead>
            <tr>
                <th>Song</th>
                <th>Artist</th>
                <th>Year</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>The Sliding Mr. Bones (Next Stop, Pottersville)</td>
                <td>Malcolm Lockyer</td>
                <td>1961</td>
            </tr>
            <tr>
                <td>Witchy Woman</td>
                <td>The Eagles</td>
                <td>1972</td>
            </tr>
            <tr>
                <td>Shining Star</td>
                <td>Earth, Wind, and Fire</td>
                <td>1975</td>
            </tr>
        </tbody>
    </table>
</div>
@endsection