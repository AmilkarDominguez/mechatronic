<div>
    <x-slot name="header">
        <div class="font-semibold text-xl text-gray-800 leading-tight">
            Registrar ingreso
        </div>
    </x-slot>
    <div class="max-w-8xl mx-auto py-10 sm:px-6 lg:px-8">
        <form wire:submit.prevent="submit" class="m-10 mt-0 p-4">
            {{-- select bank_account_id --}}
            <div class="mt-2 text-sm">Cuenta</div>
            <select wire:model="bank_account_id"
                class="border-gray-300 focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50 shadow-sm mt-1 block w-full rounded-fx rounded-md"
                required>
                @forelse ($bank_accounts as $item)
                    <option value="{{ $item->id }}">
                        {{ $item->name }} - {{ $item->number }} - {{ $item->balance }}</option>
                @empty
                    <option disabled>Sin registros</option>
                @endforelse
            </select>
            @error('bank_account_id')
                <p class="text-red-500 font-semibold my-2">
                    {{ $message }}
                </p>
            @enderror
            {{-- end bank_account_id --}}

            {{-- select transaction_type_id --}}
            <div class="mt-2 text-sm">Tipo ingreso</div>
            <select wire:model="transaction_type_id"
                class="border-gray-300 focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50 shadow-sm mt-1 block w-full rounded-fx rounded-md"
                required>
                @forelse ($transaction_types as $item)
                    <option value="{{ $item->id }}">
                        {{ $item->name }}</option>
                @empty
                    <option disabled>Sin registros</option>
                @endforelse
            </select>
            @error('transaction_type_id')
                <p class="text-red-500 font-semibold my-2">
                    {{ $message }}
                </p>
            @enderror
            {{-- end transaction_type_id --}}

            {{-- amount --}}
            <div class="mt-4 text-sm">
                Monto
            </div>
            <x-jet-input type="number" placeholder="00.00" step="0.01" wire:model="amount"
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
            <x-jet-button type="submit"
                class="mt-4 text-sm h-12 w-full bg-primary-500 rounded-md flex items-center justify-center">
                Guardar
            </x-jet-button>
        </form>
    </div>
</div>
