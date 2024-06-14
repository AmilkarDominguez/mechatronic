<div class="w-full">
    <form wire:submit.prevent="submit" class="w-full flex flex-col">
        {{-- name --}}
        <div class="text-sm">Nombre completo</div>
        <x-jet-input type="text" placeholder="Nombre completo" wire:model="name" class="mt-1 block w-full rounded-md"
            required />
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
                    class="mt-1 block w-full rounded-md" required />
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
                    class="mt-1 block w-full rounded-md" />
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
        <x-jet-input type="text" placeholder="NIT" wire:model="nit" class="mt-1 block w-full rounded-md" />
        @error('nit')
            <p class="text-red-500 font-semibold my-2">
                {{ $message }}
            </p>
        @enderror
        {{-- end nit --}}
        {{-- email --}}
        <div class="mt-2 text-sm">Correo electrónico</div>
        <x-jet-input type="email" placeholder="Correo electrónico" wire:model="email"
            class="mt-1 block w-full rounded-md" />
        @error('email')
            <p class="text-red-500 font-semibold my-2">
                {{ $message }}
            </p>
        @enderror
        {{-- end email --}}
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
