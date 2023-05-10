@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
<img src="{{ asset('img/logo_horizontal_colorido.svg') }}" class="logo" alt="Laravel Logo" style="width: 12rem">
<h2>
    {{$slot}}
</h2>
</a>
</td>
</tr>
