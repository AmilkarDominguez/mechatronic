<?php

namespace App\Http\Livewire\IdentityDocumentType;

use App\Models\IdentityDocumentType;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\TimeColumn;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\BooleanColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class IdentityDocumentTypeDataTable extends LivewireDatatable
{
    //Using de alert
    use LivewireAlert;

    public $exportable = true;
    public $model = IdentityDocumentType::class;
    

    public function builder()
    {
        return IdentityDocumentType::query()->where('state', '!=', 'DELETED');
    }
    public function columns()
    {
        return [

            Column::name('name')
                ->searchable()
                ->label('Nombre'),

            Column::name('description')
                ->label('descripción'),

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

            Column::callback(['slug'], function ($slug) {
                return view('livewire.identity-document-type.identity-document-type-table-actions', ['slug' => $slug]);
            })->label('Opciones')
                ->excludeFromExport()
        ];
    }

    public $identityDocumentTypeForDeleted;
    //Funcion para preguntar la eliminacion, muestra alerta
    public function toastConfirmDelet($slug)
    {
        $this->identityDocumentTypeForDeleted = IdentityDocumentType::where('slug', $slug)->first();
        $this->confirm(__('¿Estás seguro de que deseas eliminar el registro?'), [
            'icon' => 'warning',
            'position' =>  'center',
            'toast' =>  false,
            'text' =>  $this->identityDocumentTypeForDeleted->name,
            'confirmButtonText' =>  'Si',
            'showConfirmButton' =>  true,
            'showCancelButton' => true,
            'onConfirmed' => 'confirmed',
            'confirmButtonColor' => '#A5DC86',
        ]);
    }
    // Listener para eliminar
    protected $listeners = [
        'confirmed',
    ];
    //Funcion para confirmar la eliminacion
    public function confirmed()
    {
        if ($this->identityDocumentTypeForDeleted) {
            //Asignando estado DELETED
            $this->identityDocumentTypeForDeleted->state = "DELETED";
            //Guardando el registro
            $this->identityDocumentTypeForDeleted->update();
        }
    }
}
