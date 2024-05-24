<div>
    <x-slot name="header">
        <div class="font-semibold text-xl text-gray-800 leading-tight">
            Registrar pago
        </div>
    </x-slot>
    <div class=" max-w-8xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="w-full flex justify-start space-x-2 container bg-white">
            <div class="my-2 mx-4">
                <h1 class="text-lg opacity-50">Información de venta</h1>
                <h1 class="text-2xl">Venta: {{ $sale->id }}</h1>
                <h2 class="text-lg">Fecha: {{ $sale->created_at }}</h2>
                <h2 class="text-lg opacity-75 text-red-500">Debe: {{ $sale->must }}</h2>
                <h2 class="text-lg opacity-75 text-green-500">Haber: {{ $sale->have }}</h2>
                <h2 class="text-xl font-bold">Total: {{ $sale->total }}</h2>
            </div>
        </div>
    </div>

    <div class="container m-auto bg-white mt-5 rounded-md">
        <form wire:submit.prevent="submit" class="m-10 mt-0 p-4">
            {{-- amount --}}
            <div class="">
                Monto
            </div>
            <x-jet-input type="number" step="0.01" placeholder="Monto" step="0.01" wire:model="amount" class="mt-1 block w-full rounded-md"
                required />
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
    </div>
</div>
