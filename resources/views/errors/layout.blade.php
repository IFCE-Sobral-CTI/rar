<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>{{ config('app.name') }}</title>
        @vite(['resources/css/app.css'])
    </head>
    <body>
        <div class="w-screen h-screen flex justify-center items-center bg-neutral-200">
            <div class="m-auto w-6/12 flex justify-between gap-4 p-4 bg-white shadow-md rounded-md">
                <div class="flex justify-center items-center pt-4 pb-4 pl-4">
                    <img
                        src="{{ asset('img/logo_vertical_colorido.svg') }}"
                        alt="IFCE - Campus Sobral"
                        class="w-36"
                    >
                </div>
                <div class="flex flex-col gap-4 items-center justify-between text-center flex-1 pt-4 pb-4 pr-4">
                    <div class="flex flex-col flex-1 w-full gap-4 text-neutral-700">
                        <h1 class="text-7xl font-extrabold">
                            @yield('error')
                        </h1>
                        <div class="w-full pt-2 font-light text-lg">
                            @yield('text')
                        </div>
                    </div>
                    <div class="">
                        <a
                            href="{{ route('home') }}"
                            class="inline-flex gap-2 items-center px-4 py-2 border border-transparent tracking-widest text-sm rounded-lg text-white transition ease-in-out duration-150 focus:ring-2 bg-green hover:bg-green-dark focus:ring-green-300"
                        >
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 16 16" class="h-5 w-5">
                            <path fill="currentColor" d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.707 1.5ZM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5l5 5Z"/>
                        </svg>
                            Página Inicial
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
