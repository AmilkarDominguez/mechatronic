<div>
    <x-slot name="header">
        <div class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('menu.multimedia') }}
        </div>
    </x-slot>
    <div class="max-w-8xl mx-auto py-10 sm:px-6 lg:px-8">
        <x-card-component>
            @slot('title')
            @endslot
            @slot('content')

                <form wire:submit.prevent="submit" class="lg:m-10 p-4">

                    <h2 class=" text-xl"><span class="opacity-70">Galería de:</span> {{ $product->name }}</h2>


                    {{-- multimedia --}}
                    <x-jet-label class="mt-2 mb-2"  value="{{ __('Imagen') }}" />
                    @if ($multimedia)
                        <div class="mt-2 flex justify-center">
                            <img class="object-cover h-60 w-60 rounded-lg" src="{{ $multimedia->temporaryUrl() }}">
                            <label
                                class="absolute mt-48 w-60 py-2 px-2 flex justify-center bg-black text-white cursor-pointer hover:bg-primary-500 opacity-70">

                                <span class="text-base leading-normal">Cambiar archivo</span>

                                <input type="file" wire:model="multimedia" accept="image/png, image/jpeg" class="hidden" />
                                <div wire:loading wire:target="multimedia">Subiendo...</div>
                            </label>
                        </div>
                    @else
                        <div class=" flex justify-center">
                            <div
                                class="flex flex-col w-60 h-60 items-center justify-center bg-gray-100 rounded-lg border border-primary-500 border-dashed text-gray-500">

                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                                    viewBox="0 0 48 48" aria-hidden="true">
                                    <path
                                        d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <label class="w-60 py-2 px-2 flex justify-center text-primary-500 cursor-pointer">
                                    <span class="text-base leading-normal">Seleccionar archivo</span>
                                    <input type="file" wire:model="multimedia" accept="image/png, image/jpeg"
                                        class="hidden" />
                                </label>

                                <p class="text-xs pt-1">
                                    PNG, JPG hasta 10MB
                                </p>
                            </div>
                        </div>

                    @endif


                    @error('multimedia')
                        <p class="text-red-500 font-semibold my-2">
                            {{ $message }}
                        </p>
                    @enderror
                    {{-- end multimedia --}}






                    {{-- all errors --}}
                    @if ($errors->any())
                        <div class="bg-red-100 rounded-md text-red-500 p-2 font-semibold my-2">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    {{-- end all errors --}}
                    <div class=" flex justify-center mt-5">
                        <x-jet-button type="submit" class="h-12 w-64 rounded-fx flex items-center justify-center">
                            AGREGAR
                        </x-jet-button>
                    </div>

                </form>

            @endslot
        </x-card-component>

        <div class="flex flex-col pt-5">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="overflow-hidden bg-white">
                        <div class=" min-w-full">

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-2">



                                @forelse ($product->multimedias as $item)
                                    <div class="flex justify-end" draggable="true">
                                        <img class="object-cover h-80 w-auto" src="{{ asset($item->path) }}">

                                        <div wire:click="toastConfirmDelet({{ $item->id }})" class="absolute w-auto py-2 px-2 flex justify-center bg-red-500 text-white
                                cursor-pointer opacity-50 hover:opacity-100">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </div>


                                        {{-- <div class="absolute mt-6">
                                            <label class="mt-64 w-auto py-2 px-2 flex justify-center bg-black text-white
                                cursor-pointer hover:bg-primary-500 opacity-70">
                                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3
                                14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                                </svg>
                                                <input type="file" wire:model="{{ $item }}"
                                                    accept="image/png, image/jpeg" class="hidden" />
                                            </label>
                                        </div> --}}




                                    </div>
                                @empty
                                    <p class="p-2 block text-center">No se encuentran
                                        registros.</p>
                                @endforelse

                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>




        {{-- table --}}
        {{-- <div class="flex flex-col pt-5">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-400 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>

                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Imagen
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Fecha de registro
                                    </th>
                                    <th scope="col" class="text-right px-6 py-3">
                                        Quitar
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">

                                @forelse ($product->images as $item)
                                    <tr>

                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <img class="h-24 w-24 rounded" src="{{ asset($item->path) }}">
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $item->created_at }}</div>
                                        </td>



                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">


                                            <x-a-component class="bg-red-600 hover:bg-red-500 rounded-full h-15 w-15"
                                                wire:click="deleteModal({{ $item->id }})">
                                                <svg width=15px fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </x-a-component>

                                        </td>


                                    </tr>

                                @empty
                                    <tr>
                                        <td colspan="4">
                                            <p class="p-2 block text-center">No se encuentran registros.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="m-2">
                            {{ $list->links() }}
                        </div>
                    </div>


                </div>
            </div>
        </div> --}}
        {{-- end table --}}
    </div>




</div>
