<div>
    <x-slot name="header">
        <div class="font-semibold text-xl text-gray-800 leading-tight">
            Servicios por técnico
        </div>
    </x-slot>
    <div class="mx-auto p-4">
        <div class="w-full flex flex-col bg-white rounded-md py-2 px-4 gap-2">
            <div class="flex flex-col gap-2 p-4">
                <section class="flex flex-row w-full gap-4">
                    <div class="text-2xl font-bold">
                        Técnicos:
                    </div>
                    {{-- <input type="date" id="start_date" wire:model="start_date" wire:input="emitDates"
                        wire:change="changeInputDate()"> --}}

                    <select id="select-employees" wire:model="employee_id" wire:input="emitEmployee"
                        wire:change="changeSelectEmployee()">
                        <option selected>(Seleccionar)</option>
                        @forelse ($employees as $item)
                            <option value="{{ $item->id }}">
                                {{ $item->id }} |
                                {{ $item->person->name }} </option>
                        @empty
                            <option disabled>Sin registros</option>
                        @endforelse
                    </select>
                </section>


                {{-- <div>
                    <div class="font-bold mb-2">
                        Técnicos
                    </div>
                    <div class="flex items-center">
                        <select id="select-employees" wire:model="employee_id" wire:input="emitEmploye"
                            wire:change="changeSelectEmployee()">
                            @forelse ($employees as $item)
                                <option value="{{ $item->id }}">
                                    {{ $item->id }} |
                                    {{ $item->person->name }} </option>
                            @empty
                                <option disabled>Sin registros</option>
                            @endforelse
                        </select>
                    </div>
                </div> --}}


                <div class="flex text-2xl font-bold">
                    TOTAL : {{ $total }}
                </div>
            </div>
        </div>
        <div class="mt-8">
            <livewire:reports.service-by-employee-report.service-by-employee-report-data-table />
        </div>
    </div>
</div>
