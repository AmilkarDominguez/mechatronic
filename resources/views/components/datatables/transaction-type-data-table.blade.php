<div>
    @if ($type == 'INGRESO')
        <span
            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 uppercase">
            INGRESO
        </span>
    @endif
    @if ($type == 'EGRESO')
        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 uppercase">
            EGRESO
        </span>
    @endif
</div>
