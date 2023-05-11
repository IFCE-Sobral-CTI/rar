<x-mail::message>
Olá,

Foi gerado um novo arquivo para impressão dos cartões para o restaurante.

<x-mail::button :url="route('reports.html.token', $token)" :color="'success'">
Visualizar Arquivo
</x-mail::button>

<small style="display: block; text-align: center; margin-top: -1rem">
    * Link de acesso ao relatório tem validade de 24 horas.
</small>

<p style="margin-top: 2rem">
    Atenciosamente,<br>
    <strong>{{ $report->user->name }}</strong>
</p>
</x-mail::message>
