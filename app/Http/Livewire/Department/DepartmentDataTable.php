<?php

namespace App\Http\Livewire\Department;

use Livewire\Component;
use App\Models\Department;
use App\Models\Country;
use Illuminate\Support\Facades\DB;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\TimeColumn;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\BooleanColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class DepartmentDataTable extends LivewireDatatable
{
    use LivewireAlert;

    public $exportable = true;
    public $model = Department::class;
    

    public function builder()
    {
        return (Department::query()
            ->where('departments.state', '!=', 'DELETED')
            ->join('countries as countrie', function($join) {
                $join->on('countrie.id', '=', 'departments.country_id');
            })
        );
    }
    public function columns()
    {
        return [

            Column::name('name')
                ->searchable()
                ->label('Nombre'), 
            
               Column::name('countrie.name')
                 ->searchable()
                ->label('País'),
               
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
                return view('livewire.department.department-table-actions', ['slug' => $slug]);
            })->label('Opciones')
                ->excludeFromExport()
        ];
    }

    public $DepartmentDeleted;
    public function toastConfirmDelet($slug)
    {
        $this->DepartmentDeleted = Department::where('slug', $slug)->first();
        $this->confirm(__('¿Estas seguro que seas eliminar el registro?'), [
            'icon' => 'warning',
            'position' =>  'center',
            'toast' =>  false,
            'text' =>  $this->DepartmentDeleted->name,
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
        if ($this->DepartmentDeleted) {
            //Asignando estado DELETED
            $this->DepartmentDeleted->state = "DELETED";
            //Guardando el registro
            $this->DepartmentDeleted->update();
        }
    }
}
