@extends('layouts.app')

@section('title', 'Admin Sistem dashboard')

@section('content')
<div class="bg-gray-50 w-full p-5 h-full">
    <a class="font-medium text-2xl" href="{{url("adminsistem/dashboard")}}"><i class="fa-solid fa-angle-left text-xl"></i> Tambah Akun</a>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg p-4 bg-white mt-5">
        <form class="mx-auto">
            <div class="mb-5">
                <label for="nama" class="block mb-2 text-sm font-medium text-gray-900 ">Nama</label>
                <input type="nama" id="nama"
                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                    placeholder="name@flowbite.com" required />
            </div>
            <div class="mb-5">
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 ">Email</label>
                <input type="email" id="email"
                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                    placeholder="name@flowbite.com" required />
            </div>
            <div class="mb-5">
                <label for="bidang" class="block mb-2 text-sm font-medium text-gray-900">Bidang</label>
                <select id="countries" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option>United States</option>
                    <option>Canada</option>
                    <option>France</option>
                    <option>Germany</option>
                  </select>
            </div>
            <div class="mb-5">
                <label for="role" class="block mb-2 text-sm font-medium text-gray-900">Role</label>
                <select id="role"
                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                    required >
                    <option>United States</option>
                    <option>Canada</option>
                    <option>France</option>
                    <option>Germany</option>
                </select>
            </div>
            <div class="mb-5">
                <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Password</label>
                <input type="password" id="password"
                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                    required />
            </div>
            <div class="mb-5">
                <label for="repeat-password" class="block mb-2 text-sm font-medium text-gray-900 ">Repeat
                    password</label>
                <input type="password" id="repeat-password"
                    class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                    required />
            </div>
            <button type="submit"
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Buat akun</button>
        </form>
    </div>

</div>
@endsection