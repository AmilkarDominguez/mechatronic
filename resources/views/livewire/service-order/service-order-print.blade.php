<div>
    <div>
        <table class="border w-full">
            <tr class="border">
                <td class="border text-center font-bold text-2xl" colspan="3">COMPROBANTE DE VENTA V-{{ $service_order->id }}</td>
            </tr>
            <tr class="border">
                <td class="border ">Fecha de Imp.: <b>{{ now() }}</b></td>
                <td class="border">Entrega: <b>{{ $service_order->warehouse->name }}</b></td>
                <td class="border ">Forma de pago: <b>{{ $service_order->payment_type }}</b></td>
            </tr>


            <tr class="border">
                <td class="border ">Fecha: <b>{{ $service_order->created_at }}</b></td>
                <td class="border ">Estado: <b>Vigente</b></td>
                <td class="border text-left">Registrado por: <b>{{ $service_order->user->person->name }}</b></td>
            </tr>
            <tr class="border">
                <td class="border text-left" colspan="3">
                    Cliente: {{ $customer->person->name }} - {{ $customer->description }}<br>
                    Dirección: {{ $customer->person->address }}
                </td>
            </tr>
            <tr class="border">
                <td class="border text-left" colspan="3">Observaciones: {{ $service_order->description }}</td>
            </tr>
        </table>
        <hr class="border m-2">
        @if($this->setting->print_logo)
            <div class="absolute -z-10 flex justify-center items-center w-full">
                <img class="h-40 mt-10 opacity-20" src="{{ asset('/storage/setting-logo/logo-setting.png') }}" alt="logo">
            </div>
        @endif
        <table class="border w-full">
            <thead>
            <tr>
                <th class="text-center border" colspan="4">Producto</th>
                <th class="text-center border">Presentación</th>
                <th class="text-center border">Precio</th>
                <th class="text-center border">Cantidad</th>
                <th class="text-center border">Subtotal</th>
            </tr>
            </thead>
            @foreach ($saledetails as $item)
                <tr>
                    <td class="border" colspan="4">

                        {{ $item->batch->product->name }}
                    </td>
                    <td class="border text-center">
                        {{ $item->batch->product->presentation->name }}
                    </td>
                    <td class="border text-center">{{$item->price}}</td>
                    <td class="border text-center">
                        {{ $item->quantity }}
                    </td>
                    <td class="border text-right">
                        {{ $item->subtotal }} Bs.
                    </td>
                </tr>
                @if ($loop->last)
                    @for ($i = 0; $i < (6 - $loop->count); $i++)
                        <tr>
                            <td class="border" colspan="4">
                                &nbsp;
                            </td>
                            <td class="border">
                            </td>
                            <td class="border">
                            </td>
                            <td class="border">
                            </td>
                        </tr>
                    @endfor
                @endif
            @endforeach
            <tr>
                <td class="border text-right" colspan="8">
                    IMPORTE TOTAL <b>{{ $service_order->total }} Bs.</b>
                </td>
            </tr>


        </table>
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
