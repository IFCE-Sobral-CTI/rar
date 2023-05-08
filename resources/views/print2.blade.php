<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <base href="{{ url('/') }}" />
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>{{ config('app.title') }}</title>
        <link rel="icon" type="image/png" href="{{ asset('img/icon.png')}}" />
        <!-- @viteReactRefresh -->
    </head>
    <body style="font-family: sans-serif; margin: 0; padding: 0; box-sizing: border-box;">
        @foreach ($report as $dispatches)
            <div
                style="
                    margin: 0px;
                    padding: 0px;
                    width: 21cm;
                    height: 29.7cm;
                    padding-top: 0.9cm;
                    padding-bottom: 0.9cm;
                    padding-left: 0.5cm;
                    padding-right: 0.5cm;
                "
            >
                @foreach ($dispatches as $dispatch)
                    <div
                        style="
                            display: inline-block;
                            border-width: 0px;
                            margin: 0px;
                            padding: 0px;
                            width: 9.9cm;
                            height: 5.58cm;
                        "
                    >
                        <div
                            style="
                                margin: auto;
                                width: 8.5cm;
                                height: 5.4cm;
                                padding: .2cm
                            "
                        >
                            <div
                                style="
                                    display: block;
                                "
                            >
                                <div
                                    style="
                                        display: inline-block;
                                    "
                                >
                                    <img
                                        src="{{ asset('img/logo_vertical_branco.png') }}"
                                        alt="IFCE"
                                        style="
                                            width: 1.3cm;
                                            filter: invert(100%)
                                        "
                                    />
                                </div>
                                <div
                                    style="
                                        display: inline-block;
                                        width: 7cm;
                                        text-align: center;
                                    "
                                >
                                    <h2
                                        style="
                                            margin-bottom: 0.25rem;
                                            font-size: 0.75rem;
                                            line-height: 1rem;
                                            text-transform: uppercase;
                                        "
                                    >
                                        Cartão de Acesso ao<br />
                                        Restaurante Acadêmico
                                    </h2>
                                    <h2
                                        style="
                                            font-size: 0.75rem;
                                            line-height: 1rem;
                                            font-weight: 600;
                                            text-transform: uppercase;
                                        "
                                    >
                                        {{ $dispatch->requirement->enrollment->student->name }}
                                    </h2>
                                </div>
                            </div>
                            <div
                                style="
                                    display: block;
                                    font-size: 0.75rem;
                                    line-height: 1rem;
                                    text-transform: uppercase;
                                "
                            >
                                <div
                                    style="
                                        display: inline-block;
                                        width: 49%;
                                    "
                                >
                                    <div
                                        style="
                                            font-size: 0.75rem;
                                            line-height: 1rem;
                                            font-weight: 600;
                                        "
                                    >
                                        Matricula:
                                    </div>
                                    <div>
                                        {{ $dispatch->requirement->enrollment->number }}
                                    </div>
                                </div>
                                <div
                                    style="
                                        display: inline-block;
                                        width: 49%;
                                    "
                                >
                                    <div
                                        style="
                                            font-size: 0.75rem;
                                            line-height: 1rem;
                                            font-weight: 600;
                                        "
                                    >
                                        R.G.:
                                    </div>
                                    <div>
                                        {{ $dispatch->requirement->enrollment->student->rg }}
                                    </div>
                                </div>
                            </div>
                            <div
                                style="
                                    display: block;
                                    font-size: 0.75rem;
                                    line-height: 1rem;
                                    text-transform: uppercase;
                                "
                            >
                                <div
                                    style="
                                        display: inline-block;
                                        width: 5.95cm
                                    "
                                >
                                    <div
                                        style="
                                            font-size: 0.75rem;
                                            line-height: 1rem;
                                            font-weight: 600;
                                        "
                                    >
                                        Curso:
                                    </div>
                                    <div
                                        style="
                                            width: 14rem;
                                            overflow: hidden;
                                            text-overflow: ellipsis;
                                            white-space: nowrap;
                                        "
                                    >{{ $dispatch->requirement->enrollment->course->name }}</div>
                                </div>
                                <div
                                    style="
                                        display: inline-block;
                                    "
                                >
                                    <div
                                        style="
                                            margin-bottom: -0.25rem;
                                            font-size: 0.75rem;
                                            line-height: 1rem;
                                            border-bottom: 1px solid rgb(75 85 99);
                                        "
                                    >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div>
                                    <div
                                        style="
                                            font-size: 6pt;
                                            text-transform: capitalize;
                                            text-align: center;
                                        "
                                    >
                                            Visto
                                    </div>
                                </div>
                            </div>
                            <div
                                style="
                                    font-size: 0.5rem;
                                    font-weight: 300;
                                    text-align: justify;
                                "
                            >
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
