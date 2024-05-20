@extends('layouts.app')

@section('title', 'Admin Binagram dashboard')

@section('content')
<div class="w-full p-5 h-full">
    <h2 class="text-gray-500 text-sm">Daftar IKU</h2>
    <div class="mt-5 bg-white p-5 rounded shadow">
        <ul class="flex flex-col gap-4">
            <li class="">
                <div class="parent p-4 border-gray-400 border-2 flex justify-between w-full items-center cursor-pointer hover:bg-gray-100">
                    <p>Indikator Kinerja Utama</p>
                    <div class="flex gap-4">
                        <i class="fa-regular fa-pen-to-square text-blue-400"></i>
                        <i class="fa-solid fa-trash text-red-400"></i>
                        <i class="fa-solid fa-plus text-green-400"></i>
                    </div>
                </div>
                <ul class="child hidden ml-5 flex flex-col gap-4  border-gray-400 border-l-2">
                    <li class="ml-5 mt-4">
                        <div class="parent p-4 border-gray-400 border-2 flex justify-between w-full items-center cursor-pointer hover:bg-gray-100">
                            <p>Submenu 1</p>
                            <div class="flex gap-4">
                                <i class="fa-regular fa-pen-to-square text-blue-400"></i>
                                <i class="fa-solid fa-trash text-red-400"></i>
                                <i class="fa-solid fa-plus text-green-400"></i>
                            </div>
                        </div>
                        <ul class="child hidden ml-5 flex flex-col gap-4  border-gray-400 border-l-2">
                            <li class="ml-5 mt-4">
                                <div class="parent p-4 border-gray-400 border-2 flex justify-between w-full items-center cursor-pointer hover:bg-gray-100">
                                    <p>Submenu 1</p>
                                    <div class="flex gap-4">
                                        <i class="fa-regular fa-pen-to-square text-blue-400"></i>
                                        <i class="fa-solid fa-trash text-red-400"></i>
                                        <i class="fa-solid fa-plus text-green-400"></i>
                                    </div>
                                </div>
                                <ul class="child hidden ml-5 flex flex-col gap-4  border-gray-400 border-l-2">
                                    <li class="ml-5 mt-4">
                                        <div class="parent p-4 border-gray-400 border-2 flex justify-between w-full items-center cursor-pointer hover:bg-gray-100">
                                            <p>Submenu 1</p>
                                            <div class="flex gap-4">
                                                <i class="fa-regular fa-pen-to-square text-blue-400"></i>
                                                <i class="fa-solid fa-trash text-red-400"></i>
                                                <i class="fa-solid fa-plus text-green-400"></i>
                                            </div>
                                        </div>
                                        <ul class="child hidden ml-5 flex flex-col gap-4  border-gray-400 border-l-2">
                                            <li class="ml-5 mt-4">
                                                <div class="parent p-4 border-gray-400 border-2 flex justify-between w-full items-center cursor-pointer hover:bg-gray-100">
                                                    <p>Submenu 1</p>
                                                    <div class="flex gap-4">
                                                        <i class="fa-regular fa-pen-to-square text-blue-400"></i>
                                                        <i class="fa-solid fa-trash text-red-400"></i>
                                                        <i class="fa-solid fa-plus text-green-400"></i>
                                                    </div>
                                                </div>
                                                <ul class="child hidden ml-5 flex flex-col gap-4  border-gray-400 border-l-2">
                                                    <li class="ml-5 mt-4">
                                                        <div class="p-4 border-gray-400 border-2 flex justify-between w-full items-center cursor-pointer hover:bg-gray-100">
                                                            <p>Submenu 1</p>
                                                            <div class="flex gap-4">
                                                                <i class="fa-regular fa-pen-to-square text-blue-400"></i>
                                                                <i class="fa-solid fa-trash text-red-400"></i>
                                                                <i class="fa-solid fa-plus text-green-400"></i>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li class="ml-5 mt-4">
                                                <div class="parent p-4 border-gray-400 border-2 flex justify-between w-full items-center cursor-pointer hover:bg-gray-100">
                                                    <p>Submenu 1</p>
                                                    <div class="flex gap-4">
                                                        <i class="fa-regular fa-pen-to-square text-blue-400"></i>
                                                        <i class="fa-solid fa-trash text-red-400"></i>
                                                        <i class="fa-solid fa-plus text-green-400"></i>
                                                    </div>
                                                </div>
                                                <ul class="child hidden ml-5 flex flex-col gap-4  border-gray-400 border-l-2">
                                                    <li class="ml-5 mt-4">
                                                        <div class="p-4 border-gray-400 border-2 flex justify-between w-full items-center cursor-pointer hover:bg-gray-100">
                                                            <p>Submenu 1</p>
                                                            <div class="flex gap-4">
                                                                <i class="fa-regular fa-pen-to-square text-blue-400"></i>
                                                                <i class="fa-solid fa-trash text-red-400"></i>
                                                                <i class="fa-solid fa-plus text-green-400"></i>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="ml-5 mt-4">
                                        <div class="parent p-4 border-gray-400 border-2 flex justify-between w-full items-center cursor-pointer hover:bg-gray-100">
                                            <p>Submenu 1</p>
                                            <div class="flex gap-4">
                                                <i class="fa-regular fa-pen-to-square text-blue-400"></i>
                                                <i class="fa-solid fa-trash text-red-400"></i>
                                                <i class="fa-solid fa-plus text-green-400"></i>
                                            </div>
                                        </div>
                                        <ul class="child hidden ml-5 flex flex-col gap-4  border-gray-400 border-l-2">
                                            <li class="ml-5 mt-4">
                                                <div class="parent p-4 border-gray-400 border-2 flex justify-between w-full items-center cursor-pointer hover:bg-gray-100">
                                                    <p>Submenu 1</p>
                                                    <div class="flex gap-4">
                                                        <i class="fa-regular fa-pen-to-square text-blue-400"></i>
                                                        <i class="fa-solid fa-trash text-red-400"></i>
                                                        <i class="fa-solid fa-plus text-green-400"></i>
                                                    </div>
                                                </div>
                                                <ul class="child hidden ml-5 flex flex-col gap-4  border-gray-400 border-l-2">
                                                    <li class="ml-5 mt-4">
                                                        <div class="p-4 border-gray-400 border-2 flex justify-between w-full items-center cursor-pointer hover:bg-gray-100">
                                                            <p>Submenu 1</p>
                                                            <div class="flex gap-4">
                                                                <i class="fa-regular fa-pen-to-square text-blue-400"></i>
                                                                <i class="fa-solid fa-trash text-red-400"></i>
                                                                <i class="fa-solid fa-plus text-green-400"></i>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li class="ml-5 mt-4">
                                                <div class="parent p-4 border-gray-400 border-2 flex justify-between w-full items-center cursor-pointer hover:bg-gray-100">
                                                    <p>Submenu 1</p>
                                                    <div class="flex gap-4">
                                                        <i class="fa-regular fa-pen-to-square text-blue-400"></i>
                                                        <i class="fa-solid fa-trash text-red-400"></i>
                                                        <i class="fa-solid fa-plus text-green-400"></i>
                                                    </div>
                                                </div>
                                                <ul class="child hidden ml-5 flex flex-col gap-4  border-gray-400 border-l-2">
                                                    <li class="ml-5 mt-4">
                                                        <div class="p-4 border-gray-400 border-2 flex justify-between w-full items-center cursor-pointer hover:bg-gray-100">
                                                            <p>Submenu 1</p>
                                                            <div class="flex gap-4">
                                                                <i class="fa-regular fa-pen-to-square text-blue-400"></i>
                                                                <i class="fa-solid fa-trash text-red-400"></i>
                                                                <i class="fa-solid fa-plus text-green-400"></i>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            <li class="">
                <div class="parent p-4 border-gray-400 border-2 flex justify-between w-full items-center cursor-pointer hover:bg-gray-100">
                    <p>Indikator Kinerja Utama Suplemen</p>
                    <div class="flex gap-4">
                        <i class="fa-regular fa-pen-to-square text-blue-400"></i>
                        <i class="fa-solid fa-trash text-red-400"></i>
                        <i class="fa-solid fa-plus text-green-400"></i>
                    </div>
                </div>
                <ul class="child hidden ml-5 flex flex-col gap-4  border-gray-400 border-l-2">
                    <li class="ml-5 mt-4">
                        <div class="parent p-4 border-gray-400 border-2 flex justify-between w-full items-center cursor-pointer hover:bg-gray-100">
                            <p>Submenu 1</p>
                            <div class="flex gap-4">
                                <i class="fa-regular fa-pen-to-square text-blue-400"></i>
                                <i class="fa-solid fa-trash text-red-400"></i>
                                <i class="fa-solid fa-plus text-green-400"></i>
                            </div>
                        </div>
                        <ul class="child hidden ml-5 flex flex-col gap-4  border-gray-400 border-l-2">
                            <li class="ml-5 mt-4">
                                <div class="parent p-4 border-gray-400 border-2 flex justify-between w-full items-center cursor-pointer hover:bg-gray-100">
                                    <p>Submenu 1</p>
                                    <div class="flex gap-4">
                                        <i class="fa-regular fa-pen-to-square text-blue-400"></i>
                                        <i class="fa-solid fa-trash text-red-400"></i>
                                        <i class="fa-solid fa-plus text-green-400"></i>
                                    </div>
                                </div>
                                <ul class="child hidden ml-5 flex flex-col gap-4  border-gray-400 border-l-2">
                                    <li class="ml-5 mt-4">
                                        <div class="parent p-4 border-gray-400 border-2 flex justify-between w-full items-center cursor-pointer hover:bg-gray-100">
                                            <p>Submenu 1</p>
                                            <div class="flex gap-4">
                                                <i class="fa-regular fa-pen-to-square text-blue-400"></i>
                                                <i class="fa-solid fa-trash text-red-400"></i>
                                                <i class="fa-solid fa-plus text-green-400"></i>
                                            </div>
                                        </div>
                                        <ul class="child hidden ml-5 flex flex-col gap-4  border-gray-400 border-l-2">
                                            <li class="ml-5 mt-4">
                                                <div class="parent p-4 border-gray-400 border-2 flex justify-between w-full items-center cursor-pointer hover:bg-gray-100">
                                                    <p>Submenu 1</p>
                                                    <div class="flex gap-4">
                                                        <i class="fa-regular fa-pen-to-square text-blue-400"></i>
                                                        <i class="fa-solid fa-trash text-red-400"></i>
                                                        <i class="fa-solid fa-plus text-green-400"></i>
                                                    </div>
                                                </div>
                                                <ul class="child hidden ml-5 flex flex-col gap-4  border-gray-400 border-l-2">
                                                    <li class="ml-5 mt-4">
                                                        <div class="p-4 border-gray-400 border-2 flex justify-between w-full items-center cursor-pointer hover:bg-gray-100">
                                                            <p>Submenu 1</p>
                                                            <div class="flex gap-4">
                                                                <i class="fa-regular fa-pen-to-square text-blue-400"></i>
                                                                <i class="fa-solid fa-trash text-red-400"></i>
                                                                <i class="fa-solid fa-plus text-green-400"></i>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li class="ml-5 mt-4">
                                                <div class="parent p-4 border-gray-400 border-2 flex justify-between w-full items-center cursor-pointer hover:bg-gray-100">
                                                    <p>Submenu 1</p>
                                                    <div class="flex gap-4">
                                                        <i class="fa-regular fa-pen-to-square text-blue-400"></i>
                                                        <i class="fa-solid fa-trash text-red-400"></i>
                                                        <i class="fa-solid fa-plus text-green-400"></i>
                                                    </div>
                                                </div>
                                                <ul class="child hidden ml-5 flex flex-col gap-4  border-gray-400 border-l-2">
                                                    <li class="ml-5 mt-4">
                                                        <div class="p-4 border-gray-400 border-2 flex justify-between w-full items-center cursor-pointer hover:bg-gray-100">
                                                            <p>Submenu 1</p>
                                                            <div class="flex gap-4">
                                                                <i class="fa-regular fa-pen-to-square text-blue-400"></i>
                                                                <i class="fa-solid fa-trash text-red-400"></i>
                                                                <i class="fa-solid fa-plus text-green-400"></i>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="ml-5 mt-4">
                                        <div class="parent p-4 border-gray-400 border-2 flex justify-between w-full items-center cursor-pointer hover:bg-gray-100">
                                            <p>Submenu 1</p>
                                            <div class="flex gap-4">
                                                <i class="fa-regular fa-pen-to-square text-blue-400"></i>
                                                <i class="fa-solid fa-trash text-red-400"></i>
                                                <i class="fa-solid fa-plus text-green-400"></i>
                                            </div>
                                        </div>
                                        <ul class="child hidden ml-5 flex flex-col gap-4  border-gray-400 border-l-2">
                                            <li class="ml-5 mt-4">
                                                <div class="parent p-4 border-gray-400 border-2 flex justify-between w-full items-center cursor-pointer hover:bg-gray-100">
                                                    <p>Submenu 1</p>
                                                    <div class="flex gap-4">
                                                        <i class="fa-regular fa-pen-to-square text-blue-400"></i>
                                                        <i class="fa-solid fa-trash text-red-400"></i>
                                                        <i class="fa-solid fa-plus text-green-400"></i>
                                                    </div>
                                                </div>
                                                <ul class="child hidden ml-5 flex flex-col gap-4  border-gray-400 border-l-2">
                                                    <li class="ml-5 mt-4">
                                                        <div class="p-4 border-gray-400 border-2 flex justify-between w-full items-center cursor-pointer hover:bg-gray-100">
                                                            <p>Submenu 1</p>
                                                            <div class="flex gap-4">
                                                                <i class="fa-regular fa-pen-to-square text-blue-400"></i>
                                                                <i class="fa-solid fa-trash text-red-400"></i>
                                                                <i class="fa-solid fa-plus text-green-400"></i>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li class="ml-5 mt-4">
                                                <div class="parent p-4 border-gray-400 border-2 flex justify-between w-full items-center cursor-pointer hover:bg-gray-100">
                                                    <p>Submenu 1</p>
                                                    <div class="flex gap-4">
                                                        <i class="fa-regular fa-pen-to-square text-blue-400"></i>
                                                        <i class="fa-solid fa-trash text-red-400"></i>
                                                        <i class="fa-solid fa-plus text-green-400"></i>
                                                    </div>
                                                </div>
                                                <ul class="child hidden ml-5 flex flex-col gap-4  border-gray-400 border-l-2">
                                                    <li class="ml-5 mt-4">
                                                        <div class="p-4 border-gray-400 border-2 flex justify-between w-full items-center cursor-pointer hover:bg-gray-100">
                                                            <p>Submenu 1</p>
                                                            <div class="flex gap-4">
                                                                <i class="fa-regular fa-pen-to-square text-blue-400"></i>
                                                                <i class="fa-solid fa-trash text-red-400"></i>
                                                                <i class="fa-solid fa-plus text-green-400"></i>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>
@endsection