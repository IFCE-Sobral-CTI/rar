<x-mail::message>
Olá <strong>{{ $dispatch->requirement->enrollment->student->name }}</strong>,

Seu requerimento de Acesso ao Restaurante Acadêmico foi analisada.

<x-mail::panel>
    <p>
        Situação do requerimento:
        <strong>
            @if($dispatch->status == 2)
                DEFERIDO
            @else
                INDEFERIDO
            @endif
        </strong>.
    </p>
</x-mail::panel>

<p>
    Dispacho:
</p>
<x-mail::panel>
    {{ $dispatch->text }}
</x-mail::panel>

<p>
    Qualquer dúvida, por favor, entrar em contato do <strong>Coordenadoria de Assistência Estudantil - CAE</strong> através dos contatos abaixo:
</p>

<x-mail::table>
    | Telefone | E-mail |
    | :- | :- |
    | <a href="tel:(88) 3112 8063">(88) 3112 8063</a> | <a href="mailto:cae.sobral@ifce.edu.br">cae.sobral@ifce.edu.br</a> |
</x-mail::table>

Atenciosamente,<br>
<strong>Departamento de Administração e Planejamento</strong>
</x-mail::message>
