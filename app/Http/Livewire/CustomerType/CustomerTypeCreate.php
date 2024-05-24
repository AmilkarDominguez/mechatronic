<?php

namespace App\Http\Livewire\CustomerType;

use Livewire\Component;
use App\Models\CustomerType;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class CustomerTypeCreate extends Component
{
    use LivewireAlert; 
    public $name;
    public $description;
    public $slug;
    public $state = "ACTIVE";
    public function render()
    {
        return view('livewire.customer-type.customer-type-create');
    }
    //reglas para validacion
    protected $rules = [
        'name' => 'required|max:20|min:2|unique:customer_types,name',
        'description' => 'nullable|max:225|min:2|',
        'state' => 'required',
    ];

    //Metodo que llama el formulario
    public function submit()
    {
        //dd($this->name,$this->description);
        //Funcion para validar mediante las reglas
        
        $this->validate();
        //Creando registro
        CustomerType::create([
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
        return redirect()->route('customer-type.dashboard');
    }
}
