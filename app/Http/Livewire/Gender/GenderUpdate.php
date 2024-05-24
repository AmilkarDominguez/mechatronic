<?php

namespace App\Http\Livewire\Gender;

use App\Models\Gender;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;


class GenderUpdate extends Component
{
    use LivewireAlert; 
    public function render()
    {
        return view('livewire.gender.gender-update');
    }

    public function mount($slug)
    {
        $this->gender = Gender::where('slug', $slug)->firstOrFail();
        if ($this->gender) {
            $this->name = $this->gender->name;
           // $this->description = $this->gender->description;
            $this->state = $this->gender->state;
        }
    }
  
    protected $rules = [
        'name' => 'required|max:100|min:2|unique:genders,name',
        //'description' => 'nullable|max:100|min:2',
        'state' => 'required',
    ];
    public function submit()
    {
        //Funcion para validar mediante las reglas
        $this->rules['name'] = 'required|unique:genders,name,' . $this->gender->id;
        $this->validate();

        //Actualizar registro
        $this->gender->update([
            'name' => $this->name,
           // 'description' => $this->description,
            'state' => $this->state,
        ]);
        //Llamando Alerta
        $this->alert('success', 'Registro actualizado correctamente', [
            'toast' => true,
            'position' => 'top-end',
        ]);
    }
}
