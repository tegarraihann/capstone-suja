@extends('layouts.app')

@section('title', 'Admin Binagram dashboard')

@section('content')
    <div class="w-full p-5 h-full">
        <h2 class="text-gray-500 text-sm">Daftar IKU</h2>
        <div class="mt-5 bg-white p-5 rounded shadow">
            <ul class="flex flex-col gap-4">
                <li class="">
                    <div
                        class="parent p-4 border-gray-400 border-2 flex justify-between w-full items-center cursor-pointer hover:bg-gray-100">
                        <p>Indikator Kinerja Utama</p>
                        <div class="flex gap-4">
                            <i class="fa-regular fa-pen-to-square text-blue-400"></i>
                            <i class="fa-solid fa-trash text-red-500"></i>
                            <i class="fa-solid fa-plus text-green-400"></i>
                        </div>
                    </div>
                    <ul class="child hidden ml-5 flex flex-col gap-4  border-gray-400 border-l-2">
                        @foreach ($iku as $tujuan)
                            <li class="ml-5 mt-4">
                                <div
                                    class="parent p-4 border-gray-400 border-2 flex justify-between w-full items-center cursor-pointer hover:bg-gray-100">
                                    <p><span class="">[ TUJUAN ]</span> {{ $tujuan->tujuan }}</p>
                                    <div class="flex gap-4">
                                        <i class="fa-regular fa-pen-to-square text-blue-400"></i>
                                        <i class="fa-solid fa-trash text-red-500"></i>
                                        <i class="fa-solid fa-plus text-green-400"></i>
                                    </div>
                                </div>
                                <ul class="child hidden ml-5 flex flex-col gap-4  border-gray-400 border-l-2">
                                    @foreach ($tujuan->sasaran as $sasaran)
                                        <li class="ml-5 mt-4">
                                            <div
                                                class="p-4 border-gray-400 border-2 flex justify-between w-full items-center cursor-pointer hover:bg-gray-100">
                                                <p><span class="">[ SASARAN ]</span> {{ $sasaran->sasaran }}
                                                </p>
                                                <div class="flex gap-4">
                                                    <i class="fa-regular fa-pen-to-square text-blue-400"></i>
                                                    <i class="fa-solid fa-trash text-red-500"></i>
                                                    <i class="fa-solid fa-plus text-green-400"></i>
                                                </div>
                                            </div>
                                            <ul class="child ml-5 flex flex-col gap-4  border-gray-400 border-l-2">
                                                @foreach ($sasaran->indikator as $indikator)
                                                    <li class="ml-5 mt-4">
                                                        <div
                                                            class="p-4 border-gray-400 border-2 flex justify-between w-full items-center cursor-pointer hover:bg-gray-100">
                                                            <p><span class="">[ INDIKATOR ]</span>
                                                                {{ $indikator->indikator }}</p>
                                                            <div class="flex gap-4">
                                                                <i class="fa-regular fa-pen-to-square text-blue-400"></i>
                                                                <i class="fa-solid fa-trash text-red-500"></i>
                                                                <i class="fa-solid fa-plus text-green-400"></i>
                                                            </div>
                                                        </div>
                                                        @if ($indikator->indikator_penunjang()->exists())
                                                            <ul
                                                                class="child ml-5 flex flex-col gap-4 border-gray-400 border-l-2">
                                                                @foreach ($indikator->indikator_penunjang as $indikator_penunjang)
                                                                    <li class="ml-5 mt-4">
                                                                        <div
                                                                            class="p-4 border-gray-400 border-2 flex justify-between w-full items-center cursor-pointer hover:bg-gray-100">
                                                                            <p><span class="">[ INDIKATOR PENUNJANG
                                                                                    ]</span>
                                                                                {{ $indikator_penunjang->indikator_penunjang }}
                                                                            </p>
                                                                            <div class="flex gap-4">
                                                                                <i
                                                                                    class="fa-regular fa-pen-to-square text-blue-400"></i>
                                                                                <i
                                                                                    class="fa-solid fa-trash text-red-500"></i>
                                                                                <i
                                                                                    class="fa-solid fa-plus text-green-400"></i>
                                                                            </div>
                                                                        </div>
                                                                        <ul
                                                                            class="child ml-5 flex flex-col gap-4 border-gray-400 border-l-2">
                                                                            @foreach ($indikator_penunjang->sub_indikator as $sub_indikator)
                                                                                <li class="ml-5 mt-4">
                                                                                    <div
                                                                                        class="p-4 border-gray-400 border-2 flex justify-between w-full items-center cursor-pointer hover:bg-gray-100">
                                                                                        <p><span class="">[ SUB
                                                                                                INDIKATOR ]</span>
                                                                                            {{ $sub_indikator->sub_indikator }}
                                                                                        </p>
                                                                                        <div class="flex gap-4">
                                                                                            <i
                                                                                                class="fa-regular fa-pen-to-square text-blue-400"></i>
                                                                                            <i
                                                                                                class="fa-solid fa-trash text-red-500"></i>
                                                                                            <i
                                                                                                class="fa-solid fa-plus text-green-400"></i>
                                                                                        </div>
                                                                                    </div>
                                                                                </li>
                                                                            @endforeach
                                                                        </ul>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @else
                                                            <ul
                                                                class="child ml-5 flex flex-col gap-4 border-gray-400 border-l-2">
                                                                @foreach ($indikator->sub_indikator as $sub_indikator)
                                                                    <li class="ml-5 mt-4">
                                                                        <div
                                                                            class="p-4 border-gray-400 border-2 flex justify-between w-full items-center cursor-pointer hover:bg-gray-100">
                                                                            <p><span class="">[ SUB INDIKATOR ]</span>
                                                                                {{ $sub_indikator->sub_indikator }}</p>
                                                                            <div class="flex gap-4">
                                                                                <i
                                                                                    class="fa-regular fa-pen-to-square text-blue-400"></i>
                                                                                <i
                                                                                    class="fa-solid fa-trash text-red-500"></i>
                                                                                <i
                                                                                    class="fa-solid fa-plus text-green-400"></i>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
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
                <li class="">
                    <div
                        class="parent p-4 border-gray-400 border-2 flex justify-between w-full items-center cursor-pointer hover:bg-gray-100">
                        <p>Indikator Kinerja Utama Suplemen</p>
                        <div class="flex gap-4">
                            <i class="fa-regular fa-pen-to-square text-blue-400"></i>
                            <i class="fa-solid fa-trash text-red-500"></i>
                            <i class="fa-solid fa-plus text-green-400"></i>
                        </div>
                    </div>
                    <ul class="child hidden ml-5 flex flex-col gap-4  border-gray-400 border-l-2">
                        @foreach ($iku_sup as $tujuan)
                            <li class="ml-5 mt-4">
                                <div
                                    class="parent p-4 border-gray-400 border-2 flex justify-between w-full items-center cursor-pointer hover:bg-gray-100">
                                    <p><span class="">[ TUJUAN ]</span> {{ $tujuan->tujuan }}</p>
                                    <div class="flex gap-4">
                                        <i class="fa-regular fa-pen-to-square text-blue-400"></i>
                                        <i class="fa-solid fa-trash text-red-500"></i>
                                        <i class="fa-solid fa-plus text-green-400"></i>
                                    </div>
                                </div>
                                <ul class="child hidden ml-5 flex flex-col gap-4  border-gray-400 border-l-2">
                                    @foreach ($tujuan->sasaran as $sasaran)
                                        <li class="ml-5 mt-4">
                                            <div
                                                class="p-4 border-gray-400 border-2 flex justify-between w-full items-center cursor-pointer hover:bg-gray-100">
                                                <p><span class="">[ SASARAN ]</span> {{ $sasaran->sasaran }}
                                                </p>
                                                <div class="flex gap-4">
                                                    <i class="fa-regular fa-pen-to-square text-blue-400"></i>
                                                    <i class="fa-solid fa-trash text-red-500"></i>
                                                    <i class="fa-solid fa-plus text-green-400"></i>
                                                </div>
                                            </div>
                                            <ul class="child ml-5 flex flex-col gap-4  border-gray-400 border-l-2">
                                                @foreach ($sasaran->indikator as $indikator)
                                                    <li class="ml-5 mt-4">
                                                        <div
                                                            class="p-4 border-gray-400 border-2 flex justify-between w-full items-center cursor-pointer hover:bg-gray-100">
                                                            <p><span class="">[ INDIKATOR ]</span>
                                                                {{ $indikator->indikator }}</p>
                                                            <div class="flex gap-4">
                                                                <i class="fa-regular fa-pen-to-square text-blue-400"></i>
                                                                <i class="fa-solid fa-trash text-red-500"></i>
                                                                <i class="fa-solid fa-plus text-green-400"></i>
                                                            </div>
                                                        </div>
                                                        @if ($indikator->indikator_penunjang()->exists())
                                                            <ul
                                                                class="child ml-5 flex flex-col gap-4 border-gray-400 border-l-2">
                                                                @foreach ($indikator->indikator_penunjang as $indikator_penunjang)
                                                                    <li class="ml-5 mt-4">
                                                                        <div
                                                                            class="p-4 border-gray-400 border-2 flex justify-between w-full items-center cursor-pointer hover:bg-gray-100">
                                                                            <p><span class="">[ INDIKATOR PENUNJANG
                                                                                    ]</span>
                                                                                {{ $indikator_penunjang->indikator_penunjang }}
                                                                            </p>
                                                                            <div class="flex gap-4">
                                                                                <i
                                                                                    class="fa-regular fa-pen-to-square text-blue-400"></i>
                                                                                <i
                                                                                    class="fa-solid fa-trash text-red-500"></i>
                                                                                <i
                                                                                    class="fa-solid fa-plus text-green-400"></i>
                                                                            </div>
                                                                        </div>
                                                                        <ul
                                                                            class="child ml-5 flex flex-col gap-4 border-gray-400 border-l-2">
                                                                            @foreach ($indikator_penunjang->sub_indikator as $sub_indikator)
                                                                                <li class="ml-5 mt-4">
                                                                                    <div
                                                                                        class="p-4 border-gray-400 border-2 flex justify-between w-full items-center cursor-pointer hover:bg-gray-100">
                                                                                        <p><span class="">[ SUB
                                                                                                INDIKATOR ]</span>
                                                                                            {{ $sub_indikator->sub_indikator }}
                                                                                        </p>
                                                                                        <div class="flex gap-4">
                                                                                            <i
                                                                                                class="fa-regular fa-pen-to-square text-blue-400"></i>
                                                                                            <i
                                                                                                class="fa-solid fa-trash text-red-500"></i>
                                                                                            <i
                                                                                                class="fa-solid fa-plus text-green-400"></i>
                                                                                        </div>
                                                                                    </div>
                                                                                </li>
                                                                            @endforeach
                                                                        </ul>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @else
                                                            <ul
                                                                class="child ml-5 flex flex-col gap-4 border-gray-400 border-l-2">
                                                                @foreach ($indikator->sub_indikator as $sub_indikator)
                                                                    <li class="ml-5 mt-4">
                                                                        <div
                                                                            class="p-4 border-gray-400 border-2 flex justify-between w-full items-center cursor-pointer hover:bg-gray-100">
                                                                            <p><span class="">[ SUB INDIKATOR ]</span>
                                                                                {{ $sub_indikator->sub_indikator }}</p>
                                                                            <div class="flex gap-4">
                                                                                <i
                                                                                    class="fa-regular fa-pen-to-square text-blue-400"></i>
                                                                                <i
                                                                                    class="fa-solid fa-trash text-red-500"></i>
                                                                                <i
                                                                                    class="fa-solid fa-plus text-green-400"></i>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
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
