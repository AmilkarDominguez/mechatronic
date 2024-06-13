<?php

namespace App\Http\Livewire\ExtraItem;

use App\Models\ExtraItem;
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

class ExtraItemDataTable extends LivewireDatatable
{
    use LivewireAlert;
    public $exportable = true;
    public $model = ExtraItem::class;
    public $ExtraItemSelected;
    public function builder()
    {
        return ExtraItem::query()->where('state', '!=', 'DELETED');
    }

    public function columns()
    {
        return [

            Column::name('name')
                ->searchable()
                ->label('Nombre'),

            Column::name('description')
                ->searchable()
                ->label('Descripción'),

            Column::name('cost')
                ->searchable()
                ->label('Costo'),

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
                return view('livewire.extra-item.extra-item-table-actions', ['slug' => $slug]);
            })->label('Opciones')
                ->excludeFromExport()


        ];
    }

    public function toastConfirmDelet($slug)
    {
        $this->ExtraItemSelected = ExtraItem::where('slug', $slug)->first();
        $this->confirm(__('¿Estás seguro de que deseas eliminar el registro?'), [
            'icon' => 'warning',
            'position' =>  'center',
            'toast' =>  false,
            'text' =>  $this->ExtraItemSelected->name,
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
        if ($this->ExtraItemSelected) {
            $this->ExtraItemSelected->state = "DELETED";
            $this->ExtraItemSelected->update();
        }
    }
}
