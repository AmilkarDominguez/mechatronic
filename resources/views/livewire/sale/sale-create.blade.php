<div>
    <x-slot name="header">
        <div class="font-semibold text-xl text-gray-800 leading-tight">
            Registrar venta
        </div>


    </x-slot>

    <div class="container mx-auto mt-5 mb-4" x-data="{ tab: 'tab1' }">
        <h2 class="text-2xl font-bold">Tabs</h2>
        <ul class="flex mt-6 bg-white p-4">
            <li class="-mb-px mr-1">
                <a class="inline-block py-2 px-4 font-semibold" href="#"
                    :class="{ 'bg-white text-primary-500 border-b-4 border-primary-500': tab == 'tab1' }"
                    @click.prevent="tab = 'tab1'">
                    <i class="fas fa-wrench"></i> Mano de obra
                </a>
            </li>
            <li class="-mb-px mr-1">
                <a class="inline-block py-2 px-4 font-semibold" href="#"
                    :class="{ 'bg-white text-primary-500 border-b-4 border-primary-500': tab == 'tab2' }"
                    @click.prevent="tab = 'tab2'">
                    <i class="fas fa-boxes"></i> Repuestos e insumos
                </a>
            </li>
            <li class="-mb-px mr-1">
                <a class="inline-block py-2 px-4 font-semibold" href="#"
                    :class="{ 'bg-white text-primary-500 border-b-4 border-primary-500': tab == 'tab3' }"
                    @click.prevent="tab = 'tab3'">
                    <i class="fas fa-truck-loading"></i> Trabajos adicionales
                </a>
            </li>
            <li class="-mb-px mr-1">
                <a class="inline-block py-2 px-4 font-semibold" href="#"
                    :class="{ 'bg-white text-primary-500 border-b-4 border-primary-500': tab == 'tab4' }"
                    @click.prevent="tab = 'tab4'">
                    <i class="fas fa-user-tie"></i> Cliente
                </a>
            </li>
        </ul>
        <div class="content bg-white px-8 py-8 border-l border-r border-b pt-4">
            <section x-show="tab == 'tab1'" class="flex flex-col gap-8">
                {{-- service --}}
                <div wire:ignore>
                    <div class="font-bold mb-2">
                        Servicios
                    </div>
                    <select id="select-services" wire:model="service_id"required>
                        <option selected>(Seleccionar)</option>
                        @forelse ($services as $item)
                            <option value="{{ $item->id }}">
                                {{ $item->name }}
                            </option>
                        @empty
                            <option disabled>Sin registros</option>
                        @endforelse
                    </select>
                    @error('service_id')
                        <p class="text-red-500 font-semibold my-2">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                {{-- end service --}}
                {{-- select employee --}}
                <div wire:ignore>
                    <div class="font-bold mb-2">
                        Técnicos
                    </div>
                    <select id="select-employees" wire:model="employee_id" required>
                        <option selected>(Seleccionar)</option>
                        @forelse ($employees as $item)
                            <option value="{{ $item->id }}">
                                {{ $item->id }} |
                                {{ $item->person->name }} </option>
                        @empty
                            <option disabled>Sin registros</option>
                        @endforelse
                    </select>
                    @error('employee_id')
                        <p class="text-red-500 font-semibold my-2">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                {{-- end employee --}}
                <section class="flex sm:flex-row flex-col gap-4">
                    {{-- additional_percent_employe --}}
                    <div wire:ignore class="w-full">
                        <div class="font-bold mb-2">
                            % Técnico
                        </div>
                        <x-jet-input type="number" step="1" min="0" max="100" placeholder="00.00"
                            wire:model="additional_percent_employe" class="mt-1 block w-full rounded-md" required />
                        @error('additional_percent_employe')
                            <p class="text-red-500 font-semibold my-2">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    {{-- end additional_percent_employe --}}
                    {{-- additional_service_price --}}
                    <div wire:ignore class="w-full">
                        <div class="font-bold mb-2">
                            Precio
                        </div>
                        <x-jet-input type="number" step="0.01" placeholder="00.00"
                            wire:model="additional_service_price" class="mt-1 block w-full rounded-md" required />
                        @error('additional_service_price')
                            <p class="text-red-500 font-semibold my-2">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    {{-- end additional_service_price --}}
                    {{-- additional_service_quantity --}}
                    <div wire:ignore class="w-full">
                        <div class="font-bold mb-2">
                            Cantidad
                        </div>
                        <x-jet-input type="number" step="0.01" placeholder="00.00"
                            wire:model="additional_service_quantity" class="mt-1 block w-full rounded-md" required />
                        @error('additional_service_quantity')
                            <p class="text-red-500 font-semibold my-2">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    {{-- end additional_service_quantity --}}
                </section>
                <button wire:click="addLabour()"
                    class="h-12 mt-2 w-full rounded-md flex items-center justify-center border border-primary-500 bg-transparent text-primary-500 hover:text-white hover:bg-primary-500 cursor-pointer">
                    AGREGAR
                </button>
            </section>

            <section x-show="tab == 'tab2'" class="flex flex-col gap-8">
                {{-- select warehouse --}}
                <div wire:ignore>
                    <div class="font-bold mb-2">
                        Almacenes
                    </div>
                    <select wire:model="warehouse_id" wire:change="onChangeSelectWarehouse()"
                        class="border-gray-300 shadow-sm mt-1 block w-full rounded-md" required>
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
                {{-- select batch --}}
                <div>
                    <div class="font-bold mb-2">
                        Lote
                    </div>
                    <select id="select-batchs" wire:model="batch_id" required>
                        <option selected>(Seleccionar)</option>
                        @forelse ($batchs as $item)
                            <option value="{{ $item->id }}">{{ $item->product->description }}
                            </option>
                        @empty
                            <option disabled>Sin registros</option>
                        @endforelse
                    </select>
                    @error('batch_id')
                        <p class="text-red-500 font-semibold my-2">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                {{-- end batch --}}
                {{-- info batch --}}
                <div class="text-sm border rounded-md p-4">
                    @if ($batch)
                        <div class="flex justify-between">
                            <div>
                                <span class="text-gray-400">Stock : </span>
                                <span><strong>{{ $batch->stock }}</strong></span>
                                <br>
                                <span class="text-gray-400">Fecha de expiración : </span>
                                <span><strong>{{ $batch->expiration_date }}</strong></span>
                                <br>
                                <span class="text-gray-400">Precios : </span><br>
                                <div class="flex flex-col">
                                    <div class="flex justify-start items-center gap-2">
                                        MAYORISTA:
                                        <b class="text-primary-500">{{ $batch->wholesale_price }}</b>
                                    </div>
                                    <div class="flex justify-start items-center gap-2">
                                        MINORISTA:
                                        <b class="text-primary-500">{{ $batch->retail_price }}</b>
                                    </div>
                                    <div class="flex justify-start items-center gap-2">
                                        FINAL:
                                        <b class="text-primary-500">{{ $batch->final_price }}</b>
                                    </div>
                                </div>
                                <hr class="my-2">
                                <span class="text-gray-400">Producto : </span>
                                <span><strong>{{ $batch->product->name }}</strong></span>
                                <div class="mt-2">
                                    @if ($batch->product->photo)
                                        <a href="{{ asset($batch->product->photo) }}" target="_blank"><img
                                                class=" h-40 w-40 rounded-md"
                                                src="{{ asset($batch->product->photo) }}"></a>
                                    @else
                                        <svg class="h-40 w-40 opacity-40" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @else
                        <span class="text-gray-400">Ningun lote seleccionado</span>
                    @endif
                </div>
                {{-- end info batch --}}

                <button wire:click="addItemCart()"
                    class="h-12 mt-2 w-full rounded-md flex items-center justify-center border border-primary-500 bg-transparent text-primary-500 hover:text-white hover:bg-primary-500 cursor-pointer">
                    AGREGAR
                </button>
            </section>
            <section x-show="tab == 'tab3'" class="flex flex-col gap-8">


                {{-- additional_item_name --}}
                <div wire:ignore>
                    <div class="font-bold mb-2">
                        Item
                    </div>
                    <x-jet-input type="text" placeholder="Item" wire:model="additional_item_name"
                        class="mt-1 block w-full rounded-md" required />
                    @error('additional_item_price')
                        <p class="text-red-500 font-semibold my-2">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                {{-- end additional_item_name --}}
                <section class="flex sm:flex-row flex-col gap-4">
                    {{-- additional_item_cost --}}
                    <div wire:ignore class="w-full">
                        <div class="font-bold mb-2">
                            Costo
                        </div>
                        <x-jet-input type="number" step="0.01" placeholder="00.00"
                            wire:model="additional_item_cost" class="mt-1 block w-full rounded-md" required />
                        @error('additional_item_cost')
                            <p class="text-red-500 font-semibold my-2">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    {{-- end additional_item_cost --}}
                    {{-- additional_item_price --}}
                    <div wire:ignore class="w-full">
                        <div class="font-bold mb-2">
                            Precio
                        </div>
                        <x-jet-input type="number" step="0.01" placeholder="00.00"
                            wire:model="additional_item_price" class="mt-1 block w-full rounded-md" required />
                        @error('additional_item_price')
                            <p class="text-red-500 font-semibold my-2">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    {{-- end additional_item_price --}}
                    {{-- additional_item_quantity --}}
                    <div wire:ignore class="w-full">
                        <div class="font-bold mb-2">
                            Cantidad
                        </div>
                        <x-jet-input type="number" step="0.01" placeholder="00.00"
                            wire:model="additional_item_quantity" class="mt-1 block w-full rounded-md" required />
                        @error('additional_item_quantity')
                            <p class="text-red-500 font-semibold my-2">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    {{-- end additional_item_price --}}
                </section>
                <button wire:click="addItemCart()"
                    class="h-12 mt-2 w-full rounded-md flex items-center justify-center border border-primary-500 bg-transparent text-primary-500 hover:text-white hover:bg-primary-500 cursor-pointer">
                    AGREGAR
                </button>
            </section>


            <section x-show="tab == 'tab4'" class="flex flex-col gap-8">

                {{-- select customer --}}
                <div wire:ignore>
                    <div class="font-bold mb-2">
                        Cliente
                    </div>
                    <select id="select-custstomers" wire:model="customer_id"
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
                    @error('customer_id')
                        <p class="text-red-500 font-semibold my-2">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                {{-- end customer --}}
                {{-- info customer --}}
                <div class="text-sm border rounded-md p-4">
                    @if ($customer)
                        <span class="text-gray-400">Nombre completo : </span>
                        <span><strong>{{ $customer->person->name }}</strong></span>
                        <br>
                        <span class="text-gray-400">CI / NIT : </span>
                        <span><strong>{{ $customer->nit }} / {{ $customer->person->ci }}</strong></span>
                        <br>
                        <span class="text-gray-400">Dirección : </span>
                        <span><strong>{{ $customer->person->address }}</strong></span>
                    @else
                        <span class="text-gray-400">Ningun cliente seleccionado</span>
                    @endif
                </div>
                {{-- end info customer --}}
            </section>


        </div>
    </div>

    <section class="container mx-auto mt-5 mb-4">
        <h2 class="text-2xl font-bold">DETALLE MANO DE OBRA
        </h2>
    </section>

    <section class="container m-auto bg-white mt-5 rounded-md shadow overflow-hidden overflow-x-scroll">
        <table class="w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        ITEM
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        DESCRIPCIÓN
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        TÉCNICO
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        % TEC.
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        PRECIO
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        CATIDAD
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        SUB TOTAL
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        QUITAR
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">

                @foreach ($labours as $labour)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $loop->index + 1 }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $labour['service'] }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $labour['employee'] }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <x-jet-input class="rounded-fx" type="number" step="1"
                                wire:model="labours.{{ $labour['uuid'] }}.employee_percentage" min="1"
                                max="100" wire:keyup="updateLabour('{{ $labour['uuid'] }}')"
                                wire:change="updateLabour('{{ $labour['uuid'] }}')" /> %
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <x-jet-input class="rounded-fx" type="number" step="1"
                                wire:model="labours.{{ $labour['uuid'] }}.price" min="1" max="999999"
                                wire:keyup="updateLabour('{{ $labour['uuid'] }}')"
                                wire:change="updateLabour('{{ $labour['uuid'] }}')" />
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <x-jet-input class="rounded-fx" type="number" step="1"
                                wire:model="labours.{{ $labour['uuid'] }}.quantity" min="1" max="999"
                                wire:keyup="updateLabour('{{ $labour['uuid'] }}')"
                                wire:change="updateLabour('{{ $labour['uuid'] }}')" />
                        </td>
                        {{-- <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <x-jet-input class="rounded-fx" type="number" step="1"
                                wire:model="labours.{{ $uuid }}.service" min="1"
                                max="999" wire:keyup="updateQuantity({{ $id }})"
                                wire:change="updateQuantity({{ $id }})" />
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <select
                                class="border-gray-300 focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50 shadow-sm mt-1 block w-full rounded-md"
                                wire:model="cart_session_.{{ $id }}.price"
                                wire:change="updatePrice({{ $id }})" required>
                                @forelse ($cart_session_[$id]['prices'] as $price)
                                    <option value="{{ $price }}">{{ $price }}
                                    </option>
                                @empty
                                    <option disabled>Sin registros</option>
                                @endforelse
                            </select>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <x-jet-input class="rounded-fx" type="number" step="1" name="discount_product"
                                wire:model="cart_session_.{{ $id }}.discount" min="0"
                                max="100" wire:keyup="updateDiscount({{ $id }})"
                                wire:change="updateDiscount({{ $id }})" />
                            %
                        </td> --}}
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            $ {{ $labour['subtotal'] }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-2xl ">
                            <a class="inline-flex items-cente text-primary-500  hover:text-primary-700 cursor-pointer"><i
                                    class="fas fa-cart-arrow-down"
                                    wire:click="removeLabour('{{ $labour['uuid'] }}')"></i></a>
                        </td>

                    </tr>
                @endforeach

            </tbody>
        </table>


    </section>

    <div class="container m-auto bg-white mt-5 rounded-md">
        <h1>Amilkar</h1>
        {{-- <div class="pt-10 px-10">
            <a class="h-12 w-full rounded-md flex items-center justify-center px-4 py-2 cursor-pointer border border-transparent border-primary-500 text-primary-500 font-semibold text-xs  uppercase tracking-widest hover:bg-primary-500 hover:text-white transition ease-in-out duration-150"
                wire:click="viewCart()">
                <i class="fas fa-cart-plus"></i>&nbsp;&nbsp; Ver carrito
            </a>
        </div> --}}

        {{-- <div class="pt-10 px-10">
            <a class="h-12 w-full rounded-md flex items-center justify-center px-4 py-2 cursor-pointer border border-transparent border-primary-500 text-primary-500 font-semibold text-xs  uppercase tracking-widest hover:bg-primary-500 hover:text-white transition ease-in-out duration-150"
                wire:click="addBatch()">
                <i class="fas fa-cart-plus"></i>&nbsp;&nbsp; Agregar lote
            </a>
        </div> --}}

        <form wire:submit.prevent="submit" class="m-10 mt-0 p-4">
            {{-- select warehouse --}}
            {{-- <div class="my-2">
                <div class="">
                    Almacenes
                </div>
                <select wire:model="warehouse_id" wire:change="onChangeSelectWarehouse"
                    class="border-gray-300 focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50 shadow-sm mt-1 block w-full rounded-md"
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
            </div> --}}
            {{-- end warehouse --}}
            {{-- select service --}}
            {{-- <div wire:ignore class="my-2">
                <div class="">
                    Servicios
                </div>
                <select id="select-services" wire:model="service_id"
                    class="border-gray-300 focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50 shadow-sm mt-1 block w-full rounded-md"
                    required>
                    <option selected>(Seleccionar)</option>
                    @forelse ($services as $item)
                        <option value="{{ $item->id }}">
                            {{ $item->name }}
                        </option>
                    @empty
                        <option disabled>Sin registros</option>
                    @endforelse
                </select>
                @error('service_id')
                    <p class="text-red-500 font-semibold my-2">
                        {{ $message }}
                    </p>
                @enderror
            </div> --}}
            {{-- end service --}}
            {{-- select employee --}}
            {{-- <div wire:ignore class="my-2">
                <div class="">
                    Técnicos
                </div>
                <select id="select-employees" wire:model="employee_id"
                    class="border-gray-300 focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50 shadow-sm mt-1 block w-full rounded-md"
                    required>
                    <option selected>(Seleccionar)</option>
                    @forelse ($employees as $item)
                        <option value="{{ $item->id }}">
                            {{ $item->id }} |
                            {{ $item->person->name }} </option>
                    @empty
                        <option disabled>Sin registros</option>
                    @endforelse
                </select>
                @error('employee_id')
                    <p class="text-red-500 font-semibold my-2">
                        {{ $message }}
                    </p>
                @enderror
            </div> --}}
            {{-- end employee --}}

            {{-- select customer --}}
            {{-- <div wire:ignore class="my-2">
                <div class="">
                    Cliente
                </div>
                <select id="select-custstomers" wire:model="customer_id"
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
                @error('customer_id')
                    <p class="text-red-500 font-semibold my-2">
                        {{ $message }}
                    </p>
                @enderror
            </div> --}}
            {{-- end customer --}}

            {{-- info customer --}}
            {{-- <div class="mt-2 text-sm border rounded-md p-4">
                @if ($customer)
                    <span class="opacity-50">Nombre completo : </span>
                    <span><strong>{{ $customer->person->name }}</strong></span>
                    <br>
                    <span class="opacity-50">CI / NIT : </span>
                    <span><strong>{{ $customer->nit }} / {{ $customer->person->ci }}</strong></span>
                    <br>
                    <span class="opacity-50">Dirección : </span>
                    <span><strong>{{ $customer->person->address }}</strong></span>
                @else
                    <span class="text-red-500 opacity-50">Ningun cliente seleccionado</span>
                @endif
            </div> --}}
            {{-- end info customer --}}
            {{-- select batch --}}
            {{-- <div class="my-2">
                <div class="">
                    Lote
                </div>
                <select id="select-batchs" wire:model="batch_id"
                    class="border-gray-300 focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50 shadow-sm mt-1 block w-full rounded-md"
                    required>
                    <option selected>(Seleccionar)</option>
                    @forelse ($batchs as $item)
                        <option value="{{ $item->id }}">{{ $item->product->description }}
                        </option>
                    @empty
                        <option disabled>Sin registros</option>
                    @endforelse
                </select>
                @error('category_id')
                    <p class="text-red-500 font-semibold my-2">
                        {{ $message }}
                    </p>
                @enderror
            </div> --}}
            {{-- end batch --}}
            {{-- info batch --}}
            {{-- <div class="mt-2 text-sm border rounded-md p-4">
                @if ($batch)
                    <div class="flex justify-between">
                        <div>
                            <span class="opacity-50">Stock : </span>
                            <span><strong>{{ $batch->stock }}</strong></span>
                            <br>
                            <span class="opacity-50">Fecha de expiración : </span>
                            <span><strong>{{ $batch->expiration_date }}</strong></span>
                            <br>
                            <span class="opacity-50">Precios : </span><br>
                            <div class="flex flex-col">
                                <div class="flex justify-start items-center gap-2">
                                    MAYORISTA:
                                    <b class="text-primary-500">{{ $batch->wholesale_price }}</b>
                                </div>
                                <div class="flex justify-start items-center gap-2">
                                    MINORISTA:
                                    <b class="text-primary-500">{{ $batch->retail_price }}</b>
                                </div>
                                <div class="flex justify-start items-center gap-2">
                                    FINAL:
                                    <b class="text-primary-500">{{ $batch->final_price }}</b>
                                </div>
                            </div>
                            <hr class=" my-2">
                            <span class="opacity-50">Producto : </span>
                            <span><strong>{{ $batch->product->name }}</strong></span>
                            <div class="mt-2">
                                @if ($batch->product->photo)
                                    <a href="{{ asset($batch->product->photo) }}" target="_blank"><img
                                            class=" h-40 w-40 rounded-md"
                                            src="{{ asset($batch->product->photo) }}"></a>
                                @else
                                    <svg class="h-40 w-40 opacity-40" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                @endif
                            </div>
                        </div>
                        <div>
                            <a class="h-12 w-full rounded-md flex items-center justify-center px-4 py-2 cursor-pointer border border-transparent border-primary-500 text-primary-500 font-semibold text-xs  uppercase tracking-widest hover:bg-primary-500 hover:text-white transition ease-in-out duration-150"
                                wire:click="addItemCart()">
                                <i class="fas fa-cart-plus"></i>&nbsp;<span class="hidden sm:flex">agregar</span>
                            </a>
                        </div>
                    </div>
                @else
                    <span class="text-red-500 opacity-50">Ningun lote seleccionado</span>
                @endif
            </div> --}}
            {{-- end info batch --}}
            {{-- detial sale --}}
            {{-- <div class="container m-auto">
                <div class="mt-4">
                    Detalle de pre venta
                </div>
                <div class="grid md:grid-cols-3 grid-cols-1 gap-2 md:gap-4 pt-4">
                    <div
                        class="md:col-span-2 col-span-1   shadow overflow-hidden border-b border-gray-200 sm:rounded-lg overflow-x-scroll">
                        <table class="w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nombre
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Cantidad
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Precio
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Descuento
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Sub total
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Quitar
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">

                                @if (session('cart'))
                                    @foreach ($cart_session_ as $id => $item)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $item['name'] }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <x-jet-input class="rounded-fx" type="number" step="1"
                                                    name="quantity_product"
                                                    wire:model="cart_session_.{{ $id }}.quantity"
                                                    min="1" max="999"
                                                    wire:keyup="updateQuantity({{ $id }})"
                                                    wire:change="updateQuantity({{ $id }})" />
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <select
                                                    class="border-gray-300 focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50 shadow-sm mt-1 block w-full rounded-md"
                                                    wire:model="cart_session_.{{ $id }}.price"
                                                    wire:change="updatePrice({{ $id }})" required>
                                                    @forelse ($cart_session_[$id]['prices'] as $price)
                                                        <option value="{{ $price }}">{{ $price }}
                                                        </option>
                                                    @empty
                                                        <option disabled>Sin registros</option>
                                                    @endforelse
                                                </select>


                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">


                                                <x-jet-input class="rounded-fx" type="number" step="1"
                                                    name="discount_product"
                                                    wire:model="cart_session_.{{ $id }}.discount"
                                                    min="0" max="100"
                                                    wire:keyup="updateDiscount({{ $id }})"
                                                    wire:change="updateDiscount({{ $id }})" />
                                                %
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                $ {{ $item['subtotal'] }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-2xl ">

                                                <a
                                                    class="inline-flex items-cente text-primary-500  hover:text-primary-700 cursor-pointer"><i
                                                        class="fas fa-cart-arrow-down"
                                                        wire:click='deleteProductCart({{ $id }})'></i></a>
                                            </td>

                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <div
                        class="md:col-span-1 col-span-1 shadow overflow-hidden border-b border-gray-200 sm:rounded-lg bg-white">
                        <table class="w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" colspan="2"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Total Carrito
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-left">
                                        Productos:
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">
                                        @if (session('cart'))
                                            {{ $cart->count_items }}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-left">
                                        Cantidad items:
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">
                                        @if (session('cart'))
                                            {{ $cart->quantity_items }}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-left">
                                        Precio servicio:
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-right">
                                        @if ($service_price)
                                            {{ $service_price }}
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot class="bg-primary-700 text-white">
                                <tr>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-left">
                                        Total:
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-right">
                                        @if (session('cart'))
                                            $ {{ $cart->total }}
                                        @endif
                                    </td>
                                </tr>
                            </tfoot>

                        </table>
                    </div>


                </div>
            </div> --}}
            {{-- end detial sale --}}

            {{-- all errors --}}
            {{-- @if ($errors->any())
                <div class="bg-red-100 rounded-md text-red-500 p-2 font-semibold my-2">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif --}}
            {{-- end all errors --}}
            {{-- Info sale --}}
            <div class="mt-2 text-sm border rounded-md p-4 flex flex-col gap-8">
                {{-- payment_type --}}
                <div class="mt-2">
                    Tipo de pago
                    <div class="mt-4 space-y-2">
                        <div class="flex items-center">
                            <input wire:model="payment_type" value="CONTADO" type="radio"
                                class="focus:ring-primary-500 h-4 w-4 text-primary-600 border-gray-300">
                            <label for="push_everything" class="ml-2 block text-sm font-medium text-gray-700">
                                CONTADO
                            </label>
                        </div>
                        <div class="flex items-center">
                            <input wire:model="payment_type" value="CREDITO" type="radio"
                                class="focus:ring-primary-500 h-4 w-4 text-primary-600 border-gray-300">
                            <label for="push_email" class="ml-2 block text-sm font-medium text-gray-700">
                                CREDITO
                            </label>
                        </div>
                    </div>
                </div>
                {{-- end payment_type --}}
                {{-- description --}}
                <div>
                    <div class="text-sm">
                        Descripción
                    </div>
                    <x-textarea placeholder="Descripción" wire:model="description" class="mt-1 block w-full" />
                    @error('description')
                        <p class="text-red-500 font-semibold my-2">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                {{-- end description --}}
            </div>
            {{-- end Info sale --}}

            @if (session('cart'))
                <x-jet-button type="submit" class="h-12 mt-4 w-full rounded-md flex items-center justify-center">
                    Guardar
                </x-jet-button>
            @endif
        </form>
        @push('custom-scripts')
        </div>
    </div>
    <script>
        function initEmployeeSelect2() {
            $('#select-employees').select2();
            $('#select-employees').on('change', function() {
                @this.set('employee_id', this.value);
                @this.onChangeSelectEmployee();
                @this.onChangeSelect();
            });
            $(".select2-container").css("width", "100%");
        }

        function initServiceSelect2() {
            $('#select-services').select2();
            $('#select-services').on('change', function() {
                @this.set('service_id', this.value);
                @this.onChangeSelectService();
            });
            $(".select2-container").css("width", "100%");
        }

        function initBatchSelect2() {
            $('#select-batchs').select2();
            $('#select-batchs').on('change', function() {
                @this.set('batch_id', this.value);
                @this.showInfoBatch();
                @this.onChangeSelect();
            });
            $(".select2-container").css("width", "100%");
        }

        function initCustomerSelect2() {
            $('#select-custstomers').select2();
            $('#select-custstomers').on('change', function() {
                @this.
                set('customer_id', this.value);
                @this.showInfoCustomer();
                @this.onChangeSelect();
            });
            $(".select2-container").css("width", "100%");
        }

        function initSelects() {
            initCustomerSelect2();
            initEmployeeSelect2();
            initServiceSelect2();
            initBatchSelect2();
        }

        document.addEventListener('livewire:load', function() {
            initSelects();
        });

        Livewire.on('refreshSelects', batches => {
            initSelects();
        });
    </script>
@endpush
