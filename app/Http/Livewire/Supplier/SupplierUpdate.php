<?php

namespace App\Http\Livewire\Supplier;

use Livewire\Component;
use App\Models\Supplier;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class SupplierUpdate extends Component
{
    use LivewireAlert;  
    public $supplier;
    public $slug;
    public $name;
    public $description;
    public $state;


    public function mount($slug)
    {
        $this->supplier = Supplier::where('slug', $slug)->firstOrFail();
        if ($this->supplier) {
            $this->name = $this->supplier->name;
            $this->description = $this->supplier->description;
            $this->state = $this->supplier->state;
        }
    }
    public function render()
    {
        return view('livewire.supplier.supplier-update');
    }
    protected $rules = [
        'name' => 'required|max:255|min:2|unique:suppliers,name',
        'description' => 'nullable',
        'state' => 'required',
    ];
    public function submit()
    {
        //Funcion para validar mediante las reglas
        $this->rules['name'] = 'required|unique:suppliers,name,' .$this->supplier->id;
        $this->validate();
        
        //Creando registro
        $this->supplier->update([
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
