<div>
    <x-slot name="header">
        <div class="font-semibold text-xl text-gray-800 leading-tight">
            Cumpleañeros
        </div>
    </x-slot>
    <div class="mx-auto p-4">
        <div class="w-full flex flex-col bg-white rounded-md py-2 px-4 gap-2">
            <div class="flex flex-col gap-2 p-4">
                <section class="flex flex-row w-full">
                    <div class=" w-48 text-2xl font-bold">
                        FECHA INICIO:
                    </div>
                    <input type="date" id="start_date" wire:model="start_date" wire:input="emitDates"
                        wire:change="changeInputDate()">
                </section>


                <section class="flex flex-row w-full">
                    <div class=" w-48 text-2xl font-bold">
                        FECHA FIN:
                    </div>
                    <input type="date" id="end_date"
                    wire:model="end_date" wire:input="emitDates" wire:change="changeInputDate()">
                </section>

                <div class="flex text-2xl font-bold">
                    TOTAL : {{ $total }}
                </div>
            </div>
        </div>
        <div class="mt-8">
            <livewire:reports.birthday-report.birthday-report-data-table />
        </div>
    </div>
</div>
