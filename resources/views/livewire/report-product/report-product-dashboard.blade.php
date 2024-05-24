<div>
    <x-slot name="header">
        <div class="font-semibold text-xl text-gray-800 leading-tight">
            Top productos más vendidos
        </div>
    </x-slot>

    <section class="mt-10 md:m-10 ">
        <section class="bg-white rounded-md shadow-md w-full">
            <div class="flex flex-col justify-between gap-2 p-4 h-full">
                <div class="flex justify-between">
                    <span class="text-2xl font-bold">FECHA INICIO&nbsp;:&nbsp;</span><input type="date"
                                                                                            id="start_date"
                                                                                            wire:model="start_date"
                                                                                            wire:input="emitDates"
                                                                                            wire:change="changeInputDate()">
                </div>
                <div class="flex justify-between">
                    <span class="text-2xl font-bold">FECHA FIN&nbsp;:&nbsp;</span><input type="date"
                                                                                         id="end_date"
                                                                                         wire:model="end_date"
                                                                                         wire:input="emitDates"
                                                                                         wire:change="changeInputDate()">
                </div>
            </div>
        </section>

    </section>

    <div class="mt-10 md:m-10 ">


        <section class="flex flex-col gap-4">
            <section class="bg-white rounded-md shadow-md">
                <div class="m-4 flex flex-col gap-4">
                    <table
                        class="w-full">

                        @if(count($items)>0)
                            <thead class="bg-gray-200 h-16">
                            <tr>
                                <th class="border border-white">Producto</th>
                                <th class="border border-white">Nro. Ventas</th>
                                <th class="border border-white">Nro. Unidades</th>
                            </tr>
                            </thead>
                        @endif

                        <tbody>
                        @forelse ($items as $item)
                            <tr class="border-b h-10">
                                <td class="text-center">{{$item->name}}</td>
                                <td class="text-center">{{$item->quantity}}</td>
                                <td class="text-center">{{$item->total}}</td>
                            </tr>
                        @empty
                            <div class="mx-4 w-full text-center italic text-gray-500">No hay registros disponibles para
                                este
                                mes.
                            </div>
                        @endforelse

                        </tbody>
                    </table>
                    {{--                    <div class="w-full">--}}
                    {{--                        {{ $items->links() }}--}}
                    {{--                    </div>--}}

                </div>

            </section>

            <div wire:ignore class="bg-white rounded-md shadow-md flex justify-center flex-col ">
                <canvas id="grafica1" height="850px"></canvas>
            </div>
        </section>

    </div>


</div>


@push('custom-scripts')
    <script>


        Livewire.on('setDatesReportProduct', () => {

            buildChart();

            function getRandomInt(max) {
                return Math.floor(Math.random() * max);
            }

            function buildChart() {

                let expenses_total = @this.
                expenses_total;
                let sales_total = @this.
                sales_total;

                console.log(expenses_total)

                let items = @this.
                items
                console.log(items)


                const colors =
                    [
                        'rgba(255, 99, 132, 0.8)',
                        'rgba(255, 159, 64, 0.8)',
                        'rgba(255, 205, 86, 0.8)',
                        'rgba(75, 192, 192, 0.8)',
                        'rgba(54, 162, 235, 0.8)',
                        'rgba(153, 102, 255, 0.8)',
                        'rgba(201, 203, 207, 0.8)',
                    ];

                // const names = items.map(item => item.name);
                // const quantities = items.map(item => item.quantity);

                const names = [];
                const unit_quantities = [];
                const backgroundColors = [];

                items.forEach(item => {
                    backgroundColors.push(colors[getRandomInt(6)]);
                    names.push(item.name);
                    unit_quantities.push(item.total);
                });

                console.log(names)
                console.log(unit_quantities)
                console.log(backgroundColors)

                // Obtener una referencia al elemento canvas del DOM
                const $grafica = document.querySelector("#grafica1");
                // Las etiquetas son las que van en el eje X.
                const etiquetas = names

                // Podemos tener varios conjuntos de datos. Comencemos con uno
                const chartDataSets = {
                    label: `Gráfica`,
                    // La data es un arreglo que debe tener la misma cantidad de valores que la cantidad de etiquetas
                    data: unit_quantities,
                    backgroundColor: backgroundColors,
                    // backgroundColor: [
                    //     'rgb(239, 68, 68)',
                    //     'rgb(34, 197, 94)',
                    //     'rgb(255, 205, 86)'
                    // ], // Color de fondo // Color del borde
                    borderWidth: 1 // Ancho del borde
                };
                new Chart($grafica, {
                    type: 'bar', // Tipo de gráfica
                    data: {
                        labels: etiquetas,
                        datasets: [
                            chartDataSets,
                            // Aquí más datos...
                        ]
                    },
                    options: {
                        tooltips: {enabled: true},
                        //hover: {mode: null},
                        events:[],
                        legend: {
                            display: true,
                            labels: {
                                fontColor: 'rgb(255, 99, 132)'
                            }
                        }
                    // scales: {
                    //     yAxes: [{
                    //         ticks: {
                    //             beginAtZero: true
                    //         }
                    //     }]
                    // }
                }
                });
            }
        })


    </script>
@endpush






