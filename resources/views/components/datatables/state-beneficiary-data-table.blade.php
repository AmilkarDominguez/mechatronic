<div>
    @if ($beneficiary_states_name == 'HABILITADO')
        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-lime-300 text-lime-600 uppercase">
            HABILITADO
        </span>
    @endif
    @if ($beneficiary_states_name == 'PRE-INSCRIBIDO')
        <span
            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-600 uppercase">
            PRE-INSCRIBIDO
        </span>
    @endif
    @if ($beneficiary_states_name == 'OBSERVADO')
        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-cyan-100 text-cyan-600 uppercase">
            OBSERVADO
        </span>
    @endif
    @if ($beneficiary_states_name == 'SUSPENSIÓN TEMPORAL')
        <span
            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-orange-100 text-orange-600 uppercase">
            SUSPENSIÓN TEMPORAL
        </span>
    @endif
    @if ($beneficiary_states_name == 'EXTINGUIDO')
        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-600 uppercase">
            EXTINGUIDO
        </span>
    @endif
</div>
