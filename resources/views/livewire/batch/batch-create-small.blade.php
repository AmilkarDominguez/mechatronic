<div class="w-full">
    <form wire:submit.prevent="submit" class="w-full flex flex-col">
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
        <div class="flex justify-between gap-2 mb-2">
            <div class="w-full">
                {{-- wholesale_price --}}
                <div class="my-2">
                    Precio
                </div>
                <x-jet-input type="number" step="0.01" placeholder="00.00" wire:model="wholesale_price"
                    class="mt-1 block w-full rounded-md" required />
                @error('Wholesale_price')
                    <p class="text-red-500 font-semibold my-2">
                        {{ $message }}
                    </p>
                @enderror
                {{-- end wholesale_price --}}
            </div>
            {{-- <div class="w-full"> --}}
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
            {{-- </div> --}}
            {{-- <div class="w-full"> --}}
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
            {{-- </div> --}}
        </div>

        <div class="flex justify-between gap-2 mb-2">
            <div class="w-full">
                {{-- stock --}}
                <div class="my-2">
                    Cantidad
                </div>
                <x-jet-input type="number" step="0.01" placeholder="00.00" wire:model="stock"
                    class="mt-1 block w-full rounded-md" required />
                @error('stock')
                    <p class="text-red-500 font-semibold my-2">
                        {{ $message }}
                    </p>
                @enderror
                {{-- end stock --}}
            </div>
            <div class="w-full">
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
            </div>
            <div class="w-full">
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
            </div>
        </div>

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
