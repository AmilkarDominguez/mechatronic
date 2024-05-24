<?php

namespace App\Http\Livewire\Service;

use App\Models\Service;
use Illuminate\Support\Carbon;
use App\Models\Municipality;
use Illuminate\Support\Facades\DB;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\TimeColumn;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\BooleanColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ServiceDataTable extends LivewireDatatable
{
    use LivewireAlert;
    public $exportable = true;
    public $model = Service::class;
    public function builder()
    {
        //return Service::query();
        return Service::query()->where('state', '!=', 'DELETED');
    }

    public function columns()
    {
        return [

            Column::name('code')
                ->searchable()
                ->label('Código'),

            Column::name('name')
                ->searchable()
                ->label('Nombre'),

            Column::name('description')
                ->searchable()
                ->label('Descripción'),

            Column::name('price')
                ->searchable()
                ->label('Precio'),

            Column::callback(['state'], function ($state) {
                return view('components.datatables.state-data-table', ['state' => $state]);
            })
                ->exportCallback(function ($state) {
                    $state == 'ACTIVE' ? $state = 'ACTIVO' : $state = 'INACTIVO';
                    return (string) $state;
                })
                ->label('Estado')
                ->filterable([
                    'ACTIVE',
                    'INACTIVE'
                ]),

            DateColumn::name('created_at')
                ->label('Creado')
                ->format('d/m/Y h:i:s')
                ->filterable(),

            Column::callback(['slug'], function ($slug) {
                return view('livewire.service.service-table-actions', ['slug' => $slug]);
            })->label('Opciones')
                ->excludeFromExport()


        ];
    }

    public $ServiceoDelet;
    public function toastConfirmDelet($slug)
    {
        $this->ServiceoDelet = Service::where('slug', $slug)->first();
        $this->confirm(__('¿Estás seguro de que deseas eliminar el registro?'), [
            'icon' => 'warning',
            'position' =>  'center',
            'toast' =>  false,
            'text' =>  $this->ServiceoDelet->name,
            'confirmButtonText' =>  'Si',
            'showConfirmButton' =>  true,
            'showCancelButton' => true,
            'onConfirmed' => 'confirmed',
            'confirmButtonColor' => '#A5DC86',
        ]);
    }

    protected $listeners = [
        'confirmed',
    ];
    public function confirmed()
    {
        if ($this->ServiceoDelet) {

            $this->ServiceoDelet->state = "DELETED";
            $this->ServiceoDelet->update();
        }
    }
}
