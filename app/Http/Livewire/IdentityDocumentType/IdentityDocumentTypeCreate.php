<?php

namespace App\Http\Livewire\IdentityDocumentType;

use App\Models\IdentityDocumentType;
use Livewire\Component;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class IdentityDocumentTypeCreate extends Component
{
    //Using de alert
    use LivewireAlert;

    //varibles para propiedades
    public $name;
    public $description;
    public $slug;
    public $state = "ACTIVE";
    public function render()
    {
        return view('livewire.identity-document-type.identity-document-type-create');
    }
    //reglas para validacion
    protected $rules = [
        'name' => 'required|max:100|min:2|unique:identity_document_types,name',
        'description' => 'nullable|max:100|min:2',
        'state' => 'required',
    ];

    //Metodo que llama el formulario
    public function submit()
    {
        //Funcion para validar mediante las reglas
        $this->validate();

        //Creando registro
        IdentityDocumentType::create([
            'name' => $this->name,
            'description' => $this->description,
            //generar slug
            'slug' => Str::uuid(),
            'state' => $this->state,
        ]);

        //Llamando a funcion para limpiar inputs
        $this->cleanInputs();

        //Mostrar alerta de registro
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
        $this->state = "ACTIVE";
    }

    //Escuchadores para botones de alertas
    protected $listeners = [
        'confirmed',
    ];

    //Funcion que llama la alerta para redigir al dashboard
    public function confirmed()
    {
        return redirect()->route('identity-document-type.dashboard');
    }
}
