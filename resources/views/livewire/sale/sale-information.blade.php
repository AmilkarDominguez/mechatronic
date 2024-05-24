<div>
    <x-slot name="header">
        <div class="font-semibold text-xl text-gray-800 leading-tight">
            Detalle venta
        </div>
    </x-slot>
    <div class="container m-auto bg-white mt-5 rounded-md">
        <div class="w-full flex justify-start space-x-2 container bg-white">
            <div class="my-2 mx-4">
                <h1 class="text-lg opacity-50">Información de venta</h1>
                <h1 class="text-2xl">Venta: {{ $sale->id }}</h1>
                <h2 class="text-lg">Fecha: {{ $sale->created_at }}</h2>
                <h2 class="text-lg opacity-75 text-red-500">Debe: {{ $sale->must }}</h2>
                <h2 class="text-lg opacity-75 text-green-500">Haber: {{ $sale->have }}</h2>
                <h2 class="text-xl font-bold">Total: {{ $sale->total }}</h2>
                <h2 class="text-base">Registrado por: {{ $sale->user->person->name }}</h2>
            </div>
        </div>
    </div>
    <div class="container m-auto bg-white mt-5 rounded-md">
        <div class="w-full flex justify-start space-x-2 container bg-white">
            <div class="my-2 mx-4">
                <h1 class="text-lg opacity-50">Información del cliente</h1>
                <h1 class="text-2xl">Nombre : {{ $customer->person->name }}</h1>
                <h2 class="text-lg">CI / NIT : {{ $customer->nit }} / {{ $customer->person->ci }}</h2>
                <h2 class="text-lg">Tipo : {{ $customer->customer_type->name }}</h2>
                <h2 class="text-lg">Dirección : {{ $customer->person->address }}</h2>
            </div>
        </div>
    </div>
    {{-- details --}}
    <div class="container m-auto">
        <div class="grid md:grid-cols-1 grid-cols-1  gap-2 md:gap-4 pt-4 ">
            <div class="md:col-span-1 col-span-1 shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                <div class="bg-white p-2">
                    <h1 class="text-lg opacity-50">Detalle de venta</h1>
                </div>
                <table class="w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Foto
                            </th>
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
                                Sub Total
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @if ($saledetails)
                            @foreach ($saledetails as $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        @if ($item->batch->product->photo)
                                            <a href="{{ asset($item->batch->product->photo) }}" target="_blank"><img
                                                    class=" h-16 w-16 rounded-md"
                                                    src="{{ asset($item->batch->product->photo) }}"></a>
                                        @else
                                            <svg class="h-16 w-16 opacity-40" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <p>Lote : {{ $item->batch->name }} </p>
                                        <p>Producto : {{ $item->batch->product->name }} </p>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $item->quantity }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $item->price }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $item->subtotal }}
                                    </td>
                                </tr>
                            @endforeach
                        @endif


                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{-- end details --}}
</div>
