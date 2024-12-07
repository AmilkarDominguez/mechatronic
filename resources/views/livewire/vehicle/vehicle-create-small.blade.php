<div class="w-full">
    <form wire:submit.prevent="submit" class="w-full flex flex-col">
        <div wire:ignore>
            <div class="font-bold mb-2 flex items-center justify-start gap-1">
                <a wire:click="refreshCustomers()" title="Actualizar"
                    class="p-1 cursor-pointer text-green-500 hover:bg-green-500 hover:text-white rounded-full h-8 w-8 flex justify-center items-center">
                    <i class="fas fa-sync"></i>
                </a>
                Cliente
            </div>

            <div class="flex items-center">
                <select id="select-customers-modal"
                    class="border-gray-300 focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50 shadow-sm mt-1 block w-full rounded-md"
                    required>
                    <option selected>(Seleccionar)</option>
                    @forelse ($customers as $item)
                        <option value="{{ $item->id }}">
                            CI: {{ $item->person->ci }} | NIT: {{ $item->nit }} | Nombre:
                            {{ $item->person->name }} - {{ $item->description }} </option>
                    @empty
                        <option disabled>Sin registros</option>
                    @endforelse
                </select>
            </div>
        </div>
        {{-- end customer_id --}}
        {{-- select license_plate --}}
        <div>
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
        </div>
        {{-- end license_plate --}}
        <div class="flex justify-between gap-2 mb-2">
            <div class="w-full">
                {{-- brand --}}
                <div class="my-2">
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
            </div>
            <div class="w-full">
                {{-- model --}}
                <div class="my-2">
                    Modelo
                </div>
                <x-jet-input type="text" placeholder="Modelo" wire:model="model" class="mt-1 block w-full rounded-md"
                    required />
                @error('model')
                    <p class="text-red-500 font-semibold my-2">
                        {{ $message }}
                    </p>
                @enderror
                {{-- end model --}}
            </div>
            <div class="w-full">
                {{-- displacement --}}
                <div class="my-2">
                    Tipo/Cilindrada
                </div>
                <x-jet-input type="text" placeholder="Cilindrada" wire:model="displacement"
                    class="mt-1 block w-full rounded-md" required />
                @error('displacement')
                    <p class="text-red-500 font-semibold my-2">
                        {{ $message }}
                    </p>
                @enderror
                {{-- end displacement --}}
            </div>
        </div>

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
@push('custom-scripts')
    <script>
        document.addEventListener('livewire:load', function() {
            console.log('arrived...')
            $('#select-customers-modal').select2();
            $('#select-customers-modal').on('change', function() {

                console.log(this.value);

                @this.set('customer_id', this.value);
            });
            $(".select2-container").css("width", "100%");
        });

        Livewire.on('refreshCustomers', (customers) => {
            console.log(customers);

            const selectElement = $('#select-customers-modal');
            selectElement.html('')
            $.each(customers, function(key, value) {
                const customer = {
                    ci: value['ci'],
                    nit: value['nit'] ? value['nit'] : '',
                    name: value['name'],
                }
                selectElement.append(
                    $("<option></option>")
                    .attr("value", value['id'])
                    .text(
                        `${customer.ci} | NIT: ${customer.nit} | Nombre: ${customer.name}`
                    )
                );

            });
        });
    </script>
@endpush
