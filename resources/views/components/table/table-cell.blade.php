@props(['align' => 'left', 'class' => '', 'wrap' => false])

<td class="px-4 py-3 align-middle text-sm text-slate-600 {{ $align === 'center' ? 'text-center' : '' }} {{ $wrap ? 'whitespace-normal break-words' : 'whitespace-nowrap' }} {{ $class }}">
    {{ $slot }}
</td>
