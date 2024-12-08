<div class="p-4 print:p-0">
    <div>
        <div
            class="flex justify-center items-center w-full font-bold text-2xl text-red-500 underline underline-offset-8">
            HOJA DE SERVICIO #{{ $service_order->number }}
        </div>

        <article class="flex gap-4 mt-8 font-bold">

            <section class="w-4/5 grid grid-cols-1 md:grid-cols-7 gap-2 h-24">
                <section class="flex h-10 items-center gap-1 text-sm col-span-3">
                    <span class="font-bold w-20 text-right">Cliente:</span>
                    <span class="bg-blue-100 md:w-full w-auto text-center md:px-2 px-8">{{ $selected_customer->person->name }}</span>
                </section>
                <section class="flex h-10 items-center gap-1  text-sm col-span-2">
                    <span class="font-bold w-40 text-right">Placa:</span>
                    <span class="bg-blue-100 md:w-full w-auto text-center md:px-2 px-8">{{ $vehicle->license_plate }}</span>
                </section>
                <section class="flex h-10 items-center gap-1 text-sm col-span-2">
                    <span class="font-bold w-48 text-right">Fecha Ing:</span>
                    <span class="bg-blue-100 md:w-48 w-auto text-center md:px-2 px-8">{{ $service_order->started_date }}</span>
                </section>
                <section class="flex h-10 items-center gap-1 text-sm col-span-3">
                    <span class="font-bold w-20 text-right">Vehículo:</span>
                    <span class="bg-blue-100 md:w-full w-auto text-center md:px-2 px-8">{{ $vehicle->brand }} /
                        {{ $vehicle->model }}</span>
                </section>
                <section class="flex h-10 items-center gap-1 text-sm col-span-2">
                    <span class="font-bold w-40  text-right">Kilometraje:</span>
                    <span class="bg-blue-100 md:w-full w-auto text-right md:px-2 px-8">{{ $service_order->mileage }}</span>
                </section>
                <section class="flex h-10 items-center gap-1 text-sm col-span-2">
                    <span class="font-bold w-48 text-right">Fecha Entrega:</span>
                    <span class="bg-blue-100 md:w-48 w-auto text-center md:px-2 px-8 ">{{ $service_order->ended_date }}</span>
                </section>
            </section>
            <section class="w-1/5 flex items-center justify-center ">
                <img class="h-24 object-fill" src="{{ asset('/storage/setting-logo/logo-setting.png') }}"
                    alt="logo">
            </section>
        </article>

        <div class="flex justify-center items-center w-full py-2 font-bold text-2xl">
            "ESPECIALIZADOS EN TU VEHÍCULO, PRIORIZANDO TU VIDA"
        </div>
        <hr class="border border-red-400">

        <article class="flex gap-6">
            <section class="w-3/5">
                {{-- MANO DE OBRA --}}
                <div class="my-2 w-full flex justify-center items-center font-bold">
                    Lista de trabajos de mano de obra
                </div>
                <table class="w-full">
                    <thead>
                        <tr class="h-10 border">
                            <th class="text-center border-double border-4 border-black bg-blue-100">ITEM</th>
                            <th class="text-center border-double border-4 border-black bg-blue-100">DESCRIPCIÓN</th>
                            <th class="text-center border-double border-4 border-black bg-blue-100">UNIDAD</th>
                            <th class="text-center border-double border-4 border-black bg-blue-100">P.UNIT <br> (Bs.)
                            </th>
                            <th class="text-center border-double border-4 border-black bg-blue-100">CANT</th>
                            <th class="text-center border-double border-4 border-black bg-blue-100">TOTAL <br> (Bs.)
                            </th>
                        </tr>
                    </thead>
                    <tr class="border-double border-b-2 border-green-600">
                        <td class="text-center text-sm" colspan="5">
                            <b>TOTAL MANO DE OBRA </b>
                        </td>
                        <td class="text-right">
                            <b> {{ $labours_total }}</b>
                        </td>
                    </tr>

                    @foreach ($labours_details as $item)
                        <tr>
                            <td class="text-center">
                                {{ $loop->index + 1 }}
                            </td>
                            <td class="text-center">
                                {{ $item->service->name }}
                            </td>
                            <td class="text-center">
                                SERVICIO
                            </td>
                            <td class="text-center">
                                {{ $item->price }}
                            </td>
                            <td class="text-center">
                                {{ $item->quantity }}
                            </td>
                            <td class="text-right">
                                {{ $item->subtotal }}
                            </td>
                        </tr>
                    @endforeach


                </table>
                {{-- END MANO DE OBRA --}}

            </section>
            <section class="w-2/5">

                {{-- REPUESTOS E INSUMOS --}}
                <div class="my-2 w-full flex justify-center items-center font-bold">
                    Lista de repuestos e insumos
                </div>
                <table class="w-full">
                    <thead>
                        <tr class="h-10">
                            <th class="text-center border-double border-4 border-black bg-blue-100">CANT</th>
                            <th class="text-center border-double border-4 border-black bg-blue-100">DESCRIPCIÓN</th>
                            <th class="text-center border-double border-4 border-black bg-blue-100">P.UNIT <br> (Bs.)
                            </th>
                            <th class="text-center border-double border-4 border-black bg-blue-100">TOTAL <br> (Bs.)
                            </th>
                        </tr>
                    </thead>
                    <tr class="border-double border-b-2 border-green-600">
                        <td class="text-center text-sm" colspan="3">
                            <b>REPUESTOS, TRABAJOS ADICIONALES E INSUMOS </b>
                        </td>
                        <td class="text-right">
                            <b> {{ round($sale_details_total + $additional_extra_items_total, 2) }}</b>
                        </td>
                    </tr>
                    @foreach ($serviceOrderBatches as $item)
                        <tr>
                            <td class="text-center">
                                {{ $item->quantity }}
                            </td>
                            <td class="text-center">
                                {{ $item->batch->product->name }} - {{ $item->batch->product->description }}
                            </td>
                            <td class="text-center">
                                {{ $item->price }}
                            </td>
                            <td class="text-right">
                                {{ $item->subtotal }}
                            </td>
                        </tr>
                    @endforeach

                    @foreach ($serviceOrderExtraItems as $item)
                        <tr>
                            <td class="text-center">
                                {{ $item->quantity }}
                            </td>
                            <td class="text-center">
                                {{ $item->extra_item->name }}
                            </td>
                            <td class="text-center">
                                {{ $item->price }}
                            </td>
                            <td class="text-right">
                                {{ $item->subtotal }}
                            </td>
                        </tr>
                    @endforeach
                </table>
                {{-- END REPUESTOS E INSUMOS --}}
            </section>
        </article>

        <section class="w-full flex justify-between text-base mt-8 gap-48">

            <section class="w-1/2 border-double border-4 border-red-500 flex flex-col gap-2">
                <section class="flex justify-center items-center font-bold text-red-500 w-full border-b border-black py-2">
                    RECOMENDACIÓN
                </section>
                <div class="flex ml-2">
                    {{ $service_order->description }}
                </div>
            </section>

            <section class=" w-1/2">
                <section class="bg-green-300 px-4 py-2 h-10 flex justify-between font-bold text-xl">
                    <div class="text-right w-2/3">
                        SUB-TOTAL (Bs.):
                    </div>
                    <div class="text-right w-1/3">
                        {{ $service_order->total }}
                    </div>
                </section>
                <section class="bg-green-500 px-4 py-2 h-10 flex justify-between font-bold text-xl">
                    <div class="text-right  w-2/3">
                        IVA-IT (Bs.):
                    </div>
                    <div class="text-right  w-1/3">
                        {{ round($service_order->total / 0.87 - $service_order->total, 2) }}
                    </div>
                </section>
                <section class="bg-green-300 px-4 py-2 h-10 flex justify-between font-bold text-xl mt-4">
                    <div class="text-right  w-2/3">
                        TOTAL (Bs.):
                    </div>
                    <div class="text-right  w-1/3">
                        {{ round($service_order->total / 0.87 - $service_order->total, 2) + $service_order->total }}
                    </div>
                </section>
            </section>

        </section>

        <section class="mt-20 w-full font-bold flex justify-center">
            <div class=" text-center px-16 py-2 border-t-2 border-dashed border-black">
                ASESOR DE SERVICIOS
            </div>
        </section>

    </div>


    <div class="container m-auto bg-white rounded-md w-96 p-1 mt-5 mb-10 print:hidden" wire:none>
        <x-jet-button id="btn_print" onclick="printDiv()"
            class=" h-12 w-full rounded-full flex items-center justify-center">
            <i class="fas fa-print"></i>&nbsp; Imprimir
        </x-jet-button>

        <script>
            function printDiv() {
                window.print();
            }
        </script>
    </div>
</div>
