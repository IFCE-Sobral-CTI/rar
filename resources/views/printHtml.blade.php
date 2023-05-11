<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <base href="{{ url('/') }}" />
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Impressão de Cartão</title>
        <link rel="icon" type="image/png" href="{{ asset('img/icon.png')}}" />

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet" />

        @viteReactRefresh
        <script src="https://cdn.tailwindcss.com"></script>
        <style>
            @page {size: 21cm 29.7cm; margin:0px !important; padding:0px !important}
        </style>
    </head>
    <body>
        @foreach ($report as $dispatches)
            <div class="grid grid-cols-2 grid-rows-5 gap-0 p-0 m-auto border print:border-0 print:m-0" style="width: 21cm; height: 29.7cm; padding-top: 0.9cm; padding-bottom: 0.9cm; padding-left: 0.5cm; padding-right: 0.5cm">
                @foreach ($dispatches as $dispatch)
                    <div class="p-0 m-0 border rounded-lg print:border-0" style="width: 9.9cm; height: 5.58cm;">
                        <div class="m-auto" style="width: 8.5cm; height: 5.4cm; padding: .2cm">
                            <div class="flex items-center justify-between">
                                <div class="">
                                    <img src="{{ asset('img/logo_vertical_branco.svg') }}" alt="IFCE" class="h-16 invert" />
                                </div>
                                <div class="flex-1 text-center">
                                    <h2 class="mb-1 text-xs uppercase">Cartão de Acesso ao<br />Restaurante Acadêmico</h2>
                                    <h2 class="text-sm font-semibold uppercase">{{ $dispatch->requirement->enrollment->student->name }}</h2>
                                </div>
                            </div>
                            <div class="flex flex-wrap justify-between text-xs uppercase">
                                <div class="flex flex-col">
                                    <span class="text-xs font-semibold">Matricula:</span> {{ $dispatch->requirement->enrollment->number }}
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-xs font-semibold">R.G.:</span> {{ $dispatch->requirement->enrollment->student->rg }}
                                </div>
                            </div>
                            <div class="flex justify-between text-xs uppercase">
                                <div class="flex flex-col flex-1">
                                    <span class="text-xs font-semibold">Curso:</span>
                                    <span class="w-56 truncate">{{ $dispatch->requirement->enrollment->course->name }}</span>
                                </div>
                                <div class="flex flex-col items-center">
                                    <span class="-mb-1 text-xs border-b border-gray-600">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                    <span class="capitalize" style="font-size: 6pt">Visto</span>
                                </div>
                            </div>
                            <div class="font-light text-justify" style="font-size: 6pt">
                                Esse cartão é de uso específico para o acesso de alunos regularmente matriculados para refeição subsidiada no Restaurante Acadêmico.
                                Seu uso é pessoal e sua transferência a outrem encorre em crime de falsidade ideológica, além de outras sanções disciplinares do ROD.
                                <span>Identificador: {{ $dispatch->id }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    </body>
</html>
