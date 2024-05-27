@extends('layouts.app')

@section('title', 'Admin Approval dashboard')

@section('content')
<div class="w-full p-5 h-full">

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg p-4 bg-white mt-3">
        <div class="w-full flex justify-between">
            <div class="bg-white">
                <form action="{{ route('search-data') }}" method="GET"
                    class="flex items-center text-gray-900 border border-gray-300 rounded-md w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 overflow-hidden">
                    <input type="text" name="search" id="table-search"
                        class="block py-2 px-4 outline-none text-sm w-full" placeholder="Cari data"
                        value="{{ request('search') }}">
                    <button type="submit"
                        class="px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-400 text-white rounded-r-md hover:bg-blue-600">Cari</button>
                </form>
            </div>
        </div>
        <table id="dataIkuTable" class="w-full text-sm text-left rtl:text-left mt-5">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 h-full">
                <tr class="h-full">
                    <th scope="col" class="p-4 w-4 text-left">
                        No
                    </th>
                    <th scope="col" class="px-6 py-3 text-left">
                        Capaian Kinerja
                    </th>
                    <th scope="col" class="px-6 py-3 text-left whitespace-nowrap">
                        Upload By
                    </th>
                    <th scope="col" class="px-6 py-3 text-left">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3 text-center">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody>
                {{-- @php
                $originalIndex = 0;
                @endphp
                @forelse ($dataIku as $data)
                @if (
                $data->sub_indikator &&
                ($data->sub_indikator->bidang_id === null || $data->sub_indikator->bidang_id ===
                Auth::user()->bidang_id)) --}}
                <tr class="bg-white border-b hover:bg-gray-50">
                    <td class="py-4 px-6 w-[30px]">1</td>
                    <td class="py-4 px-6 text-left">

                        [SUB INDIKATOR] testt

                    </td>
                    <td class="py-4 px-6 text-left whitespace-nowrap">ggg</td>
                    <td class="py-4 px-6 text-left">testte</td>
                    <td class="py-4 px-6 text-center gap-3 flex items-center justify-center h-auto">

                        <a href="" class="text-blue-500 hover:text-blue-700">
                            <i class="fa-regular fa-pen-to-square"></i>
                        </a>

                    </td>
                </tr>
                {{-- @elseif (!$data->sub_indikator)
                <tr class="bg-white border-b hover:bg-gray-50 h-full">
                    <td class="py-4 px-6 w-[30px]">{{ $originalIndex + 1 }}</td>
                    <td class="py-4 px-6 text-left">
                        @if ($data->indikator_penunjang)
                        [INDIKATOR PENUNJANG] {{ $data->indikator_penunjang->indikator_penunjang }}
                        @elseif($data->indikator)
                        [INDIKATOR] {{ $data->indikator->indikator }}
                        @else
                        N/A
                        @endif
                    </td>
                    <td class="py-4 px-6 text-left whitespace-nowrap">{{ $data->user->name }}</td>
                    <td class="py-4 px-6 text-left">{{ ucfirst($data->status) }}</td>
                    <td class="py-4 px-6 text-center gap-3 flex items-center justify-center">
                        @if ($data->indikator_penunjang)
                        <a href="{{ url('operator/edit-master-data/indikator_penunjang/' . $data->indikator_penunjang->id) }}"
                            class="text-blue-500 hover:text-blue-700">
                            <i class="fa-regular fa-pen-to-square"></i>
                        </a>
                        @elseif($data->indikator)
                        <a href="{{ url('operator/edit-master-data/indikator/' . $data->indikator->id) }}"
                            class="text-blue-500 hover:text-blue-700">
                            <i class="fa-regular fa-pen-to-square"></i>
                        </a>
                        @endif
                    </td>
                </tr>
                @endif --}}
                {{-- @empty
                <tr class="bg-white border-b hover:bg-gray-50 text-center">
                    <td colspan="5" class="py-5 font-bold">Tidak ada data</td>
                </tr>
                @endforelse --}}
            </tbody>
        </table>
        <nav class="flex items-center flex-column flex-wrap md:flex-row justify-between pt-4"
            aria-label="Table navigation">
            <span class="text-sm font-normal text-gray-500 mb-4 md:mb-0 block w-full md:inline md:w-auto">Menampilkan
                <span class="font-semibold text-gray-900"></span>
                dari
                <span class="font-semibold text-gray-900"></span></span>
            <ul class="inline-flex -space-x-px rtl:space-x-reverse text-sm h-8">
                <li>
                    <a href=""
                        class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700">Previous</a>
                </li>


                <li>
                    <a href="" class="flex items-center justify-center px-3 h-8 leading-tight"></a>
                </li>

                <li>
                    <a href=""
                        class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700">Next</a>
                </li>

                <li>
                    <span
                        class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg cursor-not-allowed">Next</span>
                </li>

            </ul>
        </nav>
    </div>
</div>
@endsection