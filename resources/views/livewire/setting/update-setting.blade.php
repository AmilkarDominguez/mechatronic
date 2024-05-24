<div>
    <x-slot name="header">
        <div class="font-semibold text-xl text-gray-800 leading-tight">
            Configuración
        </div>
    </x-slot>
    <div class="max-w-8xl mx-auto py-10 sm:px-6 lg:px-8">
        <form wire:submit.prevent="submit" class="m-10 mt-0 p-4">
            {{-- name --}}
            <div class="mt-4 text-sm">Nombre</div>
            <x-jet-input type="text" placeholder="Nombre" wire:model="name" class="mt-1 block w-full rounded-md" />
            @error('name')
                <p class="text-red-500 font-semibold my-2">
                    {{ $message }}
                </p>
            @enderror
            {{-- end name --}}
            {{-- description --}}
            <div class="mt-4 text-sm">Descripción</div>
            <x-textarea placeholder="Descripción" wire:model="description" class="mt-1 block w-full" />
            @error('description')
                <p class="text-red-500 font-semibold my-2">
                    {{ $message }}
                </p>
            @enderror
            {{-- end description --}}
            {{-- email --}}
            <div class="mt-4 text-sm">Correo</div>
            <x-jet-input type="email" placeholder="Correo" wire:model="email" class="mt-1 block w-full rounded-md" />
            @error('email')
                <p class="text-red-500 font-semibold my-2">
                    {{ $message }}
                </p>
            @enderror
            {{-- end email --}}
            {{-- telephone --}}
            <div class="mt-4 text-sm">Teléfono</div>
            <x-jet-input type="tel" placeholder="Teléfono" wire:model="telephone"
                class="mt-1 block w-full rounded-md" />
            @error('telephone')
                <p class="text-red-500 font-semibold my-2">
                    {{ $message }}
                </p>
            @enderror
            {{-- end telephone --}}
            {{-- nro_whatsapp --}}
            <div class="mt-4 text-sm">Nro. Whatsapp</div>
            <x-jet-input type="tel" placeholder="Nro whatsapp" wire:model="nro_whatsapp"
                class="mt-1 block w-full rounded-md" />
            @error('nro_whatsapp')
                <p class="text-red-500 font-semibold my-2">
                    {{ $message }}
                </p>
            @enderror
            {{-- end nro_whatsapp --}}
            {{-- url_facebook --}}
            <div class="mt-4 text-sm">Facebook</div>
            <x-jet-input type="text" placeholder="Enlace facebook" wire:model="url_facebook"
                class="mt-1 block w-full rounded-md" />
            @error('url_facebook')
                <p class="text-red-500 font-semibold my-2">
                    {{ $message }}
                </p>
            @enderror
            {{-- end url_facebook --}}
            {{-- url_instagram --}}
            <div class="mt-4 text-sm">Instagram</div>
            <x-jet-input type="text" placeholder="Enlace instagram" wire:model="url_instagram"
                class="mt-1 block w-full rounded-md" />
            @error('url_instagram')
                <p class="text-red-500 font-semibold my-2">
                    {{ $message }}
                </p>
            @enderror
            {{-- end url_instagram --}}
            {{-- url_website --}}
            <div class="mt-4 text-sm">Sitio Web</div>
            <x-jet-input type="text" placeholder="Enlace instagram" wire:model="url_website"
                class="mt-1 block w-full rounded-md" />
            @error('url_website')
                <p class="text-red-500 font-semibold my-2">
                    {{ $message }}
                </p>
            @enderror
            {{-- end url_website --}}
            {{-- address --}}
            <div class="mt-4 text-sm">Dirección</div>
            <x-jet-input type="text" placeholder="Dirección" wire:model="address"
                class="mt-1 block w-full rounded-md" />
            @error('address')
                <p class="text-red-500 font-semibold my-2">
                    {{ $message }}
                </p>
            @enderror
            {{-- end address --}}
            {{-- current images --}}
            <div class="mt-4 text-sm">Logo actual</div>
            <div class="flex space-x-4">
                <img class="object-cover h-32 w-32 rounded-lg border border-primary-100 border-dashed"
                    src="{{ asset('/storage/setting-logo/logo-setting.png') }}" alt="logo">
            </div>
            {{-- end current images --}}
            {{-- logo --}}
            <div class="mt-4 text-sm">Logo</div>
            @if ($new_logo)
                <div class="mt-2">
                    <img class="object-cover h-60 w-60 rounded-lg" src="{{ $new_logo->temporaryUrl() }}">
                </div>
            @else
                <div
                    class="flex flex-col w-60 h-60 items-center justify-center bg-gray-100 rounded-lg border border-primary-500 border-dashed text-gray-500">

                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <p class="text-xs pt-1">
                        Solo formato PNG hasta 10MB
                    </p>
                </div>
            @endif

            <div class="my-4 w-60 flex items-center justify-center">
                <label
                    class="w-60 py-2 px-2 flex items-center justify-center bg-primary-700 hover:bg-primary-900 text-white rounded-md cursor-pointer ">
                    <svg class="w-6 h-6 m-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                    </svg>
                    <span class="text-base leading-normal">Seleccionar archivos</span>
                    <input type="file" wire:model="new_logo" accept="image/png" class="hidden" />
                </label>
            </div>

            @error('new_logo')
                <p class="text-red-500 font-semibold my-2">
                    {{ $message }}
                </p>
            @enderror
            {{-- end logo --}}
            {{-- print_logo --}}
            <x-jet-label class="mt-2" value="Mostrar en impresion" />
            <div class="mt-4 space-y-2">
                <div class="flex items-center">
                    <input wire:model="print_logo" value="1" type="radio"
                           class="focus:ring-primary-500 h-4 w-4 text-primary-600 border-gray-300">
                    <label for="push_everything" class="ml-2 block text-sm font-medium text-gray-700">
                        Si
                    </label>
                </div>
                <div class="flex items-center">
                    <input wire:model="print_logo" value="0" type="radio"
                           class="focus:ring-primary-500 h-4 w-4 text-primary-600 border-gray-300">
                    <label for="push_email" class="ml-2 block text-sm font-medium text-gray-700">
                        No
                    </label>
                </div>
            </div>
            {{-- end print_logo --}}
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
            <x-jet-button type="submit"
                class="mt-4 h-12 bg-primary-700 text-white rounded-md cursor-pointer w-full flex items-center justify-center">
                Guardar
            </x-jet-button>
        </form>
    </div>
</div>
