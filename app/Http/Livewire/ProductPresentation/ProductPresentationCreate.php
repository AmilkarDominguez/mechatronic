<?php

namespace App\Http\Livewire\ProductPresentation;

use Livewire\Component;
use App\Models\ProductPresentation;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ProductPresentationCreate extends Component
{
    use LivewireAlert;
    public $name;
    public $code;
    public $description;
    public $slug;
    public $state = "ACTIVE";
    public function render()
    {
        return view('livewire.product-presentation.product-presentation-create');
    }
    //reglas para validacion
    protected $rules = [
        'name' => 'required|max:20|min:2|unique:product_presentations,name',
        'code' => 'required',
        'description' => 'nullable|max:225|min:2|',
        'state' => 'required',
    ];

    //Metodo que llama el formulario
    public function submit()
    {
        $this->validate();
        //Creando registro
        ProductPresentation::create([
            'name' => $this->name,
            'code' => $this->code,
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
        return redirect()->route('product-presentation.dashboard');
    }
}
