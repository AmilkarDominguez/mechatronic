<div>
    <x-slot name="header">
        <div class="font-semibold text-xl text-gray-800 leading-tight">
            Lotes en bajo stock
        </div>
    </x-slot>
    <div class="mx-auto p-4">
        <div class="w-full flex flex-col bg-white rounded-md py-2 px-4 gap-2">
            <div class="flex flex-col gap-2 p-4">
                <section class="flex flex-row w-full gap-2">
                    <div class="text-2xl font-bold">
                        MENORES O IGUALES A:
                    </div>
                    <input type="number" min="0" id="limit" wire:model="limit" wire:input="emitLimit"
                        wire:change="changeInputLimit()">
                </section>

                <div class="flex text-2xl font-bold">
                    TOTAL : {{ $total }}
                </div>
            </div>
        </div>
        <div class="mt-8">
            <livewire:reports.batch-stock-report.batch-stock-report-data-table />
        </div>
    </div>
</div>
