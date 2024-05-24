<?php

namespace App\Http\Livewire\ExpenseType;

use Livewire\Component;
use App\Models\ExpenseType;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ExpenseTypeUpdate extends Component
{
    use LivewireAlert; 
    public $name;
    public $description;
    public $slug;
    public $state;

    public function mount($slug)
    {
        $this->expensetype = ExpenseType::where('slug', $slug)->firstOrFail();
        if ($this->expensetype) {
            $this->name = $this->expensetype->name;
            $this->description = $this->expensetype->description;
            $this->state = $this->expensetype->state;
        }
    }
    public function render()
    {
        return view('livewire.expense-type.expense-type-update');
    }
    protected $rules = [
        'name' => 'required|max:20|min:2|unique:expense_types,name',
        'description' => 'nullable|max:225|min:2|',
        'state' => 'required',
    ];
    public function submit()
    {
        //Funcion para validar mediante las reglas
        $this->rules['name'] = 'required|unique:expense_types,name,' .$this->expensetype->id;
        $this->validate();
        
        //Creando registro
        $this->expensetype->update([
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
