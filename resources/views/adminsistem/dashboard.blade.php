@extends('layouts.app')

@section('title', 'Admin Sistem dashboard')

@section('content')
<div class="bg-gray-50 w-full p-5 h-full">
    
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg p-4 bg-white mt-3">
        <div class="w-full flex justify-between">
            <div class="bg-white">
                <label for="table-search" class="sr-only">Search</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                    </div>
                    <input type="text" id="table-search" class="block py-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500" placeholder="Search for items">
                </div>
            </div>

                <a href="{{url("adminsistem/dashboard/tambah-akun")}}"> 
                    <button
                    class="flex items-center gap-2 bg-blue-500 text-white py-2 px-6 rounded-md font-medium hover:bg-blue-600 transition-all">
                    Tambah Akun
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
                <tr class="bg-white border-b hover:bg-gray-50">
                    <td class="py-4 px-6 w-[30px]">1</td>
                    <td class="py-4 px-6 text-right">2107110387</td>
                    <td class="py-4 px-6 text-right">John Doe</td>
                    <td class="py-4 px-6 text-right">john@gmail.com</td>
                    <td class="py-4 px-6 text-right">Admin</td>
                    <td class="py-4 px-6 text-right">IPDS</td>
                    <td class="py-4 px-6 text-right gap-3 flex justify-end">
                        <i class="fa-regular fa-pen-to-square text-blue-500 cursor-pointer"></i>
                        <i class="fa-solid fa-trash text-red-500 cursor-pointer"></i>
                    </td>
                </tr>
                <tr class="bg-white border-b hover:bg-gray-50">
                    <td class="py-4 px-6 w-[30px]">1</td>
                    <td class="py-4 px-6 text-right">2107110387</td>
                    <td class="py-4 px-6 text-right">John Doe</td>
                    <td class="py-4 px-6 text-right">john@gmail.com</td>
                    <td class="py-4 px-6 text-right">Admin</td>
                    <td class="py-4 px-6 text-right">IPDS</td>
                    <td class="py-4 px-6 text-right gap-3 flex justify-end">
                        <i class="fa-regular fa-pen-to-square text-blue-500 cursor-pointer"></i>
                        <i class="fa-solid fa-trash text-red-500 cursor-pointer"></i>
                    </td>
                </tr>
                <tr class="bg-white border-b hover:bg-gray-50">
                    <td class="py-4 px-6 w-[30px]">1</td>
                    <td class="py-4 px-6 text-right">2107110387</td>
                    <td class="py-4 px-6 text-right">John Doe</td>
                    <td class="py-4 px-6 text-right">john@gmail.com</td>
                    <td class="py-4 px-6 text-right">Admin</td>
                    <td class="py-4 px-6 text-right">IPDS</td>
                    <td class="py-4 px-6 text-right gap-3 flex justify-end">
                        <i class="fa-regular fa-pen-to-square text-blue-500 cursor-pointer"></i>
                        <i class="fa-solid fa-trash text-red-500 cursor-pointer"></i>
                    </td>
                </tr>
            </tbody>
        </table>
        <nav class="flex items-center flex-column flex-wrap md:flex-row justify-between pt-4"
            aria-label="Table navigation">
            <span class="text-sm font-normal text-gray-500  mb-4 md:mb-0 block w-full md:inline md:w-auto">Showing <span
                    class="font-semibold text-gray-900 ">1-10</span> of <span
                    class="font-semibold text-gray-900">1000</span></span>
            <ul class="inline-flex -space-x-px rtl:space-x-reverse text-sm h-8">
                <li>
                    <a href="#"
                        class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 ">Previous</a>
                </li>
                <li>
                    <a href="#"
                        class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700">1</a>
                </li>
                <li>
                    <a href="#"
                        class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700">2</a>
                </li>
                <li>
                    <a href="#" aria-current="page"
                        class="flex items-center justify-center px-3 h-8 text-blue-600 border border-gray-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700">3</a>
                </li>
                <li>
                    <a href="#"
                        class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700">4</a>
                </li>
                <li>
                    <a href="#"
                        class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700">5</a>
                </li>
                <li>
                    <a href="#"
                        class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700">Next</a>
                </li>
            </ul>
        </nav>
    </div>

</div>
@endsection