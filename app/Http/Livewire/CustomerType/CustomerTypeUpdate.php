<?php

namespace App\Http\Livewire\CustomerType;

use App\Models\CustomerType;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class CustomerTypeUpdate extends Component
{
    use LivewireAlert; 
    public $name;
    public $description;
    public $slug;
    public $state;

    public function mount($slug)
    {
        $this->customertype = CustomerType::where('slug', $slug)->firstOrFail();
        if ($this->customertype) {
            $this->name = $this->customertype->name;
            $this->description = $this->customertype->description;
            $this->state = $this->customertype->state;
        }
    }
    public function render()
    {
        return view('livewire.customer-type.customer-type-update');
    }
    protected $rules = [
        'name' => 'required|max:20|min:2|unique:customer_types,name',
        'description' => 'nullable|max:225|min:2|',
        'state' => 'required',
    ];
    public function submit()
    {
        //Funcion para validar mediante las reglas
        $this->rules['name'] = 'required|unique:customer_types,name,' .$this->customertype->id;
        $this->validate();
        
        //Creando registro
        $this->customertype->update([
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
