<div>
    <x-slot name="header">
        <div class="font-semibold text-xl text-gray-800 leading-tight">
            Pagos
        </div>
    </x-slot>
    <div class="mx-auto p-4">
        <div class="w-full flex flex-col bg-white rounded-md py-2 px-4 gap-2">
            <h1 class="text-2xl font-bold">Orden de servicio: {{ $service_order->number }}</h1>
            <hr>
            <h2 class="text-lg">Fecha: {{ $service_order->created_at }}</h2>
            <h2 class="text-lg opacity-75 text-red-500">Debe: {{ $service_order->must }}</h2>
            <h2 class="text-lg opacity-75 text-green-500">Haber: {{ $service_order->have }}</h2>
            <h2 class="text-xl font-bold">Total: {{ $service_order->total }}</h2>
        </div>
        <div class="w-full flex justify-end space-x-2 mt-4">
            <a href="{{ route('payment.create', $service_order->slug) }}"
                class="my-2  mx-4 border-2 border-green-500 text-green-500 bg-white flex items-center rounded-full hover:bg-green-500 hover:text-white">
                <svg class="w-8 h-8 m-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                        clip-rule="evenodd" />
                </svg>
            </a>
        </div>
        <div>
            <livewire:payment.payment-data-table :service_order_id="$service_order->id" />
        </div>
    </div>

</div>
