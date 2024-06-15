<div>
    <div>
        <table class="border w-full">
            <tr class="border">
                <td class="border text-center font-bold text-2xl" colspan="3">COMPROBANTE DE VENTA
                    V-{{ $service_order->id }}</td>
            </tr>
            <tr class="border">
                <td class="border ">Fecha de Imp.: <b>{{ now() }}</b></td>
                <td class="border ">Forma de pago: <b>{{ $service_order->payment_type }}</b></td>
            </tr>


            <tr class="border">
                <td class="border ">Fecha: <b>{{ $service_order->created_at }}</b></td>
                <td class="border ">Estado: <b>Vigente</b></td>
                <td class="border text-left">Registrado por: <b>{{ $service_order->user->person->name }}</b></td>
            </tr>
            <tr class="border">
                <td class="border text-left" colspan="3">
                    Cliente: {{ $selected_customer->person->name }} - {{ $selected_customer->description }}<br>
                    Dirección: {{ $selected_customer->person->address }}
                </td>
            </tr>
            <tr class="border">
                <td class="border text-left" colspan="3">Observaciones: {{ $service_order->description }}</td>
            </tr>
        </table>
        <hr class="border m-2">
        @if ($this->setting->print_logo)
            <div class="absolute -z-10 flex justify-center items-center w-full">
                <img class="h-40 mt-10 opacity-20" src="{{ asset('/storage/setting-logo/logo-setting.png') }}"
                    alt="logo">
            </div>
        @endif

        {{-- MANO DE OBRA --}}
        <div class="my-2">
            DETALLE MANO DE OBRA
        </div>
        <table class="border w-full">
            <thead>
                <tr>
                    <th class="text-center border" colspan="4">ITEM</th>
                    <th class="text-center border">DESCRIPCIÓN</th>
                    <th class="text-center border">PRECIO</th>
                    <th class="text-center border">CATIDAD</th>
                    <th class="text-center border">SUB TOTAL</th>
                </tr>
            </thead>
            @foreach ($labours_details as $item)
                <tr>
                    <td class="border text-center" colspan="4">
                        {{ $loop->index + 1 }}
                    </td>
                    <td class="border text-center">
                        {{ $item->service->name }}
                    </td>
                    <td class="border text-center">
                        {{ $item->price }}
                    </td>
                    <td class="border text-center">
                        {{ $item->quantity }}
                    </td>
                    <td class="border text-right">
                        {{ $item->subtotal }}
                    </td>
                </tr>
            @endforeach
            <tr>
                <td class="border text-right" colspan="8">
                    TOTAL MANO DE OBRA <b>{{ $labours_total }} Bs.</b>
                </td>
            </tr>


        </table>
        {{-- END MANO DE OBRA --}}

        {{-- REPUESTOS E INSUMOS --}}
        <div class="my-2">
            DETALLE REPUESTOS E INSUMOS
        </div>
        <table class="border w-full">
            <thead>
                <tr>
                    <th class="text-center border" colspan="4">ITEM</th>
                    <th class="text-center border">DESCRIPCIÓN</th>
                    <th class="text-center border">PRECIO</th>
                    <th class="text-center border">CATIDAD</th>
                    <th class="text-center border">DESCUENTO</th>
                    <th class="text-center border">SUB TOTAL</th>
                </tr>
            </thead>
            @foreach ($serviceOrderBatches as $item)
                <tr>
                    <td class="border text-center" colspan="4">
                        {{ $loop->index + 1 }}
                    </td>
                    <td class="border text-center">
                        {{ $item->batch->product->name }} - {{ $item->batch->product->description }}
                    </td>
                    <td class="border text-center">
                        {{ $item->price }}
                    </td>
                    <td class="border text-center">
                        {{ $item->quantity }}
                    </td>
                    <td class="border text-center">
                        {{ $item->discount }}
                    </td>
                    <td class="border text-right">
                        {{ $item->subtotal }}
                    </td>
                </tr>
            @endforeach
            <tr>
                <td class="border text-right" colspan="9">
                    TOTAL REPUESTOS E INSUMOS <b>{{ $sale_details_total }} Bs.</b>
                </td>
            </tr>

        </table>
        {{-- END REPUESTOS E INSUMOS --}}

        {{-- TRABAJOS ADICIONALES --}}
        <div class="my-2">
            DETALLE TRABAJOS ADICIONALES
        </div>
        <table class="border w-full">
            <thead>
                <tr>
                    <th class="text-center border" colspan="4">ITEM</th>
                    <th class="text-center border">DESCRIPCIÓN</th>
                    <th class="text-center border">PRECIO</th>
                    <th class="text-center border">CATIDAD</th>
                    <th class="text-center border">SUB TOTAL</th>
                </tr>
            </thead>
            @foreach ($serviceOrderExtraItems as $item)
                <tr>
                    <td class="border text-center" colspan="4">
                        {{ $loop->index + 1 }}
                    </td>
                    <td class="border text-center">
                        {{ $item->extra_item->name }}
                    </td>
                    <td class="border text-center">
                        {{ $item->price }}
                    </td>
                    <td class="border text-center">
                        {{ $item->quantity }}
                    </td>
                    <td class="border text-right">
                        {{ $item->subtotal }}
                    </td>
                </tr>
            @endforeach
            <tr>
                <td class="border text-right" colspan="8">
                    TOTAL TRABAJOS ADICIONALES <b>{{ $additional_extra_items_total }} Bs.</b>
                </td>
            </tr>

        </table>
        {{-- END TRABAJOS ADICIONALES --}}


        <table class="w-full mt-12">
            <tr>
                <td>
                    Recibido por:
                </td>
                <td>
                    C.I.:
                </td>
                <td>
                    Firma:
                </td>
            </tr>
        </table>

    </div>


    <div class="container m-auto bg-white rounded-md w-96 p-1 mt-5 mb-10 print:hidden" wire:none>
        <x-jet-button id="btn_print" onclick="printDiv()"
            class=" h-12 w-full rounded-full flex items-center justify-center">
            <i class="fas fa-print"></i>&nbsp; Imprimir
        </x-jet-button>

        <script>
            function printDiv() {
                window.print();
                // console.log('print');
                // const buttonPrint = document.getElementById('btn_print');
                // buttonPrint.hidden = true;
                // const printContents = document.getElementById(divName).innerHTML;
                // const originalContents = document.body.innerHTML;
                // document.body.innerHTML = printContents;
                // window.print();
                // document.body.innerHTML = originalContents;
            }
        </script>
    </div>
</div>
