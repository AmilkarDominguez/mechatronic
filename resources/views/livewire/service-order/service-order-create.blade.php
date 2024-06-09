<div>
    <x-slot name="header">
        <div class="font-semibold text-xl text-gray-800 leading-tight">
            Registrar orden de servicio
        </div>
    </x-slot>

    <div class="container mx-auto mt-5 mb-4" x-data="{ tab: 'tab1' }">
        <ul class="flex mt-6 bg-white p-4">
            <li class="-mb-px mr-1">
                <button class="inline-block py-2 px-4 font-semibold cursor-pointer"
                    :class="{ 'bg-white text-primary-500 border-b-4 border-primary-500': tab == 'tab1' }"
                    @click.prevent="tab = 'tab1'">
                    <i class="fas fa-user-tie"></i> Cliente
                </button>
            </li>
            <li class="-mb-px mr-1">
                <button class="inline-block py-2 px-4 font-semibold cursor-pointer"
                    :class="{ 'bg-white text-primary-500 border-b-4 border-primary-500': tab == 'tab2' }"
                    @click.prevent="tab = 'tab2'">
                    <i class="fas fa-wrench"></i> Mano de obra
                </button>
            </li>
            <li class="-mb-px mr-1">
                <button class="inline-block py-2 px-4 font-semibold cursor-pointer"
                    :class="{ 'bg-white text-primary-500 border-b-4 border-primary-500': tab == 'tab3' }"
                    @click.prevent="tab = 'tab3'">
                    <i class="fas fa-boxes"></i> Repuestos e insumos
                </button>
            </li>
            <li class="-mb-px mr-1">
                <button class="inline-block py-2 px-4 font-semibold cursor-pointer"
                    :class="{ 'bg-white text-primary-500 border-b-4 border-primary-500': tab == 'tab4' }"
                    @click.prevent="tab = 'tab4'">
                    <i class="fas fa-truck-loading"></i> Trabajos adicionales
                </button>
            </li>
        </ul>
        <div class="content bg-white px-8 py-8 border-l border-r border-b pt-4">
            <section x-show="tab == 'tab1'" class="flex flex-col gap-8">
                {{-- select customer --}}
                <div wire:ignore>
                    <div class="font-bold mb-2">
                        Cliente
                    </div>
                    <select id="select-custstomers"
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
                {{-- end customer --}}
                {{-- info customer --}}
                <div class="text-sm border rounded-md p-4">
                    <div wire:loading>
                        Cargando...
                    </div>
                    @if ($selected_customer)
                        <span class="text-gray-400">Nombre completo : </span>
                        <span><strong>{{ $selected_customer->person->name }}</strong></span>
                        <br>
                        <span class="text-gray-400">CI / NIT : </span>
                        <span><strong>{{ $selected_customer->nit }} /
                                {{ $selected_customer->person->ci }}</strong></span>
                        <br>
                        <span class="text-gray-400">Dirección : </span>
                        <span><strong>{{ $selected_customer->person->address }}</strong></span>
                    @else
                        <span class="text-gray-400">Ningun cliente seleccionado</span>
                    @endif
                </div>
                {{-- end info customer --}}
            </section>

            <section x-show="tab == 'tab2'" class="flex flex-col gap-8">
                {{-- service --}}
                <div wire:ignore>
                    <div class="font-bold mb-2">
                        Servicios
                    </div>
                    <select id="select-services" required>
                        <option selected>(Seleccionar)</option>
                        @forelse ($services as $item)
                            <option value="{{ $item->id }}">
                                {{ $item->name }}
                            </option>
                        @empty
                            <option disabled>Sin registros</option>
                        @endforelse
                    </select>
                </div>
                {{-- end service --}}
                {{-- select employee --}}
                <div wire:ignore>
                    <div class="font-bold mb-2">
                        Técnicos
                    </div>
                    <select id="select-employees" required>
                        <option selected>(Seleccionar)</option>
                        @forelse ($employees as $item)
                            <option value="{{ $item->id }}">
                                {{ $item->id }} |
                                {{ $item->person->name }} </option>
                        @empty
                            <option disabled>Sin registros</option>
                        @endforelse
                    </select>
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
                    </div>
                    {{-- end additional_percent_employe --}}
                    {{-- additional_service_price --}}
                    <div wire:ignore class="w-full">
                        <div class="font-bold mb-2">
                            Precio
                        </div>
                        <x-jet-input type="number" step="0.01" placeholder="00.00"
                            wire:model="additional_service_price" class="mt-1 block w-full rounded-md" required />
                    </div>
                    {{-- end additional_service_price --}}
                    {{-- additional_service_quantity --}}
                    <div wire:ignore class="w-full">
                        <div class="font-bold mb-2">
                            Cantidad
                        </div>
                        <x-jet-input type="number" step="0.01" placeholder="00.00"
                            wire:model="additional_service_quantity" class="mt-1 block w-full rounded-md" required />
                    </div>
                    {{-- end additional_service_quantity --}}
                </section>
                <button wire:click="addLabour()"
                    class="h-12 mt-2 w-full rounded-md flex items-center justify-center border border-primary-500 bg-transparent text-primary-500 hover:text-white hover:bg-primary-500 cursor-pointer">
                    AGREGAR
                </button>
            </section>

            <section x-show="tab == 'tab3'" class="flex flex-col gap-8">
                {{-- select warehouse --}}
                <div>
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
                </div>
                {{-- end warehouse --}}
                {{-- select batch --}}
                <div wire:ignore>
                    <div class="font-bold mb-2">
                        Lote
                    </div>
                    <select id="select-batches" required>
                        <option selected>(Seleccionar)</option>
                        @forelse ($batches as $item)
                            <option value="{{ $item->id }}">{{ $item->product->description }}
                            </option>
                        @empty
                            <option disabled>Sin registros</option>
                        @endforelse
                    </select>
                </div>
                {{-- end batch --}}
                {{-- info batch --}}
                <div class="text-sm border rounded-md p-4">
                    <div wire:loading>
                        Cargando...
                    </div>
                    @if ($selected_batch)
                        <div class="flex justify-between">
                            <div>
                                <span class="text-gray-400">Stock : </span>
                                <span><strong>{{ $selected_batch->stock }}</strong></span>
                                <br>
                                <span class="text-gray-400">Fecha de expiración : </span>
                                <span><strong>{{ $selected_batch->expiration_date }}</strong></span>
                                <br>
                                <span class="text-gray-400">Precios : </span><br>
                                <div class="flex flex-col">
                                    <div class="flex justify-start items-center gap-2">
                                        MAYORISTA:
                                        <b class="text-primary-500">{{ $selected_batch->wholesale_price }}</b>
                                    </div>
                                    <div class="flex justify-start items-center gap-2">
                                        MINORISTA:
                                        <b class="text-primary-500">{{ $selected_batch->retail_price }}</b>
                                    </div>
                                    <div class="flex justify-start items-center gap-2">
                                        FINAL:
                                        <b class="text-primary-500">{{ $selected_batch->final_price }}</b>
                                    </div>
                                </div>
                                <hr class="my-2">
                                <span class="text-gray-400">Producto : </span>
                                <span><strong>{{ $selected_batch->product->name }}</strong></span>
                                <div class="mt-2">
                                    @if ($selected_batch->product->photo)
                                        <a href="{{ asset($selected_batch->product->photo) }}" target="_blank"><img
                                                class=" h-40 w-40 rounded-md"
                                                src="{{ asset($selected_batch->product->photo) }}"></a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @else
                        <span class="text-gray-400">Ningun lote seleccionado</span>
                    @endif
                </div>
                {{-- end info batch --}}

                <button wire:click="addBatch()"
                    class="h-12 mt-2 w-full rounded-md flex items-center justify-center border border-primary-500 bg-transparent text-primary-500 hover:text-white hover:bg-primary-500 cursor-pointer">
                    AGREGAR
                </button>
            </section>

            <section x-show="tab == 'tab4'" class="flex flex-col gap-8">
                {{-- additional_extra_item --}}
                <div wire:ignore>
                    <div class="font-bold mb-2">
                        Item
                    </div>
                    <x-jet-input type="text" placeholder="Item" wire:model="additional_extra_item"
                        class="mt-1 block w-full rounded-md" required />
                </div>
                {{-- end additional_extra_item --}}
                <section class="flex sm:flex-row flex-col gap-4">
                    {{-- additional_extra_item_cost --}}
                    <div wire:ignore class="w-full">
                        <div class="font-bold mb-2">
                            Costo
                        </div>
                        <x-jet-input type="number" step="0.01" placeholder="00.00"
                            wire:model="additional_extra_item_cost" class="mt-1 block w-full rounded-md" required />

                    </div>
                    {{-- end additional_extra_item_cost --}}
                    {{-- additional_extra_item_price --}}
                    <div wire:ignore class="w-full">
                        <div class="font-bold mb-2">
                            Precio
                        </div>
                        <x-jet-input type="number" step="0.01" placeholder="00.00"
                            wire:model="additional_extra_item_price" class="mt-1 block w-full rounded-md" required />
                    </div>
                    {{-- end additional_extra_item_price --}}
                    {{-- additional_extra_item_quantity --}}
                    <div wire:ignore class="w-full">
                        <div class="font-bold mb-2">
                            Cantidad
                        </div>
                        <x-jet-input type="number" step="0.01" placeholder="00.00"
                            wire:model="additional_extra_item_quantity" class="mt-1 block w-full rounded-md"
                            required />
                    </div>
                    {{-- end additional_extra_item_price --}}
                </section>
                <button wire:click="addExtraItem()"
                    class="h-12 mt-2 w-full rounded-md flex items-center justify-center border border-primary-500 bg-transparent text-primary-500 hover:text-white hover:bg-primary-500 cursor-pointer">
                    AGREGAR
                </button>
            </section>
        </div>
    </div>

    <section class="container m-auto bg-white mt-5 rounded-md shadow overflow-hidden overflow-x-scroll">
        <h2 class="text-2xl font-bold p-4 text-center w-full">
            DETALLE MANO DE OBRA
        </h2>
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

                @foreach ($labours as $item)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $loop->index + 1 }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $item['service'] }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $item['employee'] }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <x-jet-input class="rounded-fx" type="number" step="1"
                                wire:model="labours.{{ $item['uuid'] }}.employee_percentage" min="1"
                                max="100" wire:keyup="updateLabour('{{ $item['uuid'] }}')"
                                wire:change="updateLabour('{{ $item['uuid'] }}')" /> %
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <x-jet-input class="rounded-fx" type="number" step="1"
                                wire:model="labours.{{ $item['uuid'] }}.price" min="1" max="999999"
                                wire:keyup="updateLabour('{{ $item['uuid'] }}')"
                                wire:change="updateLabour('{{ $item['uuid'] }}')" />
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <x-jet-input class="rounded-fx" type="number" step="1"
                                wire:model="labours.{{ $item['uuid'] }}.quantity" min="1" max="999"
                                wire:keyup="updateLabour('{{ $item['uuid'] }}')"
                                wire:change="updateLabour('{{ $item['uuid'] }}')" />
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $item['subtotal'] }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-2xl ">
                            <a class="inline-flex items-cente text-primary-500  hover:text-primary-700 cursor-pointer"><i
                                    class="fas fa-cart-arrow-down"
                                    wire:click="removeLabour('{{ $item['uuid'] }}')"></i></a>
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="6" class="text-right text-2xl font-bold">
                        Total $
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-2xl font-bold ">
                        {{ $labours_total }}
                    </td>
                </tr>
            </tbody>
        </table>

    </section>

    <section class="container m-auto bg-white mt-5 rounded-md shadow overflow-hidden overflow-x-scroll">
        <h2 class="text-2xl font-bold p-4 text-center w-full">
            DETALLE REPUESTOS E INSUMOS
        </h2>
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
                        PRECIO
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        CATIDAD
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        DESCUENTO
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

                @foreach ($sale_details as $item)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $loop->index + 1 }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $item['name'] }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <x-jet-input class="rounded-fx" type="number" step="1"
                                wire:model="sale_details.{{ $item['id'] }}.price" min="1" max="999999"
                                wire:keyup="updateSaleDetail('{{ $item['id'] }}')"
                                wire:change="updateSaleDetail('{{ $item['id'] }}')" />
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <x-jet-input class="rounded-fx" type="number" step="1"
                                wire:model="sale_details.{{ $item['id'] }}.quantity" min="1" max="999"
                                wire:keyup="updateSaleDetail('{{ $item['id'] }}')"
                                wire:change="updateSaleDetail('{{ $item['id'] }}')" />
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <x-jet-input class="rounded-fx" type="number" step="1"
                                wire:model="sale_details.{{ $item['id'] }}.discount" min="0" max="100"
                                wire:keyup="updateSaleDetail('{{ $item['id'] }}')"
                                wire:change="updateSaleDetail('{{ $item['id'] }}')" /> %
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $item['subtotal'] }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-2xl ">
                            <a class="inline-flex items-cente text-primary-500  hover:text-primary-700 cursor-pointer"><i
                                    class="fas fa-cart-arrow-down"
                                    wire:click="removeSaleDetail('{{ $item['id'] }}')"></i></a>
                        </td>

                    </tr>
                @endforeach
                <tr>
                    <td colspan="5" class="text-right text-2xl font-bold">
                        Total $
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-2xl font-bold ">
                        {{ $sale_details_total }}
                    </td>
                </tr>
            </tbody>
        </table>
    </section>

    <section class="container m-auto bg-white mt-5 rounded-md shadow overflow-hidden overflow-x-scroll">
        <h2 class="text-2xl font-bold p-4 text-center w-full">
            DETALLE TRABAJOS ADICIONALES
        </h2>
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
                        COSTO
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
                @foreach ($extra_items as $item)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $loop->index + 1 }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $item['item'] }}
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <x-jet-input class="rounded-fx" type="number" step="1"
                                wire:model="extra_items.{{ $item['uuid'] }}.cost" min="1" max="999999"
                                wire:keyup="updateExtraItem('{{ $item['uuid'] }}')"
                                wire:change="updateExtraItem('{{ $item['uuid'] }}')" />
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <x-jet-input class="rounded-fx" type="number" step="1"
                                wire:model="extra_items.{{ $item['uuid'] }}.price" min="1" max="999999"
                                wire:keyup="updateExtraItem('{{ $item['uuid'] }}')"
                                wire:change="updateExtraItem('{{ $item['uuid'] }}')" />
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <x-jet-input class="rounded-fx" type="number" step="1"
                                wire:model="extra_items.{{ $item['uuid'] }}.quantity" min="1" max="999"
                                wire:keyup="updateExtraItem('{{ $item['uuid'] }}')"
                                wire:change="updateExtraItem('{{ $item['uuid'] }}')" />
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $item['subtotal'] }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-2xl ">
                            <a class="inline-flex items-cente text-primary-500  hover:text-primary-700 cursor-pointer"><i
                                    class="fas fa-cart-arrow-down"
                                    wire:click="removeExtraItem('{{ $item['uuid'] }}')"></i></a>
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="5" class="text-right text-2xl font-bold">
                        Total $
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-2xl font-bold ">
                        {{ $extra_items_total }}
                    </td>
                </tr>
            </tbody>
        </table>
    </section>

    <section
        class="container m-auto p-8 bg-white mt-5 rounded-md shadow overflow-hidden overflow-x-scroll flex flex-col gap-8">
        <div>
            <div class="font-bold mb-2">
                Tipo de pago
            </div>
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
            <div class="font-bold mb-2">
                Recomendación
            </div>
            <x-textarea placeholder="Recomendación" wire:model="description" class="mt-1 block w-full" />
        </div>
        {{-- end description --}}
    </section>

    <section class="container m-auto mt-5 mb-5">
        <button wire:click="saveSale()"
            class="h-12 w-full rounded-md flex items-center justify-center border bg-primary-500 text-white hover:bg-primary-600 cursor-pointer">
            REGISTRAR
        </button>
    </section>
</div>
@push('custom-scripts')
    <script>
        function initServiceSelect2() {
            $('#select-services').select2();
            $(".select2-container").css("width", "100%");
        }

        function setEventServiceSelect() {
            $('#select-services').on('change', function() {
                @this.set('service_id', this.value);
                @this.onChangeSelectService();
            });
        }

        function initEmployeeSelect2() {
            $('#select-employees').select2();
            $(".select2-container").css("width", "100%");
        }

        function setEventEmployeeSelect() {
            $('#select-employees').on('change', function() {
                @this.set('employee_id', this.value);
                @this.onChangeSelectEmployee();
            });
        }

        function initBatchSelect2() {
            $('#select-batches').select2();
            $(".select2-container").css("width", "100%");
        }

        function setEventBatchSelect() {
            $('#select-batches').on('change', function() {
                @this.set('batch_id', this.value);
                @this.onChangeSelectBatch();
            });
        }


        function initCustomerSelect2() {
            $('#select-custstomers').select2();
            $(".select2-container").css("width", "100%");
        }

        function setEventCustomerSelect() {
            $('#select-custstomers').on('change', function() {
                @this.set('customer_id', this.value);
                @this.onChangeSelectCustomer();
            });
        }

        function initSelects() {
            initServiceSelect2();
            initEmployeeSelect2();
            initCustomerSelect2();
            initBatchSelect2();
        }


        function addEventsSelects() {
            setEventServiceSelect();
            setEventEmployeeSelect();
            setEventBatchSelect();
            setEventCustomerSelect();
        }

        document.addEventListener('livewire:load', function() {
            initSelects();
            addEventsSelects();
        });

        Livewire.on('refreshSelects', batches => {
            const selectElement = $('#select-batches');
            selectElement.html('')
            $.each(batches, function(key, value) {
                selectElement.append(
                    $("<option></option>")
                    .attr("value", value['id'])
                    .text(value['product']['description'])
                );
            });
        });
    </script>
@endpush
