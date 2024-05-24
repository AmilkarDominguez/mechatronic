<?php

namespace App\Http\Livewire\Product;

use App\Models\Product;
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

class ProductDataTable extends LivewireDatatable
{
    use LivewireAlert;
    public $exportable = true;
    public $model = Product::class;
    public function builder()
    {
        //return Product::query();
        return Product::query()->where('state', '!=', 'DELETED');
    }

    public function columns()
    {
        return [
            Column::callback(['photo'], function ($photo) {
                return view('components.datatables.image-data-table', ['image' => $photo]);
            })->label('Foto')
                ->excludeFromExport(),

            Column::name('code')
                ->searchable()
                ->label('Código'),

            Column::name('name')
                ->searchable()
                ->label('Nombre'),

            Column::name('description')
                ->searchable()
                ->label('Descripción'),

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
                return view('livewire.product.product-table-actions', ['slug' => $slug]);
            })->label('Opciones')
                ->excludeFromExport()


        ];
    }

    public $ProductoDelet;
    public function toastConfirmDelet($slug)
    {
        $this->ProductoDelet = Product::where('slug', $slug)->first();
        $this->confirm(__('¿Estás seguro de que deseas eliminar el registro?'), [
            'icon' => 'warning',
            'position' =>  'center',
            'toast' =>  false,
            'text' =>  $this->ProductoDelet->name,
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
        if ($this->ProductoDelet) {

            $this->ProductoDelet->state = "DELETED";
            $this->ProductoDelet->update();
        }
    }
}
