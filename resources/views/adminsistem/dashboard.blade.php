@extends('layouts.app')

@section('title', 'Admin Sistem dashboard')

@section('content')
<div class="w-full p-5 h-full">

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg p-4 bg-white mt-3">
        <div class="w-full flex justify-between">
            <div class="bg-white">
                <label for="table-search" class="sr-only">Search</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <input type="text" name="search" id="table-search"
                        class="block py-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Search for items">
                </div>
            </div>

            <a href="{{ url('adminsistem/dashboard/tambah-user') }}">
                <button
                    class="flex items-center gap-2 bg-blue-500 text-white py-2 px-6 rounded-md font-medium hover:bg-blue-600 transition-all">
                    Tambah User
                    <i class="fa solid fa-plus"></i>
                </button>
            </a>

        </div>
        <table class="w-full text-sm text-left rtl:text-right mt-5">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 ">
                <tr>
                    <th scope="col" class="p-4 w-4 text-right">
                        No
                    </th>
                    <th scope="col" class="px-6 py-3 text-right">
                        NIP
                    </th>
                    <th scope="col" class="px-6 py-3 text-right">
                        Nama
                    </th>
                    <th scope="col" class="px-6 py-3 text-right">
                        Email
                    </th>
                    <th scope="col" class="px-6 py-3 text-right">
                        Role
                    </th>
                    <th scope="col" class="px-6 py-3 text-right">
                        Bidang
                    </th>
                    <th scope="col" class="px-6 py-3 text-right">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody>
                @php
                $roleLabels = [];
                foreach ($roleOptions as $option) {
                $roleLabels[$option['value']] = $option['label'];
                }
                @endphp
                @forelse ($users as $index => $user)
                <tr class="bg-white border-b hover:bg-gray-50">
                    <td class="py-4 px-6 w-[30px]">{{ $index + 1 }}</td>
                    <td class="py-4 px-6 text-right">{{ $user->nip }}</td>
                    <td class="py-4 px-6 text-right">{{ $user->name }}</td>
                    <td class="py-4 px-6 text-right">{{ $user->email }}</td>
                    <td class="py-4 px-6 text-right">{{ $roleLabels[$user->role] }}</td>
                    <td class="py-4 px-6 text-right">{{ $user->nama_bidang }}</td>
                    <td class="py-4 px-6 text-right gap-3 flex justify-end">
                        <i class="fa-regular fa-pen-to-square text-blue-500 cursor-pointer"></i>
                        <i data-nip="{{ $user->nip }}" data-name="{{ $user->name }}" data-id="{{$user->id}}"
                            class="btn-delete fa-solid fa-trash text-red-500 cursor-pointer"></i>
                    </td>
                </tr>
                @empty
                <tr class="bg-white border-b hover:bg-gray-50 text-center">
                    <td colspan="7" class="cotext-center">Tidak ada data pengguna</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <nav class="flex items-center flex-column flex-wrap md:flex-row justify-between pt-4"
            aria-label="Table navigation">
            <span class="text-sm font-normal text-gray-500  mb-4 md:mb-0 block w-full md:inline md:w-auto">Menampilkan
                <span class="font-semibold text-gray-900 ">{{$users->firstItem()}}-{{$users->lastItem()}}</span> dari
                <span class="font-semibold text-gray-900">{{ $users->total() }}</span></span>
            <ul class="inline-flex -space-x-px rtl:space-x-reverse text-sm h-8">
                @if ($users->onFirstPage())
                <li>
                    <span
                        class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-s-lg cursor-not-allowed">Previous</span>
                </li>
                @else
                <li>
                    <a href="{{ $users->previousPageUrl() }}"
                        class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700">Previous</a>
                </li>
                @endif

                @foreach(range(1, $users->lastPage()) as $i)
                @if ($i >= $users->currentPage() - 2 && $i <= $users->currentPage() + 2)
                    <li>
                        <a href="{{ $users->url($i) }}"
                            class="flex items-center justify-center px-3 h-8 leading-tight {{ $i == $users->currentPage() ? 'text-blue-600 border border-gray-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700' : 'text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700' }}">{{
                            $i }}</a>
                    </li>
                    @endif
                    @endforeach

                    @if ($users->hasMorePages())
                    <li>
                        <a href="{{ $users->nextPageUrl() }}"
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