<?php

namespace App\Http\Livewire\Department;

use App\Models\Department;
use App\Models\Country;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class DepartmentUpdate extends Component
{
    use LivewireAlert;
    public $name;
    public $state;
    public $slug;

    public $country_id;

    public function render()
    {
        return view('livewire.department.department-update');
    }

    public function mount($slug)
    {
        $this->department = Department::where('slug', $slug)->firstOrFail();
        //$this->countri = Country::where('id', $this->department->country_id)->firstOrFail();
        $this->countries = Country::all();

        if ($this->department) {
           $this->country_id = $this->department->country_id;
            $this->name = $this->department->name;
            $this->state = $this->department->state;
        }
    }

    
  
    protected $rules = [
        'name' => 'required|max:100|min:2|unique:departments,name',
        'state' => 'required',
    ];
    public function submit()
    {
        //Funcion para validar mediante las reglas
        $this->rules['name'] = 'required|unique:departments,name,' . $this->department->id;
        $this->validate();

        //Actualizar registro
        $this->department->update([
            'name' => $this->name,
            'country_id' => $this->country_id,
            'state' => $this->state,
        ]);
        //Llamando Alerta
        $this->alert('success', 'Registro actualizado correctamente', [
            'toast' => true,
            'position' => 'top-end',
        ]);
    }
    public function onChangeSelectCountrie()
    {
        $this->countries = Country::all();
    }
}
