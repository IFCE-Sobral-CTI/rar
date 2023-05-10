<x-mail::layout>
{{-- Header --}}
<x-slot:header>
<x-mail::header :url="config('app.url')">
{{ config('app.name') }}
</x-mail::header>
</x-slot:header>

{{-- Body --}}
{{ $slot }}

{{-- Subcopy --}}
@isset($subcopy)
<x-slot:subcopy>
<x-mail::subcopy>
{{ $subcopy }}
</x-mail::subcopy>
</x-slot:subcopy>
@endisset

{{-- Footer --}}
<x-slot:footer>
<x-mail::footer>
© {{ date('Y') }} - IFCE <em>Campus</em> Sobral<br>
<small>Coordenadoria de Tecnologia da Informação</small><br>
<small>{{ config('app.name') }}</small>
</x-mail::footer>
</x-slot:footer>
</x-mail::layout>
