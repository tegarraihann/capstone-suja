@extends('layouts.app')

@section('title', 'Daftar master data rejected')

@section('content')
    @if (!empty(session('error')))
        <script>
            swal({
                title: "{{ Session::get('error.title') }}",
                text: "{{ Session::get('error.message') }}",
                icon: "error",
                button: {
                    text: "OK",
                    closeModal: true,
                }
            })
        </script>
    @endif
    <div class="w-full p-5 h-full">

        <h2 class="text-gray-600 font-semibold text-2xl">Data Tidak Disetujui</h2>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg p-4 bg-white mt-3">
            <div class="w-full flex justify-between">
                <div class="bg-white">
                    <form action="{{ route('search-data-rejected') }}" method="GET"
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
                            Last Uploader
                        </th>
                        <th scope="col" class="px-6 py-3 text-left whitespace-nowrap">
                            Rejected By
                        </th>
                        <th scope="col" class="px-6 py-3 text-left whitespace-nowrap">
                            Triwulan
                        </th>
                        <th scope="col" class="px-6 py-3 text-left">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3 text-left">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $index = $dataKinerja->firstItem();
                    @endphp
                    @forelse ($dataKinerja as $data)
                        @if (
                            $data->sub_indikator &&
                                ($data->sub_indikator->bidang_id === null ||
                                    $data->sub_indikator->bidang_id === Auth::user()->bidang_id ||
                                    $data->indikator->bidang_id === Auth::user()->bidang_id))
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="py-4 px-6 w-[30px]">{{ $index++ }}</td>
                                <td class="py-4 px-6 text-left">
                                    @if ($data->sub_indikator)
                                        [SUB INDIKATOR] {{ $data->sub_indikator->sub_indikator }}
                                    @elseif($data->indikator_penunjang)
                                        [INDIKATOR PENUNJANG] {{ $data->indikator_penunjang->indikator_penunjang }}
                                    @elseif($data->indikator)
                                        [INDIKATOR] {{ $data->indikator->indikator }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-left whitespace-nowrap">{{ $data->user->name }} | <span
                                        class="text-blue-600">{{ $data->user->bidang->nama_bidang }}</span></td>
                                </td>
                                <td class="py-4 px-6 text-left whitespace-nowrap">{{ $data->rejected_by->name }} | <span
                                        class="text-blue-600">{{ $data->rejected_by->bidang->nama_bidang }}</span></td>
                                </td>
                                <td class="py-4 px-6 text-center">{{ $data->triwulan_id }}</td>
                                <td class="py-4 px-6 text-left">
                                    <p
                                        class="px-3 py-1 rounded-md border-red-500 border-2 flex justify-between w-fit items-center bg-red-200">
                                        {{ ucfirst($data->status) }}</p>
                                </td>
                                <td class="py-4 px-6 text-center gap-3">
                                    <div class="flex justify-center items-center gap-3">
                                        @if ($data->sub_indikator)
                                            <a href="{{ url('operator/edit-master-data/sub_indikator/' . $data->sub_indikator->id . '?triwulan=' . $data->triwulan_id) }}"
                                                class="text-blue-500 hover:text-blue-700">
                                                <i class="fa-regular fa-pen-to-square"></i>
                                            </a>
                                        @elseif($data->indikator_penunjang)
                                            <a href="{{ url('operator/edit-master-data/indikator_penunjang/' . $data->indikator_penunjang->id . '?triwulan=' . $data->triwulan_id) }}"
                                                class="text-blue-500 hover:text-blue-700">
                                                <i class="fa-regular fa-pen-to-square"></i>
                                            </a>
                                        @elseif($data->indikator)
                                            <a href="{{ url('operator/edit-master-data/indikator/' . $data->indikator->id . '?triwulan=' . $data->triwulan_id) }}"
                                                class="text-blue-500 hover:text-blue-700">
                                                <i class="fa-regular fa-pen-to-square"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @elseif (!$data->sub_indikator)
                            <tr class="bg-white border-b hover:bg-gray-50 h-full">
                                <td class="py-4 px-6 w-[30px]">{{ $index++ }}</td>
                                <td class="py-4 px-6 text-left">
                                    @if ($data->indikator_penunjang)
                                        [INDIKATOR PENUNJANG] {{ $data->indikator_penunjang->indikator_penunjang }}
                                    @elseif($data->indikator)
                                        [INDIKATOR] {{ $data->indikator->indikator }}
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-left whitespace-nowrap">{{ $data->user->name }} | <span
                                        class="text-blue-600">{{ $data->user->bidang->nama_bidang }}</span></td>
                                </td>
                                <td class="py-4 px-6 text-left whitespace-nowrap">{{ $data->rejected_by->name }} | <span
                                        class="text-blue-600">{{ $data->rejected_by->bidang->nama_bidang }}</span></td>
                                </td>
                                <td class="py-4 px-6 text-center">{{ $data->triwulan_id }}</td>
                                <td class="py-4 px-6 text-left">
                                    <p
                                        class="px-3 py-1 rounded-md border-red-500 border-2 flex justify-between w-fit items-center bg-red-200">
                                        {{ ucfirst($data->status) }}</p>
                                </td>
                                <td class="py-4 px-6 text-center gap-3">
                                    <div class="flex justify-center items-center gap-3">
                                        @if ($data->indikator_penunjang)
                                            <a href="{{ url('operator/edit-master-data/indikator_penunjang/' . $data->indikator_penunjang->id . '?triwulan=' . $data->triwulan_id) }}"
                                                class="text-blue-500 hover:text-blue-700">
                                                <i class="fa-regular fa-pen-to-square"></i>
                                            </a>
                                        @elseif($data->indikator)
                                            <a href="{{ url('operator/edit-master-data/indikator/' . $data->indikator->id . '?triwulan=' . $data->triwulan_id) }}"
                                                class="text-blue-500 hover:text-blue-700">
                                                <i class="fa-regular fa-pen-to-square"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endif
                    @empty
                        <tr class="bg-white border-b hover:bg-gray-50 text-center">
                            <td colspan="7" class="py-5 font-bold">Tidak ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <nav class="flex items-center flex-column flex-wrap md:flex-row justify-between pt-4"
                aria-label="Table navigation">
                <span class="text-sm font-normal text-gray-500 mb-4 md:mb-0 block w-full md:inline md:w-auto">Menampilkan
                    <span
                        class="font-semibold text-gray-900">{{ $dataKinerja->firstItem() }}-{{ $dataKinerja->lastItem() }}</span>
                    dari
                    <span class="font-semibold text-gray-900">{{ $dataKinerja->total() }}</span></span>
                <ul class="inline-flex -space-x-px rtl:space-x-reverse text-sm h-8">
                    @if ($dataKinerja->onFirstPage())
                        <li>
                            <span
                                class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-s-lg cursor-not-allowed">Previous</span>
                        </li>
                    @else
                        <li>
                            <a href="{{ $dataKinerja->appends(request()->except('page'))->previousPageUrl() }}"
                                class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700">Previous</a>
                        </li>
                    @endif

                    @foreach (range(1, $dataKinerja->lastPage()) as $i)
                        @if ($i >= $dataKinerja->currentPage() - 2 && $i <= $dataKinerja->currentPage() + 2)
                            <li>
                                <a href="{{ $dataKinerja->appends(request()->except('page'))->url($i) }}"
                                    class="flex items-center justify-center px-3 h-8 leading-tight {{ $i == $dataKinerja->currentPage() ? 'text-blue-600 border border-gray-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700' : 'text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700' }}">{{ $i }}</a>
                            </li>
                        @endif
                    @endforeach

                    @if ($dataKinerja->hasMorePages())
                        <li>
                            <a href="{{ $dataKinerja->appends(request()->except('page'))->nextPageUrl() }}"
                                class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700">Next</a>
                        </li>
                    @else
                        <li>
                            <span
                                class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg cursor-not-allowed">Next</span>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>
    </div>
@endsection
