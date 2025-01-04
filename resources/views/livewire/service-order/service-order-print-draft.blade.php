<div class="p-4 print:p-0">
    <div>
        <section class="flex justify-center items-center flex-col w-full gap-2 font-bold text-xl ">
            <div class="text-2xl">
                MECATRONICA TALLER MECÁNICO ELECTRÓNICO
            </div>
            <div class="underline underline-offset-8">
                COTIZACION DE MANO DE OBRA, REPUESTOS Y SERVICIOS DE TERCEROS
            </div>

            <div class=" text-red-500">
                ESPECIALIZADOS EN TU VEHÍCULO, PRIORIZANDO TU VIDA.
            </div>
        </section>

        <article class="  flex justify-between mt-4">
            <section class=" flex flex-col">
                <div class="flex gap-4">
                    <span class="font-bold w-20 text-left">CLIENTE:</span>
                    <span class="text-left">{{ $selected_customer->person->name }}</span>
                </div>
                <div class="flex gap-4">
                    <span class="font-bold w-20 text-left">VEHÍCULO:</span>
                    <span class="text-left">{{ $vehicle->brand }} /
                        {{ $vehicle->model }}</span>
                </div>
                <div class="flex gap-4">
                    <span class="font-bold w-20 text-left">PLACA:</span>
                    <span class="text-left">{{ $vehicle->license_plate }}</span>
                </div>
            </section>
            <section class=" flex flex-col justify-center">
                <div class="flex gap-4">
                    <span class="font-bold w-18 text-left">FECHA:</span>
                    <span class="text-right">{{ date('d/m/Y') }}</span>
                </div>
            </section>
        </article>

        <article>
            <table class="w-full">
                <thead>
                    <tr>
                        <th class="text-center border border-black ">CANTIDAD</th>
                        <th class="text-center border border-black ">DESCRIPCIÓN</th>
                        <th class="text-center border border-black ">UNIDAD</th>
                        <th class="text-center border border-black ">PRECIO UNITARIO</th>
                        <th class="text-center border border-black ">PRECIO TOTAL</th>
                    </tr>
                </thead>

                @foreach ($serviceOrderBatches as $item)
                    <tr>
                        <td class="text-center border border-black">
                            {{ $item->quantity }}
                        </td>
                        <td class="text-left border border-black">
                            {{ $item->batch->product->name }} - {{ $item->batch->product->description }}
                        </td>
                        <td class="text-center border border-black">
                            PIEZA
                        </td>
                        <td class="text-center border border-black">
                            {{ $item->price }}
                        </td>
                        <td class="text-center border border-black">
                            {{ $item->subtotal }}
                        </td>
                    </tr>
                @endforeach

                @foreach ($serviceOrderExtraItems as $item)
                    <tr>
                        <td class="text-center border border-black">
                            {{ $item->quantity }}
                        </td>
                        <td class="text-left border border-black">
                            {{ $item->extra_item->name }}
                        </td>
                        <td class="text-center border border-black">
                            PIEZA
                        </td>
                        <td class="text-center border border-black">
                            {{ $item->price }}
                        </td>
                        <td class="text-center border border-black">
                            {{ $item->subtotal }}
                        </td>
                    </tr>
                @endforeach

                <thead>

                    <tr>
                        <th class="text-center border border-black">
                        </th>
                        <th class="text-center border border-black">
                            DESCRIPCIÓN DE SERVICIO
                        </th>
                        <th class="text-center border border-black">
                        </th>
                        <th class="text-center border border-black">
                        </th>
                        <th class="text-center border border-black">
                        </th>
                    </tr>

                </thead>
                @foreach ($labours_details as $item)
                    <tr>
                        <td class="text-center border border-black">
                            {{ $item->quantity }}
                        </td>
                        <td class="text-lett border border-black">
                            {{ $item->service->name }}
                        </td>
                        <td class="text-center border border-black">
                            SERVICIO
                        </td>
                        <td class="text-center border border-black">
                            {{ $item->price }}
                        </td>
                        <td class="text-center border border-black">
                            {{ $item->subtotal }}
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td class="text-left border border-black bg-yellow-300" colspan="5">
                        EL PRECIO PUEDE VARIAR UNA VEZ DESARMADO EL VEHÍCULO
                    </td>
                </tr>
            </table>
        </article>

        <article class="flex w-full items-center justify-center mt-8">
            <img class="h-28 object-cover" src="{{ asset('/storage/setting-logo/logo-setting.png') }}" alt="logo">
        </article>

        <article class="flex w-full mt-8 flex-col gap-2">
            <div class="text-sm">VÁLIDO HASTA : {{ $service_order->draft_expiration_date_formatted }}</div>
            <div class="text-lg font-bold">CONTACTO:77877890 - 73246276</div>
            <div class="text-sm font-bold text-red-500">UBICADOS: BARRIO SAN JORGE I, SOBRE AV. PANAMERICANA, CUADRA Y
                MEDIA ANTES DE LA ROTONDA DE LA COCA COLA AL LADO DE FINNIG CAT</div>
        </article>

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
