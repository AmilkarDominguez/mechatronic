<div>
    <x-slot name="header">
        <div class="font-semibold text-xl text-gray-800 leading-tight">
            Actualizar género
        </div>
    </x-slot>
    <div class="max-w-8xl mx-auto py-10 sm:px-6 lg:px-8">
        <form wire:submit.prevent="submit" class="m-10 mt-0 p-4">
            {{-- name --}}
            <div class="mt-4 text-sm">
                Nombre
            </div>
            <x-jet-input onkeyup="this.value = this.value.toUpperCase();" type="text" placeholder="Nombre"
                wire:model="name" class="mt-1 block w-full rounded-rm" required />
            @error('name')
                <p class="text-red-500 font-semibold my-2">
                    {{ $message }}
                </p>
            @enderror
            {{-- end name --}}

            {{-- title --}}
            <x-jet-label class="mt-2" for="title" value="{{ __('Título') }}" />
            <x-jet-input type="text" placeholder="Titulo" wire:model="title" wire:keyup="generateSlug"
                class="mt-1 block w-full rounded-md" required />
            @error('title')
                <p class="text-red-500 font-semibold my-2">
                    {{ $message }}
                </p>
            @enderror
            {{-- end title --}}

            {{-- description --}}
            Descripción
            <x-textarea placeholder="Descripción" wire:model="description" class="mt-1 block w-full" />
            @error('description')
                <p class="text-red-500 font-semibold my-2">
                    {{ $message }}
                </p>
            @enderror
            {{-- end description --}}

            {{-- state --}}
            <x-jet-label class="mt-4 text-sm" value="Estado" />
            <div class="mt-4 space-y-2">
                <div class="flex items-center">
                    <input wire:model="state" value="ACTIVE" type="radio"
                        class="focus:ring-primary-500 h-4 w-4 text-primary-600 border-gray-300">
                    <label for="push_everything" class="ml-2 block text-sm font-medium text-gray-700">
                        Activo
                    </label>
                </div>
                <div class="flex items-center">
                    <input wire:model="state" value="INACTIVE" type="radio"
                        class="focus:ring-primary-500 h-4 w-4 text-primary-600 border-gray-300">
                    <label for="push_email" class="ml-2 block text-sm font-medium text-gray-700">
                        Inactivo
                    </label>
                </div>
            </div>
            {{-- end state --}}

            {{-- current images --}}
            <x-jet-label class="mt-2 mb-2" value="{{ __('Imágenes actuales') }}" />
            <div class="flex space-x-4">

                <img class="object-cover h-32 w-32 rounded-lg border border-primary-100 border-dashed"
                    src="../../{{ $photo }}">
                <img class="object-cover h-32 w-32 rounded-lg border border-primary-100 border-dashed"
                    src="../../{{ $icon }}">
            </div>
            {{-- end current images --}}

            {{-- photo --}}
            <x-jet-label class="mt-2 mb-2" value="{{ __('Imagen') }}" />
            @if ($photo_new)
                <div class="mt-2">

                    <img class="object-cover h-60 w-60 rounded-lg" src="{{ $photo_new->temporaryUrl() }}">

                </div>
            @else
                <div
                    class="flex flex-col w-60 h-60 items-center justify-center bg-gray-100 rounded-lg border border-primary-500 border-dashed text-gray-500">

                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <p class="text-xs pt-1">
                        PNG, JPG, GIF hasta 10MB
                    </p>
                </div>
            @endif

            <div class="my-4 w-60 flex items-center justify-center">
                <label
                    class="w-60 py-2 px-2 flex items-center justify-center  bg-primary-500 text-white rounded-md cursor-pointer hover:bg-primary-400 hover:border-primary-800">
                    <svg class="w-6 h-6 m-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                    </svg>
                    <span class="text-base leading-normal">Seleccionar archivo</span>

                    <input type="file" wire:model="photo_new" accept="image/png, image/jpeg" class="hidden" />

                </label>
            </div>

            @error('photo_new')
                <p class="text-red-500 font-semibold my-2">
                    {{ $message }}
                </p>
            @enderror
            {{-- end photo --}}

            {{-- icon --}}
            <x-jet-label class="mt-2 mb-2" value="{{ __('Icono') }}" />
            @if ($icon_new)
                <div class="mt-2">

                    <img class="object-cover w-60 h-60 rounded-lg" src="{{ $icon_new->temporaryUrl() }}">

                </div>
            @else
                <div
                    class="flex flex-col w-60 h-60 items-center justify-center bg-gray-100 rounded-lg border border-primary-500 border-dashed text-gray-500">

                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <p class="text-xs pt-1">
                        SVG hasta 10MB
                    </p>
                </div>
            @endif

            <div class="my-4 w-60 flex items-center justify-center">
                <label
                    class="w-60 py-2 px-2 flex items-center justify-center  bg-primary-500 text-white rounded-md cursor-pointer hover:bg-primary-400 hover:border-primary-800">
                    <svg class="w-6 h-6 m-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                    </svg>
                    <span class="text-base leading-normal">Seleccionar archivo</span>

                    <input type="file" wire:model="icon_new" accept=".svg" class="hidden" />

                </label>
            </div>

            @error('icon_new')
                <p class="text-red-500 font-semibold my-2">
                    {{ $message }}
                </p>
            @enderror
            {{-- end icon --}}

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
                class=" mt-4 text-sm h-12 w-full  bg-primary-500 rounded-rm flex items-center justify-center">
                Guardar
            </x-jet-button>
        </form>
    </div>
</div>
