<div class="flex space-x-1 justify-around">

    {{-- view --}}
    <a href="{{ route('pre-sale.information', $slug) }}"
        class="p-1 text-blue-600 hover:bg-blue-600 hover:text-white rounded-md">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
            <path fill-rule="evenodd"
                d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                clip-rule="evenodd" />
        </svg>
    </a>
    {{-- end view --}}

    {{-- print --}}
    <a href="{{ route('pre-sale.print', $slug) }}" class="p-1 hover:bg-gray-600 hover:text-white rounded-md">

        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd"
                d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z"
                clip-rule="evenodd" />
        </svg>
    </a>
    {{-- end print --}}
   {{-- delet --}}
   <button wire:click="toastConfirmDelet('{{ $id }}')"
   class="p-1 text-red-600 hover:bg-red-600 hover:text-white rounded-md">
   <svg  class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
       <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 000 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
   </svg>
</button>
{{-- end delet --}}
</div>
