<div>
    <x-slot name="header">
        <div class="font-semibold text-xl text-gray-800 leading-tight">
            Registrar de Lote
        </div>
    </x-slot>
    <div class="max-w-8xl mx-auto py-10 sm:px-6 lg:px-8">
        <form wire:submit.prevent="submit" class="m-10 mt-0 p-4">
            {{-- select product --}}
            <div wire:ignore>
                <div class="">
                    Productos
                </div>
                <select id="select-products" wire:model="product_id"
                    class="border-gray-300 focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50 shadow-sm mt-1 block w-full rounded-fx rounded-md"
                    required>

                    <option selected>(Seleccionar)</option>
                    @forelse ($products as $product)
                        <option value="{{ $product->id }}">
                            {{ $product->name }}</option>
                    @empty
                        <option disabled>Sin registros</option>
                    @endforelse
                </select>

                @error('product_id')
                    <p class="text-red-500 font-semibold my-2">
                        {{ $message }}
                    </p>
                @enderror
            </div>
            {{-- end product --}}

            {{-- select warehouse --}}
            <div>
                <div class="">
                    Depósitos
                </div>
                <select id="select-warehouses" wire:model="warehouse_id"
                    class="border-gray-300 focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50 shadow-sm mt-1 block w-full rounded-fx rounded-md"
                    required>

                    <option selected>(Seleccionar)</option>
                    @forelse ($warehouses as $warehouse)
                        <option value="{{ $warehouse->id }}">
                            {{ $warehouse->name }}</option>
                    @empty
                        <option disabled>Sin registros</option>
                    @endforelse
                </select>

                @error('warehouse_id')
                    <p class="text-red-500 font-semibold my-2">
                        {{ $message }}
                    </p>
                @enderror
            </div>
            {{-- end warehouse --}}
            {{-- select suppliers --}}
            <div wire:ignore class="my-2">
                <div class="">
                    Proveedores
                </div>
                <select id="select-suppliers" wire:model="supplier_id"
                    class="border-gray-300 focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50 shadow-sm mt-1 block w-full rounded-md"
                    required>
                    <option selected>(Seleccionar)</option>
                    @forelse ($suppliers as $item)
                        <option value="{{ $item->id }}">
                            {{ $item->name }}</option>
                    @empty
                        <option disabled>Sin registros</option>
                    @endforelse
                </select>
                @error('supplier_id')
                    <p class="text-red-500 font-semibold my-2">
                        {{ $message }}
                    </p>
                @enderror
            </div>
            {{-- end select suppliers --}}
            {{-- select industries --}}
            <div wire:ignore class="my-2">
                <div class="">
                    Industrias
                </div>
                <select id="select-industries" wire:model="industry_id"
                    class="border-gray-300 focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50 shadow-sm mt-1 block w-full rounded-md"
                    required>
                    <option selected>(Seleccionar)</option>
                    @forelse ($industries as $item)
                        <option value="{{ $item->id }}">
                            {{ $item->name }}</option>
                    @empty
                        <option disabled>Sin registros</option>
                    @endforelse
                </select>
                @error('industry_id')
                    <p class="text-red-500 font-semibold my-2">
                        {{ $message }}
                    </p>
                @enderror
            </div>
            {{-- end select industries --}}
            {{-- wholesale_price --}}
            <div class="my-2">
                Precio de venta
            </div>
            <x-jet-input type="number" step="0.01" placeholder="00.00" wire:model="wholesale_price"
                class="mt-1 block w-full rounded-md" required />
            @error('Wholesale_price')
                <p class="text-red-500 font-semibold my-2">
                    {{ $message }}
                </p>
            @enderror
            {{-- end wholesale_price --}}
            {{-- retail_price --}}
            {{-- <div class="my-2">
                Precio minorista
            </div>
            <x-jet-input type="number" step="0.01" placeholder="00.00" wire:model="retail_price"
                class="mt-1 block w-full rounded-md" required />
            @error('retail_price')
                <p class="text-red-500 font-semibold my-2">
                    {{ $message }}
                </p>
            @enderror --}}
            {{-- end retail_price --}}
            {{-- final_price --}}
            {{-- <div class="my-2">
                Precio final
            </div>
            <x-jet-input type="number" step="0.01" placeholder="00.00" wire:model="final_price"
                class="mt-1 block w-full rounded-md" required />
            @error('final_price')
                <p class="text-red-500 font-semibold my-2">
                    {{ $message }}
                </p>
            @enderror --}}
            {{-- end final_price --}}
            {{-- stock --}}
            <div class="">
                Cantidad
            </div>
            <x-jet-input type="number" step="0.01" placeholder="Cantidad" wire:model="stock"
                class="mt-1 block w-full rounded-md" required />
            @error('stock')
                <p class="text-red-500 font-semibold my-2">
                    {{ $message }}
                </p>
            @enderror
            {{-- end stock --}}
            {{-- description --}}
            <div class="">
                Descripción
            </div>
            <x-textarea placeholder="Descripción" wire:model="description" class="mt-1 block w-full" />
            @error('description')
                <p class="text-red-500 font-semibold my-2">
                    {{ $message }}
                </p>
            @enderror
            {{-- end description --}}
            {{-- brand --}}
            <div class="my-2">
                Marca(s)
            </div>
            <x-jet-input type="text" placeholder="Marca(s)" wire:model="brand"
                class="mt-1 block w-full rounded-md" />
            @error('brand')
                <p class="text-red-500 font-semibold my-2">
                    {{ $message }}
                </p>
            @enderror
            {{-- end brand --}}
            {{-- model --}}
            <div class="my-2">
                Modelo(s)
            </div>
            <x-jet-input type="text" placeholder="Modelo(s)" wire:model="model"
                class="mt-1 block w-full rounded-md" />
            @error('model')
                <p class="text-red-500 font-semibold my-2">
                    {{ $message }}
                </p>
            @enderror
            {{-- end model --}}
            {{-- expiration_date --}}
            <div class="">
                Fecha de expiración
            </div>
            <x-jet-input type="date" wire:model="expiration_date" class="mt-1 block w-full rounded-md" />
            @error('expiration_date')
                <p class="text-red-500 font-semibold my-2">
                    {{ $message }}
                </p>
            @enderror
            {{-- end expiration_date --}}
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
            <hr class="my-2">
            {{-- select bank_account_id --}}
            <div class="mt-2 text-sm">Cuenta</div>
            <select wire:model="bank_account_id"
                class="border-gray-300 focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50 shadow-sm mt-1 block w-full rounded-fx rounded-md"
                required>
                @forelse ($bank_accounts as $item)
                    <option value="{{ $item->id }}">
                        {{ $item->name }} - {{ $item->number }} - {{ $item->balance }}</option>
                @empty
                    <option disabled>Sin registros</option>
                @endforelse
            </select>
            @error('bank_account_id')
                <p class="text-red-500 font-semibold my-2">
                    {{ $message }}
                </p>
            @enderror
            {{-- end bank_account_id --}}
            {{-- purchase_price --}}
            <div class="my-2">
                Precio de compra
            </div>
            <x-jet-input type="number" step="0.01" placeholder="00.00" wire:model="purchase_price"
                class="mt-1 block w-full rounded-md" required />
            @error('purchase_price')
                <p class="text-red-500 font-semibold my-2">
                    {{ $message }}
                </p>
            @enderror
            {{-- end purchase_price --}}
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
            $('#select-products').select2();
            $('#select-products').on('change', function() {
                @this.set('product_id', this.value);
            });

            $('#select-warehouses').select2();
            $('#select-warehouses').on('change', function() {
                @this.set('warehouse_id', this.value);
            });

            $('#select-suppliers').select2();
            $('#select-suppliers').on('change', function() {
                @this.set('supplier_id', this.value);
            });

            $('#select-industries').select2();
            $('#select-industries').on('change', function() {
                @this.set('industry_id', this.value);
            });
            $(".select2-container").css("width", "100%");
        });
    </script>
@endpush
