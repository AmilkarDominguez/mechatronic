<div>
    <x-slot name="header">
        <div class="font-semibold text-xl text-gray-800 leading-tight">
            Categorias
        </div>
    </x-slot>
    <div class="max-w-8xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="w-full flex justify-end space-x-2">
            @if (Auth::user()->hasAnyRole(['superadmin', 'admin']))
                <a href="{{ route('product-category.create') }}"
                   class="my-2  mx-4 border-2 border-green-500 text-green-500 bg-white flex items-center rounded-full hover:bg-green-500 hover:text-white">
                    <svg class="w-8 h-8 m-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                              d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                              clip-rule="evenodd"/>
                    </svg>
                </a>
            @endif
                {{--            <a href="{{ route('product-category.import') }}"--}}
                {{--               class="my-2  mx-4 border-2 border-green-500 text-green-500 bg-white flex items-center rounded-full hover:bg-green-500 hover:text-white">--}}
                {{--                <svg class="w-8 h-8 m-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"--}}
                {{--                     stroke-width="1.5" stroke="currentColor">--}}
                {{--                    <path stroke-linecap="round" stroke-linejoin="round"--}}
                {{--                          d="M9 8.25H7.5a2.25 2.25 0 00-2.25 2.25v9a2.25 2.25 0 002.25 2.25h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25H15m0-3l-3-3m0 0l-3 3m3-3V15"/>--}}
                {{--                </svg>--}}
                {{--            </a>--}}
        </div>
        <div class="m-5">
            <livewire:product-category.product-category-data-table/>
        </div>
    </div>

</div>
