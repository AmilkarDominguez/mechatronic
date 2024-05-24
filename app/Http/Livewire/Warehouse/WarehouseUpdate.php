<?php

namespace App\Http\Livewire\Warehouse;

use Livewire\Component;
use App\Models\Warehouse;
use Jantinnerezo\LivewireAlert\LivewireAlert;
class WarehouseUpdate extends Component
{
    use LivewireAlert;  
    public $warehouse;
    public $slug;
    public $name;
    public $description;
    public $state;


    public function mount($slug)
    {
        $this->warehouse = Warehouse::where('slug', $slug)->firstOrFail();
        if ($this->warehouse) {
            $this->name = $this->warehouse->name;
            $this->description = $this->warehouse->description;
            $this->state = $this->warehouse->state;
        }
    }
    public function render()
    {
        return view('livewire.warehouse.warehouse-update');
    }
    protected $rules = [
        'name' => 'required|max:255|min:2|unique:warehouses,name',
        'description' => 'nullable',
        'state' => 'required',
    ];
    public function submit()
    {
        //Funcion para validar mediante las reglas
        $this->rules['name'] = 'required|unique:warehouses,name,' .$this->warehouse->id;
        $this->validate();
        
        //Creando registro
        $this->warehouse->update([
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
