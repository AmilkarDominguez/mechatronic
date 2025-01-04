<div>
    <x-slot name="header">
        <div class="font-semibold text-xl text-gray-800 leading-tight">
            Utilidades
        </div>
    </x-slot>


    <section class="my-10 md:m-10 grid grid-cols-1 md:grid-cols-12  gap-4">
        <section class="bg-white rounded-md shadow-md col-span-5">
            <div class="flex flex-col justify-between gap-2 p-4 h-full">
                <div class="flex justify-between">
                    <span class="text-2xl font-bold">FECHA INICIO&nbsp;:&nbsp;</span><input type="date" id="start_date"
                        wire:model="start_date" wire:input="emitDates" wire:change="changeInputDate()">
                </div>
                <div class="flex justify-between">
                    <span class="text-2xl font-bold">FECHA FIN&nbsp;:&nbsp;</span><input type="date" id="end_date"
                        wire:model="end_date" wire:input="emitDates" wire:change="changeInputDate()">
                </div>
            </div>
        </section>
        <section class="bg-white rounded-md shadow-md col-span-5">
            <div class="flex flex-col justify-between gap-2 p-4 h-full">
                <div class="flex justify-between text-2xl font-bold">
                    <span>EGRESOS&nbsp;:&nbsp;</span><span class="text-red-500">{{ $expenses_total }}</span>
                </div>
                <div class="flex justify-between text-2xl font-bold">
                    <span>INGRESOS&nbsp;:&nbsp;</span><span class="text-green-500">{{ $incomes_total }}</span>
                </div>
                <hr>
                <div class="flex justify-between text-2xl font-bold">
                    <span>Utilidad&nbsp;:&nbsp;</span><span class="text-blue-500">{{ $utility }}</span>
                </div>
            </div>
        </section>

        <section class="bg-white rounded-md shadow-md col-span-2">


            <div wire:ignore class="p-2">
                <canvas id="grafica1"></canvas>
            </div>

        </section>

    </section>


    <div class="max-w-full mx-auto py-10 sm:px-6 lg:px-8">
        <div class="m-5">
            <div class="text-2xl font-bold mb-4 text-green-500">
                INGRESOS
            </div>
            <livewire:reports.utility-report.utility-report-incomes-data-table />
            <br>
            <br>
            <div class="text-2xl font-bold mb-4 text-red-500">
                EGRESOS
            </div>
            <livewire:reports.utility-report.utility-report-expenses-data-table />
        </div>
    </div>

</div>

@push('custom-scripts')
    <script>
        Livewire.on('setDates', () => {

            buildChart();

            function buildChart() {

                let expenses_total = @this.expenses_total;
                let incomes_total = @this.incomes_total;

                // Obtener una referencia al elemento canvas del DOM
                const $grafica = document.querySelector("#grafica1");
                // Las etiquetas son las que van en el eje X.
                const etiquetas = ["EGRESOS", "INGRESOS "]

                // Podemos tener varios conjuntos de datos. Comencemos con uno
                const chartDataSets = {
                    label: `Gráfica`,
                    // La data es un arreglo que debe tener la misma cantidad de valores que la cantidad de etiquetas
                    data: [expenses_total, incomes_total],
                    backgroundColor: [
                        'rgb(239, 68, 68)',
                        'rgb(34, 197, 94)',
                        'rgb(255, 205, 86)'
                    ], // Color de fondo // Color del borde
                    hoverOffset: 4 // Ancho del borde
                };
                new Chart($grafica, {
                    type: 'doughnut', // Tipo de gráfica
                    data: {
                        labels: etiquetas,
                        datasets: [
                            chartDataSets,
                            // Aquí más datos...
                        ]
                    },
                });
            }
        })
    </script>
@endpush
