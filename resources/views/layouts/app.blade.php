<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <title>@yield('title')</title>
    <!-- Add your stylesheets and scripts here -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    @php
        $roleOptions = [
            ['value' => '4', 'label' => 'Pimpinan'],
            ['value' => '3', 'label' => 'Admin Sistem'],
            ['value' => '2', 'label' => 'Admin Binagram'],
            ['value' => '1', 'label' => 'Admin Approval'],
            ['value' => '0', 'label' => 'Operator'],
        ];

        $userRoleLabel = '';
        foreach ($roleOptions as $roleOption) {
            if ($roleOption['value'] == Auth::user()->role) {
                $userRoleLabel = $roleOption['label'];
                break;
            }
        }

        $firstLetter = strtoupper(substr(Auth::user()->name, 0, 1));
    @endphp
    <div class="wrapper">
        <!-- Header -->
        <header
            class="flex items-center justify-between py-4 px-10 h-20 fixed left-0 bg-white z-20 top-0 w-full border-b-2">
            @if (Auth::check())
                <img src="{{ asset('assets/logo.png') }}" class="w-16" />
                <div class="flex items-center gap-6">
                    <i class="fa-regular fa-bell cursor-pointer text-lg"></i>
                    <i class="logout-btn fa-solid fa-arrow-right-from-bracket cursor-pointer text-lg"></i>
                    <div
                        class="flex items-center justify-center text-white rounded-full bg-gray-700 w-7 h-7 text-xs cursor-pointer">
                        {{ $firstLetter }}</div>
                </div>
            @endif
        </header>


        <!-- Sidebar -->
        <aside class="top-20 fixed left-0 w-[260px] p-5 border-r-2 z-10" style="height: calc(100vh - 80px)">
            <div class="w-full h-full flex flex-col overflow-x-hidden">
                @if (Auth::check())
                    <div class="mb-5 mt-3 bg-gradient-to-r from-blue-500 to-blue-400 p-5 rounded-lg text-white">
                        <div
                            class="flex items-center justify-center text-blue-500 font-bold rounded-full bg-white w-9 h-9 text-sm cursor-pointer">
                            {{ $firstLetter }}</div>
                        <div class="mt-5">
                            <p class="font-medium text-lg">{{ Auth::user()->name }}</p>
                            <p class="text-sm text-start">
                                {{ $userRoleLabel }}
                            </p>
                        </div>
                    </div>
                @endif
                {{-- sidebar menu --}}
                <div class="flex flex-col gap-4 w-full h-full">
                    {{-- pimpinan --}}
                    @if (Auth::user()->role == 4)
                    @endif
                    {{-- admin sistem --}}
                    @if (Auth::user()->role == 3)
                        <div class="flex flex-col h-full gap-3 w-full justify-between">
                            <div class="flex flex-col w-full gap-1">
                                <a href="/adminsistem/dashboard" class="w-full menu-item">
                                    <div
                                        class="flex justify-left gap-6 w-full rounded-lg py-3 px-6 hover:bg-blue-50 hover:text-blue-600">
                                        <i class="fa-solid fa-user my-auto text-xs w-1/12"></i>
                                        <p class="text-sm">Daftar User</p>
                                    </div>
                                </a>
                                <a href="/adminsistem/tambah-user" class="w-full menu-item">
                                    <div
                                        class="flex justify-left gap-6 w-full rounded-lg py-3 px-6 hover:bg-blue-50 hover:text-blue-600">
                                        <i class="fa-solid fa-plus my-auto text-xs w-1/12"></i>
                                        <p class="text-sm">Tambah User</p>
                                    </div>
                                </a>
                            </div>
                            <div class="">
                                <a href="/adminsistem/settings" class="w-full menu-item">
                                    <div
                                        class="flex justify-left gap-6 w-full rounded-lg py-3 px-6 hover:bg-blue-50 hover:text-blue-600">
                                        <i class="fa-solid fa-gear my-auto w-1/12"></i>
                                        <p class="text-sm">Settings</p>
                                    </div>
                                </a>
                                <a class="logout-btn w-full menu-item cursor-pointer ">
                                    {{-- <div class="flex justify-left gap-6 mb-5 mt-3 bg-gradient-to-r from-blue-500 to-blue-400 px-6 py-3 rounded-lg text-white">
                                        <i class="fa-solid fa-arrow-right-from-bracket my-auto w-1/12"></i>
                                        <p class="text-sm">Log out</p>
                                    </div> --}}
                                    <div
                                        class="flex justify-left gap-6 w-full rounded-lg py-3 px-6 hover:bg-blue-50 hover:text-blue-600">
                                        <i class="fa-solid fa-arrow-right-from-bracket my-auto w-1/12"></i>
                                        <p class="text-sm">Log out</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endif
                    {{-- admin binagram --}}
                    @if (Auth::user()->role == 2)
                    <div class="flex flex-col h-full gap-3 w-full justify-between">
                        <div class="flex flex-col w-full gap-1">
                            <a href="/adminbinagram/dashboard" class="w-full menu-item">
                                <div
                                    class="flex justify-left gap-6 w-full rounded-lg py-3 px-6 hover:bg-blue-50 hover:text-blue-600">
                                    <i class="fa-solid fa-briefcase my-auto text-xs w-1/12"></i>
                                    <p class="text-sm">Daftar IKU</p>
                                </div>
                            </a>
                            <a href="/adminbinagram/approval" class="w-full menu-item">
                                <div
                                    class="flex justify-left gap-6 w-full rounded-lg py-3 px-6 hover:bg-blue-50 hover:text-blue-600">
                                    <i class="fa-solid fa-file-circle-check my-auto text-xs w-1/12"></i>
                                    <p class="text-sm">Daftar Approval</p>
                                </div>
                            </a>
                        </div>
                        <div class="">
                            <a href="/adminbinagram/settings" class="w-full menu-item">
                                <div
                                    class="flex justify-left gap-6 w-full rounded-lg py-3 px-6 hover:bg-blue-50 hover:text-blue-600">
                                    <i class="fa-solid fa-gear my-auto w-1/12"></i>
                                    <p class="text-sm">Settings</p>
                                </div>
                            </a>
                            <a class="logout-btn w-full menu-item cursor-pointer ">
                                {{-- <div class="flex justify-left gap-6 mb-5 mt-3 bg-gradient-to-r from-blue-500 to-blue-400 px-6 py-3 rounded-lg text-white">
                                    <i class="fa-solid fa-arrow-right-from-bracket my-auto w-1/12"></i>
                                    <p class="text-sm">Log out</p>
                                </div> --}}
                                <div
                                    class="flex justify-left gap-6 w-full rounded-lg py-3 px-6 hover:bg-blue-50 hover:text-blue-600">
                                    <i class="fa-solid fa-arrow-right-from-bracket my-auto w-1/12"></i>
                                    <p class="text-sm">Log out</p>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endif
                    {{-- admin approval --}}
                    @if (Auth::user()->role == 1)
                    @endif
                    {{-- operator --}}
                    @if (Auth::user()->role == 0)
                    @endif
                </div>
            </div>
        </aside>

        <!-- Content -->
        <main class="relative top-20 left-[260px] min-h-screen bg-gray-50" style="width: calc(100vw - 279px)">
            @yield('content')
        </main>

        {{-- <div class="fixed top-0 left-0 w-full h-full z-50 bg-[#0000006c]">
            @yield('popup')
        </div> --}}
    </div>
    <!-- Add your scripts here -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/sidebar.js') }}"></script>

</body>

</html>
