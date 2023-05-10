<x-mail::message>
Olá <strong>{{ $requirement->enrollment->student->name }}</strong>,

Recebemos seu requerimento de acesso ao Restaurante Acadêmico:

<x-mail::table>
    | Nome |
    | :- |
    | {{ $requirement->enrollment->student->name }} |
</x-mail::table>

<x-mail::table>
    | Matricula |
    | :- |
    | {{ $requirement->enrollment->number }} |
</x-mail::table>

<x-mail::table>
    | Curso |
    | :- |
    | {{ $requirement->enrollment->course->name }} |
</x-mail::table>

<x-mail::table>
    | Tipo de requerimento |
    | :- |
    | {{ $requirement->requirementType->description }} |
</x-mail::table>

<p>
    Seu pedido será analizado em breve, assim que for feito o dispacho do seu requerimento você será notificado por e-mail.
</p>

@if ($requirement->requirementType->printable)
<x-mail::panel>
    Os cartões de acesso ao Restaurante Acadêmico do IFCE, campus de Sobral,
    <strong>serão produzidos de acordo com a disponibilidade e demanda da empresa contratada</strong>.
</x-mail::panel>
<x-mail::panel>
    Lembramos que a entrega do Cartão de Acesso ao Restaurante estará condicionada à <strong>apresentação</strong>
    de um documento de <strong>identificação oficial com foto</strong> na recepção geral do campus.
</x-mail::panel>
@endif

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
