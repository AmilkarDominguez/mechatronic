<?php

namespace App\Http\Livewire\Warehouse;

use Livewire\Component;
use App\Models\Warehouse;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class WarehouseCreate extends Component
{
    use LivewireAlert;  
    public $name;
    public $description;
    public $state = "ACTIVE";
    public function render()
    {
        return view('livewire.warehouse.warehouse-create');
    }
    //reglas para validacion
    protected $rules = [
        //restriccion para nombre un ico
        'name' => 'required|max:255|min:2|unique:warehouses,name',
        'description' => 'nullable',
        'state' => 'required',
    ];
    //Metodo que llama el formulario
    public function submit()
    {
        //Funcion para validar mediante las reglas
        $this->validate();
        //Creando registro
        Warehouse::create([
            'name' => $this->name,
            'description' => $this->description,
            'slug' => Str::uuid(),
            'state' => $this->state,
        ]);

        $this->cleanInputs();

        $this->confirm('Registro creado correctamente', [
            'icon' => 'success',
            'toast' => false,
            'position' => 'center',
            'showConfirmButton' => true,
            'showCancelButton' => false,
            'cancelButtonText' => 'Cancelar',
            'confirmButtonText' => 'Aceptar',
            'onConfirmed' => 'confirmed',
        ]);
    }

    //Funcion para limpiar imputs
    public function cleanInputs()
    {
        $this->name = "";
        $this->description = "";
    }

    //Escuchadores para botones de alertas
    protected $listeners = [
        'confirmed',
    ];

    //Funcion que llama la alerta para redigir al dashboar
    public function confirmed()
    {
        return redirect()->route('warehouse.dashboard');
    }
}
