<div>
    <x-slot name="header">
        <div class="font-semibold text-xl text-gray-800 leading-tight">
            Registrar pago
        </div>
    </x-slot>
    <article class="mx-auto p-4">
        <section class="w-full flex flex-col bg-white rounded-md py-2 px-4 gap-2">
            <h1 class="text-2xl font-bold">Orden de servicio: {{ $service_order->number }}</h1>
            <hr>
            <h2 class="text-lg">Fecha: {{ $service_order->created_at }}</h2>
            <h2 class="text-lg opacity-75 text-red-500">Debe: {{ $service_order->must }}</h2>
            <h2 class="text-lg opacity-75 text-green-500">Haber: {{ $service_order->have }}</h2>
            <h2 class="text-xl font-bold">Total: {{ $service_order->total }}</h2>
        </section>
        <section class="w-full bg-white mt-5 rounded-md">
            <form wire:submit.prevent="submit" class="m-10 mt-0 py-4">
                {{-- amount --}}
                <x-jet-input type="number" step="0.01" placeholder="Monto" step="0.01" wire:model="amount"
                    class="mt-1 block w-full rounded-md" required />
                @error('amount')
                    <p class="text-red-500 font-semibold my-2">
                        {{ $message }}
                    </p>
                @enderror
                {{-- end amount --}}
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
                <x-jet-button type="submit" class="h-12 w-full rounded-md flex items-center justify-center mt-4">
                    Guardar
                </x-jet-button>
            </form>
        </section>
    </article>

</div>
