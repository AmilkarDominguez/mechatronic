<?php

namespace App\Http\Livewire\Country;

use App\Models\Country;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;


class CountryUpdate extends Component
{
    use LivewireAlert; 
    public function render()
    {
        return view('livewire.country.country-update');
    }

    public function mount($slug)
    {
        $this->country = Country::where('slug', $slug)->firstOrFail();
        if ($this->country) {
            $this->name = $this->country->name;
           // $this->description = $this->gender->description;
            $this->state = $this->country->state;
        }
    }
  
    protected $rules = [
        'name' => 'required|max:100|min:2|unique:countries,name',
        //'description' => 'nullable|max:100|min:2',
        'state' => 'required',
    ];
    public function submit()
    {
        //Funcion para validar mediante las reglas
        $this->rules['name'] = 'required|unique:countries,name,' . $this->country->id;
        $this->validate();

        //Actualizar registro
        $this->country->update([
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
