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
    <div class="wrapper">
        <!-- Header -->
        <header
            class="flex items-center justify-between py-4 px-10 h-20 fixed left-0 bg-white z-20 top-0 w-full border-b-2">
            <img src="{{ asset('assets/logo.png') }}" class="w-16" />
            <div class="flex items-center gap-6">
                <i class="fa-regular fa-bell cursor-pointer text-lg"></i>
                <i class="fa-solid fa-arrow-right-from-bracket cursor-pointer text-lg"></i>
                <div
                    class="flex items-center justify-center text-white rounded-full bg-gray-700 w-7 h-7 text-xs cursor-pointer">
                    A</div>
            </div>
        </header>


        <!-- Sidebar -->
        <aside class="top-20 fixed left-0 w-[250px] p-5 border-r-2 z-10" style="height: calc(100vh - 80px)">
            <div class="w-full h-full flex flex-col overflow-x-hidden">
                <div class="flex gap-4 items-center mb-10">
                    <div
                        class="flex items-center justify-center text-white rounded-full bg-gray-700 w-8 h-8 text-xs cursor-pointer">
                        A</div>
                    <div>
                        <p class="font-medium text-md">John Doe</p>
                        <p class="font-light text-sm text-start">
                            Admin
                        </p>
                    </div>
                </div>
                <div class="flex flex-col gap-4 w-full pl-4">
                    <div class="flex w-full gap-2 opacity-30">
                        <i class="fa-solid fa-angle-down my-auto text-sm w-1/12"></i>
                        <p class="text-sm font-medium uppercase">User Management</p>
                    </div>
                    <a href="">
                        <div class="flex justify-left gap-6 w-full rounded-xl py-3 px-6 bg-blue-50 text-blue-600">
                            <i class="fa-solid fa-user my-auto text-sm w-1/12"></i>
                        </div>
                    </a>
                    <a href="">
                        <div class="flex justify-left gap-6 w-full rounded-xl py-3 px-6 bg-blue-50 text-blue-600">
                            <i class="fa-solid fa-user my-auto text-sm w-1/12"></i>
                            <p class="text-sm font-medium">Bidang Management</p>
                        </div>
                    </a>
                    {{-- <a href="">
                        <div
                            class="flex justify-left gap-6 w-full rounded-xl py-3 px-6 hover:bg-blue-50 hover:text-blue-600">
                            <i class="fa-solid fa-plus my-auto text-sm w-1/12"></i>
                            <p class="text-sm font-medium">Tambah Iku</p>
                        </div>
                    </a> --}}
                </div>
            </div>
        </aside>

        <!-- Content -->
        <main class="relative top-20 left-[250px] h-[1000vh]" style="width: calc(100vw - 267px)">
            @yield('content')
        </main>
    </div>
    <!-- Add your scripts here -->
    <script src="{{ asset('js/app.js') }}"></script>

</body>

</html>
