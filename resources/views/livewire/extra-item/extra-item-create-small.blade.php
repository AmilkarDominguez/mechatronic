<div class="w-full">

    <form wire:submit.prevent="submit" class="w-full flex flex-col">
        {{-- name --}}
        <div class="">
            Nombre
        </div>
        <x-jet-input type="text" placeholder="Nombre" wire:model="name" class="mt-1 block w-full rounded-md" required />
        @error('name')
            <p class="text-red-500 font-semibold my-2">
                {{ $message }}
            </p>
        @enderror
        {{-- end name --}}

        {{-- cost --}}
        <div class="mt-2">
            Costo
        </div>
        <x-jet-input type="number" step="0.01" placeholder="00.00" wire:model="cost"
            class="mt-1 block w-full rounded-md" required />
        @error('cost')
            <p class="text-red-500 font-semibold my-2">
                {{ $message }}
            </p>
        @enderror
        {{-- end cost --}}
        {{-- price --}}
        <div class="my-2">
            Precio
        </div>
        <x-jet-input type="number" step="0.01" placeholder="00.00" wire:model="price"
            class="mt-1 block w-full rounded-md" required />
        @error('price')
            <p class="text-red-500 font-semibold my-2">
                {{ $message }}
            </p>
        @enderror
        {{-- end price --}}
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
            class="mt-4 h-12 w-full bg-primary-500 rounded-rm flex items-center justify-center">
            Guardar
        </x-jet-button>
    </form>

</div>
