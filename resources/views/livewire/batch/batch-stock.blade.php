<div>
    @if ($stock >= 10)
        <span
            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 uppercase">
            {{ $stock }}
        </span>
    @endif
    @if ($stock < 10  && $stock > 5)
        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 uppercase">
            {{ $stock }}
        </span>
    @endif
    @if ($stock <= 5  )
        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 uppercase">
            {{ $stock }}
        </span>
    @endif
</div>
