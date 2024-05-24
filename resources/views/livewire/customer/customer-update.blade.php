<div>
    <x-slot name="header">
        <div class="font-semibold text-xl text-gray-800 leading-tight">
            Actualizar cliente
        </div>
    </x-slot>
    <div class="max-w-8xl mx-auto py-10 sm:px-6 lg:px-8">
        <form wire:submit.prevent="submit" class="m-10 mt-0 p-4">
            {{-- name --}}
            <div class="mt-4 text-sm">Nombre completo</div>
            <x-jet-input type="text" placeholder="Nombre completo" wire:model="name"
                         class="mt-1 block w-full rounded-md"
                         required/>
            @error('name')
            <p class="text-red-500 font-semibold my-2">
                {{ $message }}
            </p>
            @enderror
            {{-- end name --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-2">
                <div class="col-span-1 md:col-span-2">
                    {{-- ci --}}
                    <div class="mt-2 text-sm">CI</div>
                    <x-jet-input type="number" placeholder="Nro. Cédula de identidad" wire:model="ci"
                                 class="mt-1 block w-full rounded-md" required/>
                    @error('ci')
                    <p class="text-red-500 font-semibold my-2">
                        {{ $message }}
                    </p>
                    @enderror
                    {{-- end ci --}}
                </div>
                <div class="col-span-1 md:col-span-1">
                    {{-- select expedition_ci --}}
                    <div class="mt-2 text-sm">Lugar de expedición</div>
                    <select wire:model="expedition_ci"
                            class="border-gray-300 focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50 shadow-sm mt-1 block w-full rounded-md"
                            required>
                        <option value="" selected>(Seleccionar)</option>
                        <option value="CH">CH Chuquisaca</option>
                        <option value="LP">LP La Paz</option>
                        <option value="CB">CB Cochabamba</option>
                        <option value="OR">OR Oruro</option>
                        <option value="PT">PT Potosí</option>
                        <option value="TJ">TJ Tarija</option>
                        <option value="SC">SC Santa Cruz</option>
                        <option value="BE">BE Beni</option>
                        <option value="PD">PD Pando</option>
                    </select>
                    @error('expedition_ci')
                    <p class="text-red-500 font-semibold my-2">
                        {{ $message }}
                    </p>
                    @enderror
                    {{-- end select expedition_ci --}}
                </div>
                <div class="col-span-1 md:col-span-1">
                    {{-- code_ci --}}
                    <div class="mt-2 text-sm">Complemento (opcional)</div>
                    <x-jet-input type="text" placeholder="Complemento (opcional)" wire:model="code_ci"
                                 class="mt-1 block w-full rounded-md"/>
                    @error('code_ci')
                    <p class="text-red-500 font-semibold my-2">
                        {{ $message }}
                    </p>
                    @enderror
                    {{-- end code_ci --}}
                </div>
            </div>
            {{-- nit --}}
            <div class="mt-2 text-sm">NIT</div>
            <x-jet-input type="text" placeholder="NIT" wire:model="nit" class="mt-1 block w-full rounded-md"/>
            @error('nit')
            <p class="text-red-500 font-semibold my-2">
                {{ $message }}
            </p>
            @enderror
            {{-- end nit --}}
            {{-- address --}}
            <div class="mt-2 text-sm">Dirección</div>
            <x-textarea placeholder="Dirección" wire:model="address" class="mt-1 block w-full"/>
            @error('address')
            <p class="text-red-500 font-semibold my-2">
                {{ $message }}
            </p>
            @enderror
            {{-- end address --}}
            {{-- email --}}
            <div class="mt-2 text-sm">Correo electrónico</div>
            <x-jet-input type="email" placeholder="Correo electrónico" wire:model="email"
                         class="mt-1 block w-full rounded-md"/>
            @error('email')
            <p class="text-red-500 font-semibold my-2">
                {{ $message }}
            </p>
            @enderror
            {{-- end email --}}
            {{-- select customer_type --}}
            {{--            <div class="mt-2 text-sm">Tipo cliente</div>--}}
            {{--            <select wire:model="customer_type_id" wire:change="onChangeSelectCustomerType"--}}
            {{--                class="border-gray-300 focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50 shadow-sm mt-1 block w-full rounded-fx rounded-md"--}}
            {{--                required>--}}

            {{--                <option selected>(Seleccionar)</option>--}}
            {{--                @forelse ($customer_types as $customertype)--}}
            {{--                    <option value="{{ $customertype->id }}">--}}
            {{--                        {{ $customertype->name }}</option>--}}
            {{--                @empty--}}
            {{--                    <option disabled>Sin registros</option>--}}
            {{--                @endforelse--}}
            {{--            </select>--}}

            {{--            @error('customer_type_id')--}}
            {{--                <p class="text-red-500 font-semibold my-2">--}}
            {{--                    {{ $message }}--}}
            {{--                </p>--}}
            {{--            @enderror--}}
            {{-- end customer_type --}}
            {{-- telephones --}}
            <div class="mt-2 text-base opacity-40 uppercase">Teléfonos</div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                <div class="col-span-1 md:col-span-1">
                    {{-- telephone_whatsapp --}}
                    <div class="mt-2 text-sm">Nro. Principal (Whatsapp)</div>
                    <x-jet-input type="number" placeholder="Nro. Principal (Whatsapp)" wire:model="telephone_whatsapp"
                                 class="mt-1 block w-full rounded-md"/>
                    @error('telephone_whatsapp')
                    <p class="text-red-500 font-semibold my-2">
                        {{ $message }}
                    </p>
                    @enderror
                    {{-- end telephone_whatsapp --}}
                </div>
                <div class="col-span-1 md:col-span-1">
                    {{-- telephone_secondary --}}
                    <div class="mt-2 text-sm">Nro. Secundario</div>
                    <x-jet-input type="number" placeholder="Nro. Secundario" wire:model="telephone_secondary"
                                 class="mt-1 block w-full rounded-md"/>
                    @error('telephone_secondary')
                    <p class="text-red-500 font-semibold my-2">
                        {{ $message }}
                    </p>
                    @enderror
                    {{-- end telephone_secondary --}}
                </div>
                <div class="col-span-1 md:col-span-1">
                    {{-- landline --}}
                    <div class="mt-2 text-sm">Teléfono fijo</div>
                    <x-jet-input type="number" placeholder="Teléfono fijo" wire:model="landline"
                                 class="mt-1 block w-full rounded-md"/>
                    @error('landline')
                    <p class="text-red-500 font-semibold my-2">
                        {{ $message }}
                    </p>
                    @enderror
                    {{-- end landline --}}
                </div>
            </div>
            {{-- end telephones --}}
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
            <x-jet-label class="mt-4" value="Estado"/>
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
            <x-jet-button type="submit" class="mt-4 h-12 w-full rounded-md flex items-center justify-center">
                Guardar
            </x-jet-button>
        </form>
    </div>
</div>
