<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <base href="{{ url('/') }}" />
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>{{ config('app.title') }}</title>
        <link rel="icon" type="image/png" href="{{ asset('img/icon.png')}}" />
        <style>
            @page {size: 21cm 29.7cm; margin:0px !important; padding:0px !important}
        </style>
    </head>
    <body style="
        font-family: sans-serif;
        background-color: 6ad;
        margin-top: 1.8cm;
        margin-left: .5cm
    ">
        @foreach ($report as $dispatches)
            <div
                style="
                    margin: 0;
                    padding: 0;
                "
            >
                @foreach ($dispatches as $dispatch)
                    <div
                        style="
                            display: inline-block;
                            width: 9.9cm;
                            height: 5.58cm;
                        "
                    >
                        <div
                            style="
                                margin: .5cm;
                                width: 8.9cm;
                                height: 4.58cm;
                            "
                        >
                            <div
                                style="
                                    display: block;
                                    width: 8.9cm;
                                    height: 1.6cm;
                                    margin: 0;
                                    padding: 0;
                                "
                            >
                                <div
                                    style="
                                        height: 1.6cm;
                                        margin: .4cm 0 0 0;
                                        padding: .2cm 0 0 0;
                                        display: inline-block;
                                    "
                                >
                                    <img
                                        src="data:image/png;base64,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"
                                        alt="IFCE"
                                        style="
                                            margin: 0;
                                            padding: 0;
                                            height: 1.4cm;
                                            filter: invert(100%);
                                        "
                                    />
                                </div>
                                <div
                                    style="
                                        display: inline-block;
                                        width: 7.7cm;
                                        height: 1.6cm;
                                        margin: 0;
                                        padding: 0;
                                        text-align: center;
                                    "
                                >
                                    <div
                                        style="
                                            padding: 0;
                                            margin: 0 0 .3cm 0;
                                            font-size: 0.75rem;
                                            text-transform: uppercase;
                                        "
                                    >
                                        Cartão de Acesso ao<br />
                                        Restaurante Acadêmico
                                    </div>
                                    <div
                                        style="
                                            margin: 0;
                                            padding: 0;
                                            font-size: .8rem;
                                            font-weight: bold;
                                            text-transform: uppercase;
                                        "
                                    >
                                        {{ $dispatch->requirement->enrollment->student->name }}
                                    </div>
                                </div>
                            </div>
                            <div
                                style="
                                    display: block;
                                    font-size: 0.75rem;
                                    line-height: 1rem;
                                    margin: .2cm 0 0 0;
                                    padding: 0;
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
                                            font-weight: bold;
                                        "
                                    >
                                        MATRICULA:
                                    </div>
                                    <div>
                                        {{ $dispatch->requirement->enrollment->number }}
                                    </div>
                                </div>
                                <div
                                    style="
                                        display: inline-block;
                                        width: 4.45cm;
                                    "
                                >
                                    <div
                                        style="
                                            font-size: 0.75rem;
                                            line-height: 1rem;
                                            font-weight: bold;
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
                                            font-weight: bold;
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
                                    font-weight: lighter;
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
