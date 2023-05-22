<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <base href="{{ url('/') }}" />
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Relatório de Requerimentos</title>
        <link rel="icon" type="image/png" href="{{ asset('img/icon.png')}}" />

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet" />

        @viteReactRefresh
        <script src="https://cdn.tailwindcss.com"></script>
        <style>
            @page {size: 29.7cm 21cm; margin: 0px !important; padding: 0px !important}
        </style>
    </head>
    <body class="text-neutral-700 mx-6">
        <table class="w-full table-auto box-border">
            <thead>
                <tr>
                    <td class="flex flex-col justify-center items-center w-full pt-6">
                        <img
                            src="{{ asset('img/logo_horizontal_colorido.svg') }}"
                            alt="IFCE - Campus Sobral"
                            class="h-10"
                        />
                        <h1 class="text-xl font-semibold uppercase">Relatório de Requerimentos</h1>
                        <div>
                            <ul class="flex gap-2">
                                @if (isset($filters['type']))
                                    <li class="flex flex-col justify-center items-center">
                                        <span class="font-light text-sm border-b border-neutral-500">Tipo de requerimento</span>
                                        <span class="">{{ $filters['type'] }}</span>
                                    </li>
                                @endif

                                @if (isset($filters['status']))
                                    <li class="flex flex-col justify-center items-center">
                                        <span class="font-light text-sm border-b border-neutral-500">Situação</span>
                                        <span class="">{{ $filters['status'] }}</span>
                                    </li>
                                @endif

                                @if (isset($filters['course']))
                                    <li class="flex flex-col justify-center items-center">
                                        <span class="font-light text-sm border-b border-neutral-500">Tipo de Curso</span>
                                        <span class="">{{ $filters['course'] }}</span>
                                    </li>
                                @endif

                                @if (isset($filters['semester']))
                                    <li class="flex flex-col justify-center items-center">
                                        <span class="font-light text-sm border-b border-neutral-500">Semestre</span>
                                        <span class="">{{ $filters['semester'] }}</span>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <table class="w-full table-auto text-neutral-600">
                            <thead>
                                <tr>
                                    <th class="px-1 pt-3 font-semibold text-left">#</th>
                                    <th class="px-1 pt-3 font-semibold text-left">Discente</th>
                                    <th class="px-1 pt-3 font-semibold text-left">Matricula</th>
                                    <th class="px-1 pt-3 font-semibold text-left">Curso</th>
                                    <th class="px-1 pt-3 font-semibold text-left">Tipo de Requerimento</th>
                                    <th class="px-1 pt-3 font-semibold text-left">Situação</th>
                                    <th class="px-1 pt-3 font-semibold text-left">Semestre</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($requirements as $requirement)
                                    <tr class="border-t border-neutral-400 transition hover:bg-neutral-100">
                                        <td class="px-1 py-1 font-light">{{ $loop->index + 1 }}</td>
                                        <td class="px-1 py-1 font-light">{{ $requirement->enrollment->student->name }}</td>
                                        <td class="px-1 py-1 font-light">{{ $requirement->enrollment->number }}</td>
                                        <td class="px-1 py-1 font-light">{{ $requirement->enrollment->course->name }}</td>
                                        <td class="px-1 py-1 font-light">{{ $requirement->requirementType->description }}</td>
                                        <td class="px-1 py-1 font-light">{{ $requirement->getStatus() }}</td>
                                        <td class="px-1 py-1 font-light">{{ $requirement->semester->description }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td class="text-xs font-light w-full py-1">
                        Relatório obtido em: <span class="font-semibold">{{ now()->format('d/m/Y H:i:s') }}</span>. Por <span class="font-semibold">{{ $user }}</span>. Total de registros: <span class="font-semibold">{{ $requirements->count() }}</span>
                    </td>
                </tr>
            </tfoot>
        </table>
    </body>
</html>
