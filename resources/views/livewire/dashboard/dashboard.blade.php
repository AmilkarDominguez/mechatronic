<div>
    <x-slot name="header">
        <label class="font-semibold text-xl text-gray-800 leading-tight">
            Panel de administración
        </label>
    </x-slot>

    {{-- <section class="flex items-center justify-center">
        <div class="mt-10 text-primary-500 text-4xl font-bold">¡Bienvenido!</div>
    </section> --}}

    <section class="my-10 md:m-10 grid grid-cols-1 md:grid-cols-1 gap-4">

        {{-- <section class="bg-white rounded-md shadow-md">
            <div class="text-2xl font-bold text-center my-4 uppercase">
                Vencimientos del mes
                <select wire:model="current_month">
                    <option value="1">Enero</option>
                    <option value="2">Febrero</option>
                    <option value="3">Marzo</option>
                    <option value="4">Abril</option>
                    <option value="5">Mayo</option>
                    <option value="6">Junio</option>
                    <option value="7">Julio</option>
                    <option value="8">Agosto</option>
                    <option value="9">Septiembre</option>
                    <option value="10">Octubre</option>
                    <option value="11">Noviembre</option>
                    <option value="12">Diciembre</option>
                </select>
                de {{ now()->year }}
            </div>
            <div class="m-4 flex flex-col gap-4">
                <table
                    class="w-full">

                    @if(count($batches)>0)
                        <thead class="bg-gray-200 h-16">
                        <tr>
                            <th class="border border-white"></th>
                            <th class="border border-white">Producto</th>
                            <th class="border border-white">Vencimiento <br> (Día-Mes-Año)</th>
                        </tr>
                        </thead>
                    @endif

                    <tbody>
                    @forelse ($batches as $item)
                        <tr class="border-b h-10">
                            <td class="text-center">
                                <a href="{{ route('batch.update', $item->slug) }}"
                                   class="p-1 text-blue-600">
                                    Ver
                                </a>
                            </td>
                            <td class="text-center">{{$item->product->name}}</td>
                            <td class="text-center">

                                @if(date('d',strtotime($item->expiration_date)) <= ($current_day+10))
                                    <span
                                        class=" bg-red-200 text-red-800 px-2 rounded-full">{{date('d-m-Y',strtotime($item->expiration_date))}}</span>
                                @else
                                    <span class="px-2">{{date('d-m-Y',strtotime($item->expiration_date))}}</span>
                                @endif

                            </td>
                        </tr>
                    @empty
                        <div class="mx-4 w-full text-center italic text-gray-500">No hay registros disponibles para este
                            mes.
                        </div>
                    @endforelse

                    </tbody>
                </table>
                <div class="w-full">
                    {{ $batches->links() }}
                </div>

            </div>

        </section> --}}

        <section>

            <section class="grid grid-cols-1 md:grid-cols-3 gap-4">

                <div class="bg-white rounded-md shadow-md flex justify-center flex-col p-4">
                    <h1 class="text-xl font-bold text-center">Ordenes Completadas</h1>
                    <h2 class="text-2xl font-bold text-center">{{$count_comleted_services_ordes}}</h2>
                </div>

                <div class="bg-white rounded-md shadow-md flex justify-center flex-col p-4">
                    <h1 class="text-xl font-bold text-center">Ordenes en Curso</h1>
                    <h2 class="text-2xl font-bold text-center">{{$count_pending_services_ordes}}</h2>
                </div>

                <div class="bg-white rounded-md shadow-md flex justify-center flex-col p-4">
                    <h1 class="text-xl font-bold text-center">Clientes Totales</h1>
                    <h2 class="text-2xl font-bold text-center">{{$total_customers}}</h2>
                </div>

                <div wire:ignore class="col-span-3 bg-white rounded-md shadow-md flex justify-center flex-col p-4">
                    <canvas id="grafica1" height="350px"></canvas>
                </div>

                <div wire:ignore class="col-span-3 bg-white rounded-md shadow-md flex justify-center flex-col p-4">
                    <canvas id="grafica2" height="350px"></canvas>
                </div>

                <div wire:ignore class="col-span-3 bg-white rounded-md shadow-md flex justify-center flex-col p-4">
                    <canvas id="grafica3" height="350px"></canvas>
                </div>

            </section>
        </section>
    </section>

</div>

@push('custom-scripts')
    <script>

        document.addEventListener('livewire:load', function () {
            let data_months = @this.chart_data_months;
            let months = @this.chart_months;
            let sales_totals = @this.chart_data_months_total;
            const current_year = @this.current_year;

            data_months = Object.values(data_months);
            months = Object.values(months);
            sales_totals = Object.values(sales_totals);
            console.log(sales_totals)

            chart_1();
            chart_2();
            chart_3();



            function chart_1() {
                // Obtener una referencia al elemento canvas del DOM
                const $grafica = document.querySelector("#grafica1");
                // Las etiquetas son las que van en el eje X.
                //const etiquetas = ["Enero", "Febrero", "Marzo", "Abril", "Mayo"]
                const etiquetas = months
                // Podemos tener varios conjuntos de datos. Comencemos con uno
                const chartDataSets = {
                    label: `Ventas ${current_year}`,
                    // La data es un arreglo que debe tener la misma cantidad de valores que la cantidad de etiquetas
                    // data: [5000, 1500, 8000,
                    //     5102
                    // ],
                    data: data_months,
                    backgroundColor: 'rgba(104, 117, 245, 0.2)', // Color de fondo
                    borderColor: 'rgba(104, 117, 245, 1)', // Color del borde
                    borderWidth: 1, // Ancho del borde
                };
                new Chart($grafica, {
                    type: 'line', // Tipo de gráfica
                    data: {
                        labels: etiquetas,
                        datasets: [
                            chartDataSets,
                            // Aquí más datos...
                        ]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }],
                        },
                    }
                });
            }

            function chart_2() {
                // Obtener una referencia al elemento canvas del DOM
                const $grafica = document.querySelector("#grafica2");
                // Las etiquetas son las que van en el eje X.
                //const etiquetas = ["Enero", "Febrero", "Marzo", "Abril", "Mayo"]
                const etiquetas = months
                // Podemos tener varios conjuntos de datos. Comencemos con uno
                const chartDataSets = {
                    label: `Ventas ${current_year}`,
                    // La data es un arreglo que debe tener la misma cantidad de valores que la cantidad de etiquetas
                    // data: [5000, 1500, 8000,
                    //     5102
                    // ],
                    data: data_months,
                    backgroundColor: 'rgba(104, 117, 245, 0.2)', // Color de fondo
                    borderColor: 'rgba(104, 117, 245, 1)', // Color del borde
                    borderWidth: 1, // Ancho del borde
                };
                new Chart($grafica, {
                    type: 'bar', // Tipo de gráfica
                    data: {
                        labels: etiquetas,
                        datasets: [
                            chartDataSets
                            // Aquí más datos...
                        ]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }],
                        },
                    }
                });
            }

            function chart_3() {
                // Obtener una referencia al elemento canvas del DOM
                const $grafica = document.querySelector("#grafica3");
                // Las etiquetas son las que van en el eje X.
                //const etiquetas = ["Enero", "Febrero", "Marzo", "Abril", "Mayo"]
                const etiquetas = months
                // Podemos tener varios conjuntos de datos. Comencemos con uno
                const chartDataSets = {
                    label: `Ingresos por mes ${current_year}`,
                    // La data es un arreglo que debe tener la misma cantidad de valores que la cantidad de etiquetas
                    // data: [5000, 1500, 8000,
                    //     5102
                    // ],
                    data: sales_totals,
                    backgroundColor: 'rgba(104,243,245,0.5)', // Color de fondo
                    borderColor: 'rgb(104,243,245)', // Color del borde
                    borderWidth: 1, // Ancho del borde
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
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }],
                        },
                    }
                });
            }
        })



    </script>
@endpush
