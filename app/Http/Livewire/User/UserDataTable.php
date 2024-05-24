<?php

namespace App\Http\Livewire\User;

use App\Models\User;
use App\Models\Person;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\TimeColumn;
use Mediconesystems\LivewireDatatables\NumberColumn;
use Mediconesystems\LivewireDatatables\BooleanColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class UserDataTable extends LivewireDatatable
{
    use LivewireAlert;
    public $exportable = true;
    public $model = User::class;
    
    

    public function builder()
    {

        return (User::query()
        ->where('state', '!=', 'DELETED')
        ->join('people as person', function ($join) {
            $join->on('person.id', '=', 'users.person_id');
        }));
        
    }

    public function columns()
    {
        return [
            Column::name('person.name')
                ->searchable()
                ->label('Nombre completo')
                ->alignRight(),
        
            Column::name('email')
                ->searchable()
                ->label('Correo electrónico')
                ->alignRight(),

            Column::callback(['state'], function ($state) {
                return view('components.datatables.state-data-table', ['state' => $state]);
            })
                ->label('Estado')
                ->filterable([
                    'ACTIVE',
                    'INACTIVE'
                ]),
            Column::callback(['slug'], function ($slug) {
                return view('livewire.user.user-table-actions', ['slug' => $slug]);
            })->label('Opciones')
            ->excludeFromExport()


        ];
    }
    public $idDelet;
    public function toastConfirmDelet($slug)
    {
        $user = User::where('slug', $slug)->firstOrFail();
        $this->idDelet = $user->id;
        $this->confirm(__('¿Estás seguro de que deseas eliminar el registro?'), [
            'icon' => 'warning',
            'position' =>  'center',
            'toast' =>  false,
            'text' =>  'Usuario '.$user->email,
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
        if ($this->idDelet) {
            $User = User::find($this->idDelet);
            $User->state = "DELETED";
            $User->update();
        }
    }
}
