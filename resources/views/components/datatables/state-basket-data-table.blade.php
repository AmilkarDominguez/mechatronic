<div>
    @if ($state_baskets == 'ACTIVE')
        <span
            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 uppercase">
            ACTIVO
        </span>
    @endif
    @if ($state_baskets == 'INACTIVE')
        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 uppercase">
            INACTIVO
        </span>
    @endif
    @if ($state_baskets == 'DELETED')
        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 uppercase">
            ELIMINADO
        </span>
    @endif
</div>
