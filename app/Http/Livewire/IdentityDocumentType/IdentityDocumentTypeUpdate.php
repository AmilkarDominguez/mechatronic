<?php

namespace App\Http\Livewire\IdentityDocumentType;

use App\Models\IdentityDocumentType;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class IdentityDocumentTypeUpdate extends Component
{
    //Using de alert
    use LivewireAlert;

    //varibles para propiedades
    public $name;
    public $description;
    public $state;

    public function render()
    {
        return view('livewire.identity-document-type.identity-document-type-update');
    }

    public function mount($slug)
    {
        $this->identityDocumentType = IdentityDocumentType::where('slug', $slug)->firstOrFail();
        if ($this->identityDocumentType) {
            $this->name = $this->identityDocumentType->name;
            $this->description = $this->identityDocumentType->description;
            $this->state = $this->identityDocumentType->state;
        }
    }
  
    protected $rules = [
        'name' => 'required|max:100|min:2|unique:identity_document_types,name',
        'description' => 'nullable|max:100|min:2',
        'state' => 'required',
    ];
    public function submit()
    {
        //Funcion para validar mediante las reglas
        $this->rules['name'] = 'required|unique:identity_document_types,name,' . $this->identityDocumentType->id;
        $this->validate();

        //Actualizar registro
        $this->identityDocumentType->update([
            'name' => $this->name,
            'description' => $this->description,
            'state' => $this->state,
        ]);
        //Llamando Alerta
        $this->alert('success', 'Registro actualizado correctamente', [
            'toast' => true,
            'position' => 'top-end',
        ]);
    }
}
