<div>
    <x-slot name="header">
        <div class="font-semibold text-xl text-gray-800 leading-tight">
            Actualizar orden de servicio
        </div>
    </x-slot>
    {{-- variables para modal --}}
    <section x-data="{ showModal: false, modalType: 'customer' }">

        <section x-show="!showModal">

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
                        {{-- service_order_number --}}
                        <section>
                            <div class="font-bold mb-2">
                                Número
                            </div>
                            <x-jet-input type="number" placeholder="00000" wire:model="service_order_number"
                                class="mt-1 block w-full rounded-md" required />
                        </section>
                        {{-- end service_order_number --}}
                        {{-- customer --}}
                        <div wire:ignore>
                            <div class="font-bold mb-2">
                                Cliente
                            </div>
                            <div class="flex items-center">
                                <select id="select-customers"
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

                                <x-button-plus @click.prevent="showModal = true ; modalType = 'customer'">
                                </x-button-plus>
                            </div>
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
                                <span><strong>{{ $selected_customer->person->ci }} /
                                        {{ $selected_customer->nit }}</strong></span>
                                <br>
                                <span class="text-gray-400">Dirección : </span>
                                <span><strong>{{ $selected_customer->person->address }}</strong></span>
                            @else
                                <span class="text-gray-400">Ningun cliente seleccionado</span>
                            @endif
                        </div>
                        {{-- end info customer --}}

                        {{-- select customer vehicle --}}
                        <div wire:ignore>
                            <div class="font-bold mb-2">
                                Vehículos
                            </div>
                            <div class="flex items-center">
                                <select id="select-vehicles"
                                    class="border-gray-300 focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50 shadow-sm mt-1 block w-full rounded-fx rounded-md"
                                    required>
                                    <option selected>(Seleccionar)</option>
                                    @forelse ($vehicles as $item)
                                        <option value="{{ $item->id }}">
                                            Placa: {{ $item->license_plate }} | Modelo: {{ $item->model }} | Marca:
                                            {{ $item->brand }} </option>
                                    @empty
                                        <option disabled>Sin registros</option>
                                    @endforelse
                                </select>
                                <x-button-plus @click.prevent="showModal = true ; modalType = 'vehicle'">
                                </x-button-plus>
                            </div>
                        </div>
                        {{-- end customer vehicle --}}

                        {{-- mileage --}}
                        <section>
                            <div class="font-bold mb-2">
                                Kilometrage
                            </div>
                            <x-jet-input type="number" placeholder="00000" wire:model="mileage"
                                class="mt-1 block w-full rounded-md" required />
                        </section>
                        {{-- end mileage --}}

                        {{-- started_date --}}
                        <section>
                            <div class="font-bold mb-2">
                                Fecha Ingreso
                            </div>
                            <x-jet-input type="date" wire:model="started_date" class="mt-1 block w-full rounded-md"
                                required />
                        </section>
                        {{-- end started_date --}}

                        {{-- ended_date --}}
                        <section>
                            <div class="font-bold mb-2">
                                Fecha Salida
                            </div>
                            <x-jet-input type="date" wire:model="ended_date" class="mt-1 block w-full rounded-md"
                                required />
                        </section>
                        {{-- end ended_date --}}
                    </section>

                    <section x-show="tab == 'tab2'" class="flex flex-col gap-8">
                        {{-- service --}}
                        <div wire:ignore>
                            <div class="font-bold mb-2">
                                Servicios
                            </div>
                            <div class="flex items-center">
                                <select id="select-services" required>
                                    <option selected>(Seleccionar)</option>
                                    @forelse ($services as $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->code }} | {{ $item->name }}
                                        </option>
                                    @empty
                                        <option disabled>Sin registros</option>
                                    @endforelse
                                </select>

                                <x-button-plus @click.prevent="showModal = true ; modalType = 'service'">
                                </x-button-plus>
                            </div>
                        </div>
                        {{-- end service --}}
                        {{-- select employee --}}
                        <div wire:ignore>
                            <div class="font-bold mb-2">
                                Técnicos
                            </div>
                            <div class="flex items-center">
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
                        </div>
                        {{-- end employee --}}
                        <section class="flex sm:flex-row flex-col gap-4">
                            {{-- additional_percent_employe --}}
                            <div wire:ignore class="w-full">
                                <div class="font-bold mb-2">
                                    % Técnico
                                </div>
                                <x-jet-input type="number" step="1" min="0" max="100"
                                    placeholder="00.00" wire:model="additional_percent_employe"
                                    class="mt-1 block w-full rounded-md" required />
                            </div>
                            {{-- end additional_percent_employe --}}
                            {{-- additional_service_price --}}
                            <div wire:ignore class="w-full">
                                <div class="font-bold mb-2">
                                    Precio
                                </div>
                                <x-jet-input type="number" step="0.01" placeholder="00.00"
                                    wire:model="additional_service_price" class="mt-1 block w-full rounded-md"
                                    required />
                            </div>
                            {{-- end additional_service_price --}}
                            {{-- additional_service_quantity --}}
                            <div wire:ignore class="w-full">
                                <div class="font-bold mb-2">
                                    Cantidad
                                </div>
                                <x-jet-input type="number" step="0.01" placeholder="00.00"
                                    wire:model="additional_service_quantity" class="mt-1 block w-full rounded-md"
                                    required />
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
                        {{-- batch --}}
                        <div wire:ignore>
                            <div class="font-bold mb-2">
                                Lote
                            </div>
                            <div class="flex items-center">
                                <select id="select-batches" required>
                                    <option selected>(Seleccionar)</option>
                                    @forelse ($batches as $item)
                                        <option value="{{ $item->id }}">{{ $item->product->description }}
                                        </option>
                                    @empty
                                        <option disabled>Sin registros</option>
                                    @endforelse
                                </select>
                                <x-button-plus @click.prevent="showModal = true ; modalType = 'batch'">
                                </x-button-plus>
                            </div>
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
                                        <span class="text-gray-400">Precio : </span>
                                        <span><strong>{{ $selected_batch->wholesale_price }}</strong></span>
                                        {{-- <span class="text-gray-400">Precios : </span><br>
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
                                        </div> --}}
                                        <hr class="my-2">
                                        <span class="text-gray-400">Producto : </span>
                                        <span><strong>{{ $selected_batch->product->name }}</strong></span>
                                        <div class="mt-2">
                                            @if ($selected_batch->product->photo)
                                                <a href="{{ asset($selected_batch->product->photo) }}"
                                                    target="_blank"><img class=" h-40 w-40 rounded-md"
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

                        {{-- extra_items --}}
                        <div wire:ignore>
                            <div class="font-bold mb-2">
                                Trabajos adicionales
                            </div>
                            <div class="flex items-center">
                                <select id="select-extra-items" required>
                                    <option selected>(Seleccionar)</option>
                                    @forelse ($extra_items as $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->name }}
                                        </option>
                                    @empty
                                        <option disabled>Sin registros</option>
                                    @endforelse
                                </select>

                                <x-button-plus @click.prevent="showModal = true ; modalType = 'extra_items'">
                                </x-button-plus>
                            </div>
                        </div>
                        {{-- end extra_items --}}

                        <section class="flex sm:flex-row flex-col gap-4">
                            {{-- additional_extra_item_cost --}}
                            <div wire:ignore class="w-full">
                                <div class="font-bold mb-2">
                                    Costo
                                </div>
                                <x-jet-input type="number" step="0.01" placeholder="00.00"
                                    wire:model="additional_extra_item_cost" class="mt-1 block w-full rounded-md"
                                    required />

                            </div>
                            {{-- end additional_extra_item_cost --}}
                            {{-- additional_extra_item_price --}}
                            <div wire:ignore class="w-full">
                                <div class="font-bold mb-2">
                                    Precio
                                </div>
                                <x-jet-input type="number" step="0.01" placeholder="00.00"
                                    wire:model="additional_extra_item_price" class="mt-1 block w-full rounded-md"
                                    required />
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
                                        wire:model="labours.{{ $item['uuid'] }}.quantity" min="1"
                                        max="999" wire:keyup="updateLabour('{{ $item['uuid'] }}')"
                                        wire:change="updateLabour('{{ $item['uuid'] }}')" />
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $item['subtotal'] }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-2xl ">
                                    <a
                                        class="inline-flex items-cente text-primary-500  hover:text-primary-700 cursor-pointer"><i
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
                                        wire:model="sale_details.{{ $item['id'] }}.price" min="1"
                                        max="999999" wire:keyup="updateSaleDetail('{{ $item['id'] }}')"
                                        wire:change="updateSaleDetail('{{ $item['id'] }}')" />
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <x-jet-input class="rounded-fx" type="number" step="1"
                                        wire:model="sale_details.{{ $item['id'] }}.quantity" min="1"
                                        max="999" wire:keyup="updateSaleDetail('{{ $item['id'] }}')"
                                        wire:change="updateSaleDetail('{{ $item['id'] }}')" />
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <x-jet-input class="rounded-fx" type="number" step="1"
                                        wire:model="sale_details.{{ $item['id'] }}.discount" min="0"
                                        max="100" wire:keyup="updateSaleDetail('{{ $item['id'] }}')"
                                        wire:change="updateSaleDetail('{{ $item['id'] }}')" /> %
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $item['subtotal'] }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-2xl ">
                                    <a
                                        class="inline-flex items-cente text-primary-500  hover:text-primary-700 cursor-pointer"><i
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
                        @foreach ($additional_extra_items as $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $loop->index + 1 }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $item['name'] }}
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <x-jet-input class="rounded-fx" type="number" step="1"
                                        wire:model="additional_extra_items.{{ $item['uuid'] }}.cost" min="1"
                                        max="999999" wire:keyup="updateExtraItem('{{ $item['uuid'] }}')"
                                        wire:change="updateExtraItem('{{ $item['uuid'] }}')" />
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <x-jet-input class="rounded-fx" type="number" step="1"
                                        wire:model="additional_extra_items.{{ $item['uuid'] }}.price" min="1"
                                        max="999999" wire:keyup="updateExtraItem('{{ $item['uuid'] }}')"
                                        wire:change="updateExtraItem('{{ $item['uuid'] }}')" />
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <x-jet-input class="rounded-fx" type="number" step="1"
                                        wire:model="additional_extra_items.{{ $item['uuid'] }}.quantity"
                                        min="1" max="999"
                                        wire:keyup="updateExtraItem('{{ $item['uuid'] }}')"
                                        wire:change="updateExtraItem('{{ $item['uuid'] }}')" />
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $item['subtotal'] }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-2xl ">
                                    <a class="inline-flex items-cente text-primary-500  hover:text-primary-700 cursor-pointer"
                                        wire:click="removeExtraItem('{{ $item['uuid'] }}')"><i
                                            class="fas fa-cart-arrow-down"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="5" class="text-right text-2xl font-bold">
                                Total $
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-2xl font-bold ">
                                {{ $additional_extra_items_total }}
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
                {{-- total --}}
                <div class="font-bold text-4xl mb-2 flex justify-end">
                    Total $ {{ $total }}
                </div>
                {{-- end total --}}
            </section>

            <section class="container m-auto mt-5 mb-5">
                <button wire:click="saveSale()"
                    class="h-12 w-full rounded-md flex items-center justify-center border bg-primary-500 text-white hover:bg-primary-600 cursor-pointer">
                    GUARDAR
                </button>
            </section>
        </section>



        <section x-show="showModal" @close-modal.window="showModal = false"
            class=" z-10 inset-0 bg-primary-950 bg-opacity-50 w-full h-full absolute flex justify-center items-center">
            <section x-show="showModal" class="container m-auto bg-white rounded-lg shadow flex flex-col"
                x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="transform opacity-0 scale-95"
                x-transition:enter-end="transform opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="transform opacity-100 scale-100"
                x-transition:leave-end="transform opacity-0 scale-95">
                {{-- header --}}
                <section class="bg-gray-100 rounded-t-lg h-20 flex w-full items-center flex-start relative">
                    <label class="text-2xl font-bold ml-8">
                        <label x-show="modalType == 'customer'">Agregar cliente</label>
                        <label x-show="modalType == 'service'">Agregar servicio</label>
                        <label x-show="modalType == 'extra_items'">Agregar trabajo adicional</label>
                        <label x-show="modalType == 'batch'">Agregar lote</label>
                        <label x-show="modalType == 'vehicle'">Agregar vehículo</label>
                    </label>
                    <button class="absolute right-8 text-4xl hover:scale-110 cursor-pointer"
                        @click.prevent="showModal = false">
                        <i class="fas fa-times"></i>
                    </button>
                </section>
                {{-- end header --}}
                {{-- body --}}
                <div class="overflow-y-auto">
                    <section x-show="modalType == 'customer'"
                        class="bg-white  flex w-full items-center relative p-8 rounded-b-lg">
                        <livewire:customer.customer-create-small />
                    </section>
                    <section x-show="modalType == 'service'"
                        class="bg-white  flex w-full items-center relative p-8 rounded-b-lg">
                        <livewire:service.service-create-small />
                    </section>
                    <section x-show="modalType == 'extra_items'"
                        class="bg-white  flex w-full items-center relative p-8 rounded-b-lg">
                        <livewire:extra-item.extra-item-create-small />
                    </section>
                    <section x-show="modalType == 'vehicle'"
                        class="bg-white  flex w-full items-center relative p-8 rounded-b-lg">
                        <livewire:vehicle.vehicle-create-small />
                    </section>
                    <section x-show="modalType == 'batch'"
                        class="bg-white  flex w-full items-center relative p-8 rounded-b-lg">
                        <livewire:batch.batch-create-small />
                    </section>
                </div>
            </section>
        </section>
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
            $('#select-customers').select2();
            $(".select2-container").css("width", "100%");
        }

        function setEventCustomerSelect() {
            $('#select-customers').on('change', function() {
                @this.set('customer_id', this.value);
                @this.onChangeSelectCustomer();
            });
        }

        function initExtraItemSelect2() {
            $('#select-extra-items').select2();
            $(".select2-container").css("width", "100%");
        }

        function setEventExtraItemSelect() {
            $('#select-extra-items').on('change', function() {
                @this.set('extra_item_id', this.value);
                @this.onChangeSelectExtraItems();
            });
        }

        function initVehicleSelect2() {
            $('#select-vehicles').select2();
            $(".select2-container").css("width", "100%");
        }

        function setEventVehicleSelect() {
            $('#select-vehicles').on('change', function() {
                @this.set('vehicle_id', this.value);
                @this.onChangeSelectVehicle();
            });
        }

        function initSelects() {
            initServiceSelect2();
            initEmployeeSelect2();
            initCustomerSelect2();
            initBatchSelect2();
            initExtraItemSelect2();
            initVehicleSelect2();
        }


        function addEventsSelects() {
            setEventServiceSelect();
            setEventEmployeeSelect();
            setEventBatchSelect();
            setEventCustomerSelect();
            setEventExtraItemSelect();
            setEventVehicleSelect();
        }

        document.addEventListener('livewire:load', function() {
            initSelects();
            addEventsSelects();
        });

        Livewire.on('serviceAddedEvent', (services, id) => {
            const selectElement = $('#select-services');
            selectElement.html('')
            $.each(services, function(key, value) {
                selectElement.append(
                    $("<option></option>")
                    .attr("value", value['id'])
                    .text(value['code'] + ' | ' + value['name'])
                );
            });
            selectElement.val(id);
            window.dispatchEvent(new Event('close-modal'));
        });

        Livewire.on('extraItemAddedEvent', (items, id) => {
            const selectElement = $('#select-extra-items');
            selectElement.html('')
            $.each(items, function(key, value) {
                selectElement.append(
                    $("<option></option>")
                    .attr("value", value['id'])
                    .text(value['name'])
                );
            });
            selectElement.val(id);
            window.dispatchEvent(new Event('close-modal'));
        });

        Livewire.on('batchAddedEvent', (items, id) => {
            const selectElement = $('#select-batches');
            selectElement.html('')
            $.each(items, function(key, value) {
                selectElement.append(
                    $("<option></option>")
                    .attr("value", value['id'])
                    .text(value['product']['description'])
                );
            });
            selectElement.val(id);
            window.dispatchEvent(new Event('close-modal'));
        });

        Livewire.on('vehicleAddedEvent', (items, id) => {
            const selectElement = $('#select-vehicles');
            selectElement.html('')
            $.each(items, function(key, value) {
                const vehicle = {
                    license_plate: value['license_plate'],
                    model: value['model'],
                    brand: value['brand'],
                }
                selectElement.append(
                    $("<option></option>")
                    .attr("value", value['id'])
                    .text(
                        ` Placa: ${vehicle.license_plate} | Modelo: ${vehicle.model} | Marca: ${vehicle.brand}`
                    )
                );
            });
            selectElement.val(id);
            window.dispatchEvent(new Event('close-modal'));
        });

        Livewire.on('customerAddedEvent', (items, id) => {
            const selectElement = $('#select-customers');
            selectElement.html('')
            $.each(items, function(key, value) {

                const customer = {
                    ci: value['person']['ci'],
                    nit: value['nit'] ? value['nit'] : '',
                    name: value['person']['name'],
                }

                selectElement.append(
                    $("<option></option>")
                    .attr("value", value['id'])
                    .text(
                        `${customer.ci} | NIT: ${customer.nit} | Nombre: ${customer.name}`
                    )
                );
            });
            selectElement.val(id);
            window.dispatchEvent(new Event('close-modal'));
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

        Livewire.on('customerSelectedEvent', vehicles => {
            console.log(vehicles);
            
            const selectElement = $('#select-vehicles');
            selectElement.html('')
            $.each(vehicles, function(key, value) {
                const vehicle = {
                    license_plate: value['license_plate'],
                    model: value['model'],
                    brand: value['brand'],
                }
                selectElement.append(
                    $("<option></option>")
                    .attr("value", value['id'])
                    .text(
                        ` Placa: ${vehicle.license_plate} | Modelo: ${vehicle.model} | Marca: ${vehicle.brand}`
                    )
                );
            });
        });
    </script>
@endpush
