<div class="flex space-x-1 justify-around">
    {{-- $table->enum('state', ['DRAFT','PENDING', 'COMPLETED', 'DELETED'])->default('PENDING')->nullable(); --}}

    @if ($state == 'PENDING')
        {{-- payments --}}
        <a href="{{ route('payment.dashboard', $slug) }}"
            class="p-1 text-primary-600 hover:bg-primary-600 hover:text-white rounded-full">

            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
        </a>
        {{-- end payments --}}
        {{-- view --}}
        {{-- <a href="{{ route('service-order.information', $slug) }}"
            class="p-1 text-blue-600 hover:bg-blue-600 hover:text-white rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                <path fill-rule="evenodd"
                    d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                    clip-rule="evenodd" />
            </svg>
        </a> --}}
        {{-- end view --}}
        <button title="Completar" wire:click="toastConfirmComplete('{{ $id }}')"
            class="p-1 text-green-500 hover:bg-green-500 hover:text-white rounded-full ">
            <div class="h-5 w-5 flex justify-center items-center rounded-full">
                <i class="fas fa-clipboard-check"></i>
            </div>
        </button>
        {{-- print --}}
        <a href="{{ route('service-order.print', $slug) }}" class="p-1 hover:bg-gray-600 hover:text-white rounded-full">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z"
                    clip-rule="evenodd" />
            </svg>
        </a>
        {{-- end print --}}
        {{-- edit --}}
        <a href="{{ route('service-order.update', $slug) }}"
            class="p-1 text-blue-600 hover:bg-blue-600 hover:text-white rounded-full">
            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path
                    d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
            </svg>
        </a>
        {{-- end edit --}}
        {{-- delet --}}
        {{-- <button title="Anular" wire:click="toastConfirmDelet('{{ $id }}')"
            class="p-1 text-red-600 hover:bg-red-600 hover:text-white rounded-full">
            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 000 2h6a1 1 0 100-2H7z"
                    clip-rule="evenodd" />
            </svg>
        </button> --}}
        {{-- end delet --}}
    @endif

    @if ($state == 'COMPLETED')
        {{-- print --}}
        <a href="{{ route('service-order.print', $slug) }}"
            class="p-1 hover:bg-gray-600 hover:text-white rounded-full cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z"
                    clip-rule="evenodd" />
            </svg>
        </a>
        {{-- end print --}}
        {{-- revert --}}
        <a wire:click="toastConfirmRevert('{{ $id }}')"
            class="p-1 hover:bg-gray-600 hover:text-white rounded-full cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" class="h-5 w-5" viewBox="0 0 24 24"
                stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
            </svg>
        </a>
        {{-- end revert --}}
    @endif

    @if ($state == 'DRAFT')
        {{-- print --}}
        <a href="{{ route('service-order.print-draft', $slug) }}"
            class="p-1 hover:bg-gray-600 hover:text-white rounded-full cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z"
                    clip-rule="evenodd" />
            </svg>
        </a>
        {{-- end print --}}
        <a href="{{ route('service-order.update-draft', $slug) }}"
            class="p-1 text-blue-600 hover:bg-blue-600 hover:text-white rounded-full">
            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path
                    d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
            </svg>
        </a>
        <a wire:click="toastConfirmDraftToPending('{{ $id }}')"
            class="p-1 text-green-500 hover:bg-green-600 hover:text-white rounded-full cursor-pointer">

            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                <path fill-rule="evenodd"
                    d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z"
                    clip-rule="evenodd" />
            </svg>

        </a>
    @endif

</div>
