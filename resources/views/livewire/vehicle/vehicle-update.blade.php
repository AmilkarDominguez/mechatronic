<div>
    <x-slot name="header">
        <div class="font-semibold text-xl text-gray-800 leading-tight">
            Registrar vehículo
        </div>
    </x-slot>
    <div class="max-w-8xl mx-auto py-10 sm:px-6 lg:px-8">
        <form wire:submit.prevent="submit" class="m-10 mt-0 p-4">
            {{-- select customer --}}
            <div wire:ignore>
                <div class="">
                    Clientes
                </div>
                <select id="select-customers" wire:model="customer_id"
                    class="border-gray-300 focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50 shadow-sm mt-1 block w-full rounded-fx rounded-md"
                    required>
                    <option selected>(Seleccionar)</option>
                    @forelse ($customers as $item)
                        <option value="{{ $item->id }}">
                            CI: {{ $item->person->ci }} | NIT: {{ $item->nit }} | Nombre:
                            {{ $item->person->name }} </option>
                    @empty
                        <option disabled>Sin registros</option>
                    @endforelse
                </select>
                @error('customer_id')
                    <p class="text-red-500 font-semibold my-2">
                        {{ $message }}
                    </p>
                @enderror
            </div>
            {{-- end customer --}}
            {{-- license_plate --}}
            <div class="">
                Placa
            </div>
            <x-jet-input type="text" placeholder="Placa" wire:model="license_plate"
                class="mt-1 block w-full rounded-md" required />
            @error('license_plate')
                <p class="text-red-500 font-semibold my-2">
                    {{ $message }}
                </p>
            @enderror
            {{-- end license_plate --}}

            {{-- brand --}}
            <div class="">
                Marca
            </div>
            <x-jet-input type="text" placeholder="Marca" wire:model="brand" class="mt-1 block w-full rounded-md"
                required />
            @error('brand')
                <p class="text-red-500 font-semibold my-2">
                    {{ $message }}
                </p>
            @enderror
            {{-- end brand --}}

            {{-- model --}}
            <div class="">
                Marca
            </div>
            <x-jet-input type="text" placeholder="Modelo" wire:model="model" class="mt-1 block w-full rounded-md"
                required />
            @error('model')
                <p class="text-red-500 font-semibold my-2">
                    {{ $message }}
                </p>
            @enderror
            {{-- end model --}}

            {{-- displacement --}}
            <div class="">
                Cilindrada
            </div>
            <x-jet-input type="text" placeholder="Cilindrada" wire:model="displacement"
                class="mt-1 block w-full rounded-md" required />
            @error('displacement')
                <p class="text-red-500 font-semibold my-2">
                    {{ $message }}
                </p>
            @enderror
            {{-- end displacement --}}

            {{-- state --}}
            <x-jet-label class="mt-2" value="Estado" />
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
                class=" mt-4 text-sm h-12 w-full bg-primary-500 rounded-rm flex items-center justify-center">
                Guardar
            </x-jet-button>
        </form>
    </div>
</div>
@push('custom-scripts')
    <script>
        document.addEventListener('livewire:load', function() {
            $('#select-customers').select2();
            $('#select-customers').on('change', function() {
                @this.set('customer_id', this.value);
            });
            $(".select2-container").css("width", "100%");
        });
    </script>
@endpush
