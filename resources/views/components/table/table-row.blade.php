@props(['class' => ''])

<tr class="border-b border-slate-200 bg-white transition hover:bg-slate-50 {{ $class }}">
    {{ $slot }}
</tr>
