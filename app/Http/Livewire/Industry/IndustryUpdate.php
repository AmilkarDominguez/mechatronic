<?php

namespace App\Http\Livewire\Industry;

use App\Models\Industry;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class IndustryUpdate extends Component
{
    use LivewireAlert;
    public $industry;
    public $slug;
    public $name;
    public $description;
    public $state;


    public function mount($slug)
    {
        $this->industry = Industry::where('slug', $slug)->firstOrFail();
        if ($this->industry) {
            $this->name = $this->industry->name;
            $this->description = $this->industry->description;
            $this->state = $this->industry->state;
        }
    }
    public function render()
    {
        return view('livewire.industry.industry-update');
    }
    protected $rules = [
        'name' => 'required|max:255|min:2|unique:industries,name',
        'description' => 'nullable',
        'state' => 'required',
    ];
    public function submit()
    {
        //Funcion para validar mediante las reglas
        $this->rules['name'] = 'required|unique:industries,name,' .$this->industry->id;
        $this->validate();
        
        //Creando registro
        $this->industry->update([
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
