<div>
    <x-slot name="header">
        <div class="font-semibold text-xl text-gray-800 leading-tight">
            Importar categorías
        </div>
    </x-slot>

    <div class="bg-white m-8 p-8 rounded-lg">
        <p>Seleccione o arrastre el archivo de Excel </p>
{{--        <div class="my-2">--}}
{{--            <a href="{{ asset('/files/plantilla_tipo_presentacion.xlsx') }}" class=" text-primary-500" download><i--}}
{{--                    class="fas fa-download"></i> Descargar plantilla</a>--}}
{{--        </div>--}}
        <label>
            <input type="file" name="file" class="border-2 border-dashed border-primary-200 w-full p-4  text-center"
                   wire:model="file_"
                   accept="application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
        </label>


        @if ($file_ != null)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="col-span-1"></div>
                <div class=" col-span-1 ">
                    <a wire:click="import_confirm"
                       class="my-4 h-12 bg-primary-500 w-full rounded-full flex items-center justify-center hover:bg-primary-200 cursor-pointer text-white">
                        IMPORTAR
                    </a>
                    <section  wire:loading class="w-full">
                        <div class="bg-green-400 flex items-center justify-center text-green-900-50 py-2 w-full opacity-50">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor" class="animate-spin w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M4.5 12a7.5 7.5 0 0015 0m-15 0a7.5 7.5 0 1115 0m-15 0H3m16.5 0H21m-1.5 0H12m-8.457 3.077l1.41-.513m14.095-5.13l1.41-.513M5.106 17.785l1.15-.964m11.49-9.642l1.149-.964M7.501 19.795l.75-1.3m7.5-12.99l.75-1.3m-6.063 16.658l.26-1.477m2.605-14.772l.26-1.477m0 17.726l-.26-1.477M10.698 4.614l-.26-1.477M16.5 19.794l-.75-1.299M7.5 4.205L12 12m6.894 5.785l-1.149-.964M6.256 7.178l-1.15-.964m15.352 8.864l-1.41-.513M4.954 9.435l-1.41-.514M12.002 12l-3.75 6.495"/>
                            </svg>
                            Procesando datos...
                        </div>
                    </section>

                </div>
            </div>
        @endif
    </div>
</div>
