<div>
    <x-slot name="header">
        <div class="font-semibold text-xl text-gray-800 leading-tight">
            Registrar tipo de egreso
        </div>
    </x-slot>
    <div class="max-w-8xl mx-auto py-10 sm:px-6 lg:px-8">
        <form wire:submit.prevent="submit" class="m-10 mt-0 p-4">
            {{-- select expense_type --}}
            <div class="mt-2 text-sm">Tipo egreso</div>
            <select wire:model="expense_type_id" wire:change="onChangeSelectExpenseType"
                class="border-gray-300 focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50 shadow-sm mt-1 block w-full rounded-fx rounded-md"
                required>

                <option selected>(Seleccionar)</option>
                @forelse ($expense_types as $expensetype)
                    <option value="{{ $expensetype->id }}">
                        {{ $expensetype->name }}</option>
                @empty
                    <option disabled>Sin registros</option>
                @endforelse
            </select>

            @error('expense_type_id')
                <p class="text-red-500 font-semibold my-2">
                    {{ $message }}
                </p>
            @enderror
            {{-- end expense_type --}}

            {{-- purchase --}}
            <div class="mt-4 text-sm">
                Costo
            </div>
            <x-jet-input type="number" placeholder="Costo" wire:model="purchase" class="mt-1 block w-full rounded-md"
                required />
            @error('purchase')
                <p class="text-red-500 font-semibold my-2">
                    {{ $message }}
                </p>
            @enderror
            {{-- end purchase --}}

            {{-- description --}}
            <div class="mt-4 text-sm">
                Descripción
            </div>
            <x-textarea placeholder="Descripción" wire:model="description" class="mt-1 block w-full"/>
            @error('description')
                <p class="text-red-500 font-semibold my-2">
                    {{ $message }}
                </p>
            @enderror
            {{-- end description --}}
            {{-- state --}}
            <div class="mt-4 text-sm">
                Estado
            </div>
            <div class="mt-4 space-y-2">
                <div class="flex items-center">
                    <input wire:model="state" value="ACTIVE" type="radio"
                        class="focus:ring-primary-500 h-4 w-4 text-primary-600 border-gray-300">
                    <label for="push_everything" class="ml-2 block text-sm font-medium text-gray-700">
                        Activo
                    </label>
                </div>
                <div class="flex items-center">
                    <input wire:model="state" value="INACTIVE" type="radio"
                        class="focus:ring-primary-500 h-4 w-4 text-primary-600 border-gray-300">
                    <label for="push_email" class="ml-2 block text-sm font-medium text-gray-700">
                        Inactivo
                    </label>
                </div>
            </div>
            {{-- end state --}}
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
