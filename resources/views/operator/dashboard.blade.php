@extends('layouts.app')

@section('title', 'Operator dashboard')

@section('content')
    @php
        function getQuarter()
        {
            $month = date('n');
            if ($month >= 1 && $month <= 3) {
                return '1';
            } elseif ($month >= 4 && $month <= 6) {
                return '2';
            } elseif ($month >= 7 && $month <= 9) {
                return '3';
            } else {
                return '4';
            }
        }

        $bidangOptions = [
            7 => 'Pimpinan',
            6 => 'Fungsi IPDS',
            5 => 'Fungsi Nerwilis',
            4 => 'Fungsi Statistik Distribusi',
            3 => 'Fungsi Statistik Produksi',
            2 => 'Fungsi Statistik Sosial',
            1 => 'Bagian Umum',
        ];

        $triwulan = getQuarter();
        $userBidang = $bidangOptions[Auth::user()->bidang_id] ?? 'Unknown';
    @endphp
    <div class="w-full p-5 h-full">
        <h2 class="text-gray-600 font-semibold text-2xl">Isikan Capaian Kinerja Triwulan Ke-{{ $triwulan }}</h2>
        <p class="text-gray-600 font-light text-lg mt-2">{{ $userBidang }}</p>
        <div class="mt-10 bg-white p-5 rounded shadow">
            <ul class="flex flex-col gap-4">
                <li class="">
                    <div class="parent flex items-center gap-5">
                        <i
                            class="fa-solid btn fa-plus cursor-pointer p-2 rounded-md text-gray-800 w-auto h-auto bg-gray-100 hover:bg-gray-200 block"></i>
                        <div
                            class="p-4 rounded-md border-blue-300 border-2 flex justify-between w-full items-center bg-blue-50">
                            <p>Indikator Kinerja Utama</p>
                        </div>
                    </div>
                    <ul class="child hidden ml-[14px] flex flex-col border-orange-300 border-l-2">
                        @foreach ($iku as $tujuan)
                            @if (Auth::user()->bidang_id !== 1 && $tujuan->id !== 5)
                                <li class="ml-7 mt-4">
                                    <div class="parent flex items-center gap-5">
                                        <i
                                            class="fa-solid btn fa-plus cursor-pointer p-2 rounded-md text-gray-800 w-auto h-auto bg-gray-100 hover:bg-gray-200 block"></i>
                                        <div
                                            class="p-4 rounded-md border-orange-300 border-2 flex justify-between w-full items-center bg-orange-50">
                                            <p class="block w-[90%] "><span class="">[ TUJUAN ]</span>
                                                {{ $tujuan->tujuan }}</p>
                                        </div>
                                    </div>
                                    <ul class="child hidden ml-[14px] flex flex-col border-green-300 border-l-2">
                                        @foreach ($tujuan->sasaran as $sasaran)
                                            <li class="ml-7 mt-4">
                                                <div class="parent flex items-center gap-5">
                                                    <i
                                                        class="fa-solid btn fa-plus cursor-pointer p-2 rounded-md text-gray-800 w-auto h-auto bg-gray-100 hover:bg-gray-200 block"></i>
                                                    <div
                                                        class="p-4 rounded-md border-green-300 border-2 flex justify-between w-full items-center bg-green-50">
                                                        <p class="block w-[90%] "><span class="">[ SASARAN ]</span>
                                                            {{ $sasaran->sasaran }}
                                                        </p>
                                                    </div>
                                                </div>
                                                @if ($sasaran->indikator->isNotEmpty())
                                                    <ul
                                                        class="child hidden ml-[14px] flex flex-col border-yellow-300 border-l-2">
                                                        @foreach ($sasaran->indikator as $indikator)
                                                            <li class="ml-7 mt-4">
                                                                @if ($indikator->indikator_penunjang()->exists() || $indikator->sub_indikator->isNotEmpty())
                                                                    <div class="parent flex items-center gap-5">
                                                                        <i
                                                                            class="fa-solid btn fa-plus cursor-pointer p-2 rounded-md text-gray-800 w-auto h-auto bg-gray-100 hover:bg-gray-200 block"></i>
                                                                        <div
                                                                            class="p-4 rounded-md border-yellow-300 border-2 flex justify-between w-full items-center bg-yellow-50">
                                                                            <p class="block w-[90%] "><span class="">[
                                                                                    INDIKATOR ]</span>
                                                                                {{ $indikator->indikator }}</p>
                                                                        </div>
                                                                    </div>
                                                                    @if ($indikator->indikator_penunjang()->exists())
                                                                        <ul
                                                                            class="child hidden ml-[14px] flex flex-col gap-4 border-purple-300 border-l-2">
                                                                            @foreach ($indikator->indikator_penunjang as $indikator_penunjang)
                                                                                <li class="ml-7 mt-4">
                                                                                    @if ($indikator_penunjang->sub_indikator->isNotEmpty())
                                                                                        <div
                                                                                            class="parent flex items-center gap-5">
                                                                                            <i
                                                                                                class="fa-solid btn fa-plus cursor-pointer p-2 rounded-md text-gray-800 w-auto h-auto bg-gray-100 hover:bg-gray-200 block"></i>
                                                                                            <div
                                                                                                class="p-4 rounded-md border-purple-300 border-2 flex justify-between w-full items-center bg-purple-50">
                                                                                                <p class="block w-[90%] ">
                                                                                                    <span class="">[
                                                                                                        INDIKATOR PENUNJANG
                                                                                                        ]</span>
                                                                                                    {{ $indikator_penunjang->indikator_penunjang }}
                                                                                                </p>
                                                                                            </div>
                                                                                        </div>
                                                                                        <ul
                                                                                            class="child hidden ml-[14px] flex flex-col gap-4 border-cyan-300 border-l-2">
                                                                                            @foreach ($indikator_penunjang->sub_indikator as $sub_indikator)
                                                                                                @if ($sub_indikator->bidang_id === null || $sub_indikator->bidang_id === Auth::user()->bidang_id)
                                                                                                    <li class="ml-16 mt-4">
                                                                                                        <div
                                                                                                            class="parent flex items-center gap-5">
                                                                                                            <div
                                                                                                                class="p-4 rounded-md border-cyan-300 border-2 flex justify-between w-full items-center bg-cyan-50">
                                                                                                                <p><span
                                                                                                                        class="">[
                                                                                                                        SUB
                                                                                                                        INDIKATOR
                                                                                                                        ]</span>
                                                                                                                    {{ $sub_indikator->sub_indikator }}
                                                                                                                </p>
                                                                                                                @if (in_array($sub_indikator->id, $existingDataSubIndikator))
                                                                                                                    <div
                                                                                                                        class="flex flex-col items-center text-center">
                                                                                                                        <span
                                                                                                                            class="w-full text-sm whitespace-nowrap bg-gradient-to-r from-red-500 to-red-400 py-1 px-3 rounded-t-md text-white">
                                                                                                                            Data
                                                                                                                            sudah
                                                                                                                            diisi
                                                                                                                        </span>
                                                                                                                        <a href=""
                                                                                                                            class="w-full text-sm whitespace-nowrap bg-gradient-to-r from-blue-500 to-blue-400 py-1 px-3 rounded-b-md text-white">
                                                                                                                            Edit
                                                                                                                            data
                                                                                                                        </a>
                                                                                                                    </div>
                                                                                                                @else
                                                                                                                    <a
                                                                                                                        href="{{ url('') }}">
                                                                                                                        <button
                                                                                                                            class="flex items-center gap-2 bg-gradient-to-r from-blue-500 to-blue-400 hover:bg-blue-600 text-white py-2 px-3 rounded-md font-medium transition-all text-sm whitespace-nowrap">
                                                                                                                            Input
                                                                                                                            data
                                                                                                                        </button>
                                                                                                                    </a>
                                                                                                                @endif
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </li>
                                                                                                @endif
                                                                                            @endforeach
                                                                                        </ul>
                                                                                    @else
                                                                                        <div
                                                                                            class="parent flex items-center gap-5">
                                                                                            <div
                                                                                                class="ml-12 p-4 rounded-md border-purple-300 border-2 flex justify-between w-full items-center bg-purple-50">
                                                                                                <p><span class="">[
                                                                                                        INDIKATOR PENUNJANG
                                                                                                        ]</span>
                                                                                                    {{ $indikator_penunjang->indikator_penunjang }}
                                                                                                </p>
                                                                                                @if (in_array($sub_indikator->id, $existingDataIndikatorPenunjang))
                                                                                                    <div
                                                                                                        class="flex flex-col items-center text-center">
                                                                                                        <span
                                                                                                            class="w-full text-sm whitespace-nowrap bg-gradient-to-r from-red-500 to-red-400 py-1 px-3 rounded-t-md text-white">
                                                                                                            Data
                                                                                                            sudah
                                                                                                            diisi
                                                                                                        </span>
                                                                                                        <a href=""
                                                                                                            class="w-full text-sm whitespace-nowrap bg-gradient-to-r from-blue-500 to-blue-400 py-1 px-3 rounded-b-md text-white">
                                                                                                            Edit
                                                                                                            data
                                                                                                        </a>
                                                                                                    </div>
                                                                                                @else
                                                                                                    <a
                                                                                                        href="{{ url('') }}">
                                                                                                        <button
                                                                                                            class="flex items-center gap-2 bg-gradient-to-r from-blue-500 to-blue-400 hover:bg-blue-600 text-white py-2 px-3 rounded-md font-medium transition-all text-sm whitespace-nowrap">
                                                                                                            Input
                                                                                                            data
                                                                                                        </button>
                                                                                                    </a>
                                                                                                @endif
                                                                                            </div>
                                                                                        </div>
                                                                                    @endif
                                                                                </li>
                                                                            @endforeach
                                                                        </ul>
                                                                    @else
                                                                        <ul
                                                                            class="child hidden ml-[14px] flex flex-col gap-4 border-cyan-300 border-l-2">
                                                                            @foreach ($indikator->sub_indikator as $sub_indikator)
                                                                                <li class="ml-16 mt-4">
                                                                                    <div
                                                                                        class="parent flex items-center gap-5">
                                                                                        <div
                                                                                            class="p-4 rounded-md border-cyan-300 border-2 flex justify-between w-full items-center bg-cyan-50">
                                                                                            <p><span class="">[ SUB
                                                                                                    INDIKATOR ]</span>
                                                                                                {{ $sub_indikator->sub_indikator }}
                                                                                            </p>
                                                                                            @if (in_array($sub_indikator->id, $existingDataSubIndikator))
                                                                                                <div
                                                                                                    class="flex flex-col items-center text-center">
                                                                                                    <span
                                                                                                        class="w-full text-sm whitespace-nowrap bg-gradient-to-r from-red-500 to-red-400 py-1 px-3 rounded-t-md text-white">
                                                                                                        Data
                                                                                                        sudah
                                                                                                        diisi
                                                                                                    </span>
                                                                                                    <a href=""
                                                                                                        class="w-full text-sm whitespace-nowrap bg-gradient-to-r from-blue-500 to-blue-400 py-1 px-3 rounded-b-md text-white">
                                                                                                        Edit
                                                                                                        data
                                                                                                    </a>
                                                                                                </div>
                                                                                            @else
                                                                                                <a
                                                                                                    href="{{ url('') }}">
                                                                                                    <button
                                                                                                        class="flex items-center gap-2 bg-gradient-to-r from-blue-500 to-blue-400 hover:bg-blue-600 text-white py-2 px-3 rounded-md font-medium transition-all text-sm whitespace-nowrap">
                                                                                                        Input
                                                                                                        data
                                                                                                    </button>
                                                                                                </a>
                                                                                            @endif
                                                                                        </div>
                                                                                    </div>
                                                                                </li>
                                                                            @endforeach
                                                                        </ul>
                                                                    @endif
                                                                @else
                                                                    <div class="parent flex items-center gap-5">
                                                                        <div
                                                                            class="ml-12 p-4 rounded-md border-yellow-300 border-2 flex justify-between w-full items-center bg-yellow-50">
                                                                            <p><span class="">[ INDIKATOR ]</span>
                                                                                {{ $indikator->indikator }}</p>
                                                                            @if (in_array($sub_indikator->id, $existingDataIndikator))
                                                                                <div
                                                                                    class="flex flex-col items-center text-center">
                                                                                    <span
                                                                                        class="w-full text-sm whitespace-nowrap bg-gradient-to-r from-red-500 to-red-400 py-1 px-3 rounded-t-md text-white">
                                                                                        Data
                                                                                        sudah
                                                                                        diisi
                                                                                    </span>
                                                                                    <a href=""
                                                                                        class="w-full text-sm whitespace-nowrap bg-gradient-to-r from-blue-500 to-blue-400 py-1 px-3 rounded-b-md text-white">
                                                                                        Edit
                                                                                        data
                                                                                    </a>
                                                                                </div>
                                                                            @else
                                                                                <a href="{{ url('') }}">
                                                                                    <button
                                                                                        class="flex items-center gap-2 bg-gradient-to-r from-blue-500 to-blue-400 hover:bg-blue-600 text-white py-2 px-3 rounded-md font-medium transition-all text-sm whitespace-nowrap">
                                                                                        Input
                                                                                        data
                                                                                    </button>
                                                                                </a>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @elseif (Auth::user()->bidang_id === 1 && $tujuan->id === 5)
                                <li class="ml-7 mt-4">
                                    <div class="parent flex items-center gap-5">
                                        <i
                                            class="fa-solid btn fa-plus cursor-pointer p-2 rounded-md text-gray-800 w-auto h-auto bg-gray-100 hover:bg-gray-200 block"></i>
                                        <div
                                            class="p-4 rounded-md border-orange-300 border-2 flex justify-between w-full items-center bg-orange-50">
                                            <p class="block w-[90%] "><span class="">[ TUJUAN ]</span>
                                                {{ $tujuan->tujuan }}</p>
                                        </div>
                                    </div>
                                    <ul class="child hidden ml-[14px] flex flex-col border-green-300 border-l-2">
                                        @foreach ($tujuan->sasaran as $sasaran)
                                            <li class="ml-7 mt-4">
                                                <div class="parent flex items-center gap-5">
                                                    <i
                                                        class="fa-solid btn fa-plus cursor-pointer p-2 rounded-md text-gray-800 w-auto h-auto bg-gray-100 hover:bg-gray-200 block"></i>
                                                    <div
                                                        class="p-4 rounded-md border-green-300 border-2 flex justify-between w-full items-center bg-green-50">
                                                        <p class="block w-[90%] "><span class="">[ SASARAN
                                                                ]</span>
                                                            {{ $sasaran->sasaran }}
                                                        </p>
                                                    </div>
                                                </div>
                                                @if ($sasaran->indikator->isNotEmpty())
                                                    <ul
                                                        class="child hidden ml-[14px] flex flex-col border-yellow-300 border-l-2">
                                                        @foreach ($sasaran->indikator as $indikator)
                                                            <li class="ml-7 mt-4">
                                                                @if ($indikator->indikator_penunjang()->exists() || $indikator->sub_indikator->isNotEmpty())
                                                                    <div class="parent flex items-center gap-5">
                                                                        <i
                                                                            class="fa-solid btn fa-plus cursor-pointer p-2 rounded-md text-gray-800 w-auto h-auto bg-gray-100 hover:bg-gray-200 block"></i>
                                                                        <div
                                                                            class="p-4 rounded-md border-yellow-300 border-2 flex justify-between w-full items-center bg-yellow-50">
                                                                            <p class="block w-[90%] "><span class="">[
                                                                                    INDIKATOR ]</span>
                                                                                {{ $indikator->indikator }}</p>
                                                                        </div>
                                                                    </div>
                                                                    @if ($indikator->indikator_penunjang()->exists())
                                                                        <ul
                                                                            class="child hidden ml-[14px] flex flex-col gap-4 border-purple-300 border-l-2">
                                                                            @foreach ($indikator->indikator_penunjang as $indikator_penunjang)
                                                                                <li class="ml-7 mt-4">
                                                                                    @if ($indikator_penunjang->sub_indikator->isNotEmpty())
                                                                                        <div
                                                                                            class="parent flex items-center gap-5">
                                                                                            <i
                                                                                                class="fa-solid btn fa-plus cursor-pointer p-2 rounded-md text-gray-800 w-auto h-auto bg-gray-100 hover:bg-gray-200 block"></i>
                                                                                            <div
                                                                                                class="p-4 rounded-md border-purple-300 border-2 flex justify-between w-full items-center bg-purple-50">
                                                                                                <p class="block w-[90%] ">
                                                                                                    <span class="">[
                                                                                                        INDIKATOR
                                                                                                        PENUNJANG
                                                                                                        ]</span>
                                                                                                    {{ $indikator_penunjang->indikator_penunjang }}
                                                                                                </p>
                                                                                            </div>
                                                                                        </div>
                                                                                        <ul
                                                                                            class="child hidden ml-[14px] flex flex-col gap-4 border-cyan-300 border-l-2">
                                                                                            @foreach ($indikator_penunjang->sub_indikator as $sub_indikator)
                                                                                                @if ($sub_indikator->bidang_id === null || $sub_indikator->bidang_id === Auth::user()->bidang_id)
                                                                                                    <li class="ml-16 mt-4">
                                                                                                        <div
                                                                                                            class="parent flex items-center gap-5">
                                                                                                            <div
                                                                                                                class="p-4 rounded-md border-cyan-300 border-2 flex justify-between w-full items-center bg-cyan-50">
                                                                                                                <p><span
                                                                                                                        class="">[
                                                                                                                        SUB
                                                                                                                        INDIKATOR
                                                                                                                        ]</span>
                                                                                                                    {{ $sub_indikator->sub_indikator }}
                                                                                                                </p>
                                                                                                                @if (in_array($sub_indikator->id, $existingDataSubIndikator))
                                                                                                                    <div
                                                                                                                        class="flex flex-col items-center text-center">
                                                                                                                        <span
                                                                                                                            class="w-full text-sm whitespace-nowrap bg-gradient-to-r from-red-500 to-red-400 py-1 px-3 rounded-t-md text-white">
                                                                                                                            Data
                                                                                                                            sudah
                                                                                                                            diisi
                                                                                                                        </span>
                                                                                                                        <a href=""
                                                                                                                            class="w-full text-sm whitespace-nowrap bg-gradient-to-r from-blue-500 to-blue-400 py-1 px-3 rounded-b-md text-white">
                                                                                                                            Edit
                                                                                                                            data
                                                                                                                        </a>
                                                                                                                    </div>
                                                                                                                @else
                                                                                                                    <a
                                                                                                                        href="{{ url('') }}">
                                                                                                                        <button
                                                                                                                            class="flex items-center gap-2 bg-gradient-to-r from-blue-500 to-blue-400 hover:bg-blue-600 text-white py-2 px-3 rounded-md font-medium transition-all text-sm whitespace-nowrap">
                                                                                                                            Input
                                                                                                                            data
                                                                                                                        </button>
                                                                                                                    </a>
                                                                                                                @endif
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </li>
                                                                                                @endif
                                                                                            @endforeach
                                                                                        </ul>
                                                                                    @else
                                                                                        <div
                                                                                            class="parent flex items-center gap-5">
                                                                                            <div
                                                                                                class="ml-12 p-4 rounded-md border-purple-300 border-2 flex justify-between w-full items-center bg-purple-50">
                                                                                                <p><span class="">[
                                                                                                        INDIKATOR
                                                                                                        PENUNJANG
                                                                                                        ]</span>
                                                                                                    {{ $indikator_penunjang->indikator_penunjang }}
                                                                                                </p>
                                                                                                @if (in_array($sub_indikator->id, $existingDataIndikatorPenunjang))
                                                                                                    <div
                                                                                                        class="flex flex-col items-center text-center">
                                                                                                        <span
                                                                                                            class="w-full text-sm whitespace-nowrap bg-gradient-to-r from-red-500 to-red-400 py-1 px-3 rounded-t-md text-white">
                                                                                                            Data
                                                                                                            sudah
                                                                                                            diisi
                                                                                                        </span>
                                                                                                        <a href=""
                                                                                                            class="w-full text-sm whitespace-nowrap bg-gradient-to-r from-blue-500 to-blue-400 py-1 px-3 rounded-b-md text-white">
                                                                                                            Edit
                                                                                                            data
                                                                                                        </a>
                                                                                                    </div>
                                                                                                @else
                                                                                                    <a
                                                                                                        href="{{ url('') }}">
                                                                                                        <button
                                                                                                            class="flex items-center gap-2 bg-gradient-to-r from-blue-500 to-blue-400 hover:bg-blue-600 text-white py-2 px-3 rounded-md font-medium transition-all text-sm whitespace-nowrap">
                                                                                                            Input
                                                                                                            data
                                                                                                        </button>
                                                                                                    </a>
                                                                                                @endif
                                                                                            </div>
                                                                                        </div>
                                                                                    @endif
                                                                                </li>
                                                                            @endforeach
                                                                        </ul>
                                                                    @else
                                                                        <ul
                                                                            class="child hidden ml-[14px] flex flex-col gap-4 border-cyan-300 border-l-2">
                                                                            @foreach ($indikator->sub_indikator as $sub_indikator)
                                                                                <li class="ml-16 mt-4">
                                                                                    <div
                                                                                        class="parent flex items-center gap-5">
                                                                                        <div
                                                                                            class="p-4 rounded-md border-cyan-300 border-2 flex justify-between w-full items-center bg-cyan-50">
                                                                                            <p><span class="">[
                                                                                                    SUB
                                                                                                    INDIKATOR ]</span>
                                                                                                {{ $sub_indikator->sub_indikator }}
                                                                                            </p>
                                                                                            @if (in_array($sub_indikator->id, $existingDataSubIndikator))
                                                                                                <div
                                                                                                    class="flex flex-col items-center text-center">
                                                                                                    <span
                                                                                                        class="w-full text-sm whitespace-nowrap bg-gradient-to-r from-red-500 to-red-400 py-1 px-3 rounded-t-md text-white">
                                                                                                        Data
                                                                                                        sudah
                                                                                                        diisi
                                                                                                    </span>
                                                                                                    <a href=""
                                                                                                        class="w-full text-sm whitespace-nowrap bg-gradient-to-r from-blue-500 to-blue-400 py-1 px-3 rounded-b-md text-white">
                                                                                                        Edit
                                                                                                        data
                                                                                                    </a>
                                                                                                </div>
                                                                                            @else
                                                                                                <a
                                                                                                    href="{{ url('') }}">
                                                                                                    <button
                                                                                                        class="flex items-center gap-2 bg-gradient-to-r from-blue-500 to-blue-400 hover:bg-blue-600 text-white py-2 px-3 rounded-md font-medium transition-all text-sm whitespace-nowrap">
                                                                                                        Input
                                                                                                        data
                                                                                                    </button>
                                                                                                </a>
                                                                                            @endif
                                                                                        </div>
                                                                                    </div>
                                                                                </li>
                                                                            @endforeach
                                                                        </ul>
                                                                    @endif
                                                                @else
                                                                    <div class="parent flex items-center gap-5">
                                                                        <div
                                                                            class="ml-12 p-4 rounded-md border-yellow-300 border-2 flex justify-between w-full items-center bg-yellow-50">
                                                                            <p><span class="">[ INDIKATOR
                                                                                    ]</span>
                                                                                {{ $indikator->indikator }}</p>
                                                                            @if (in_array($sub_indikator->id, $existingDataIndikator))
                                                                                <div
                                                                                    class="flex flex-col items-center text-center">
                                                                                    <span
                                                                                        class="w-full text-sm whitespace-nowrap bg-gradient-to-r from-red-500 to-red-400 py-1 px-3 rounded-t-md text-white">
                                                                                        Data
                                                                                        sudah
                                                                                        diisi
                                                                                    </span>
                                                                                    <a href=""
                                                                                        class="w-full text-sm whitespace-nowrap bg-gradient-to-r from-blue-500 to-blue-400 py-1 px-3 rounded-b-md text-white">
                                                                                        Edit
                                                                                        data
                                                                                    </a>
                                                                                </div>
                                                                            @else
                                                                                <a href="{{ url('') }}">
                                                                                    <button
                                                                                        class="flex items-center gap-2 bg-gradient-to-r from-blue-500 to-blue-400 hover:bg-blue-600 text-white py-2 px-3 rounded-md font-medium transition-all text-sm whitespace-nowrap">
                                                                                        Input
                                                                                        data
                                                                                    </button>
                                                                                </a>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </li>
                <li class="">
                    <div class="parent flex items-center gap-5">
                        <i
                            class="fa-solid btn fa-plus cursor-pointer p-2 rounded-md text-gray-800 w-auto h-auto bg-gray-100 hover:bg-gray-200 block"></i>
                        <div
                            class="p-4 rounded-md border-blue-300 border-2 flex justify-between w-full items-center bg-blue-50">
                            <p>Indikator Kinerja Utama Suplemen</p>
                        </div>
                    </div>
                    <ul class="child hidden ml-[14px] flex flex-col border-orange-300 border-l-2">
                        @foreach ($iku_sup as $tujuan)
                            <li class="ml-7 mt-4">
                                <div class="parent flex items-center gap-5">
                                    <i
                                        class="fa-solid btn fa-plus cursor-pointer p-2 rounded-md text-gray-800 w-auto h-auto bg-gray-100 hover:bg-gray-200 block"></i>
                                    <div
                                        class="p-4 rounded-md border-orange-300 border-2 flex justify-between w-full items-center bg-orange-50">
                                        <p class="block w-[90%] "><span class="">[ TUJUAN ]</span>
                                            {{ $tujuan->tujuan }}</p>
                                    </div>
                                </div>
                                <ul class="child hidden ml-[14px] flex flex-col border-green-300 border-l-2">
                                    @foreach ($tujuan->sasaran as $sasaran)
                                        <li class="ml-7 mt-4">
                                            <div class="parent flex items-center gap-5">
                                                <i
                                                    class="fa-solid btn fa-plus cursor-pointer p-2 rounded-md text-gray-800 w-auto h-auto bg-gray-100 hover:bg-gray-200 block"></i>
                                                <div
                                                    class="p-4 rounded-md border-green-300 border-2 flex justify-between w-full items-center bg-green-50">
                                                    <p class="block w-[90%] "><span class="">[ SASARAN ]</span>
                                                        {{ $sasaran->sasaran }}
                                                </div>
                                            </div>
                                            <ul class="child hidden ml-[14px] flex flex-col border-yellow-300 border-l-2">
                                                @foreach ($sasaran->indikator as $indikator)
                                                    <li class="ml-16 mt-4">
                                                        <div class="parent flex items-center gap-5">
                                                            <div
                                                                class="p-4 rounded-md border-yellow-300 border-2 flex justify-between w-full items-center bg-yellow-50">
                                                                <p class="block w-[90%] "><span class="">[ INDIKATOR
                                                                        ]</span>
                                                                    {{ $indikator->indikator }}</p>
                                                                @if (in_array($sub_indikator->id, $existingDataIndikator))
                                                                    <div class="flex flex-col items-center text-center">
                                                                        <span
                                                                            class="w-full text-sm whitespace-nowrap bg-gradient-to-r from-red-500 to-red-400 py-1 px-3 rounded-t-md text-white">
                                                                            Data
                                                                            sudah
                                                                            diisi
                                                                        </span>
                                                                        <a href=""
                                                                            class="w-full text-sm whitespace-nowrap bg-gradient-to-r from-blue-500 to-blue-400 py-1 px-3 rounded-b-md text-white">
                                                                            Edit
                                                                            data
                                                                        </a>
                                                                    </div>
                                                                @else
                                                                    <a href="{{ url('') }}">
                                                                        <button
                                                                            class="flex items-center gap-2 bg-gradient-to-r from-blue-500 to-blue-400 hover:bg-blue-600 text-white py-2 px-3 rounded-md font-medium transition-all text-sm whitespace-nowrap">
                                                                            Input
                                                                            data
                                                                        </button>
                                                                    </a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endforeach
                    </ul>
                </li>
            </ul>
        </div>
    </div>
@endsection
