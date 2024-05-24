<?php

namespace App\Http\Livewire\Employee;

use App\Models\Person;
use App\Models\EmployeeType;
use App\Models\Employee;
use App\Models\Telephone;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;


class EmployeeUpdate extends Component
{
    use LivewireAlert;
    //person
    public $person;
    public $ci;
    public $expedition_ci;
    public $code_ci;
    public $name;
    public $address;
    //employee
    public $description;
    public $employee;
    public $person_id;
    public $email;
    public $nit;
    public $slug;
    public $state;
    //telephones

    public $phone_primary;
    public $phone_secondary;
    public $phone_tertiary;

    public $telephone_whatsapp;
    public $telephone_secondary;
    public $landline;

    public function mount($slug)
    {
        $this->employee = Employee::where('slug', $slug)->firstOrFail();
        $this->person = Person::where('id', $this->employee->person_id)->firstOrFail();
        if ($this->employee) {
            //cargando datos del cliente
            $this->person_id = $this->employee->person_id;
            $this->email = $this->employee->email;
            $this->nit = $this->employee->nit;
            $this->state = $this->employee->state;

            //Verificando telefonos

            $this->phone_primary = Telephone::where('person_id', $this->person->id)->where('type', 'PRIMARY')->first();
            $this->phone_secondary = Telephone::where('person_id', $this->person->id)->where('type', 'SECONDARY')->first();
            $this->phone_tertiary = Telephone::where('person_id', $this->person->id)->where('type', 'TERTIARY')->first();

            if ($this->phone_primary) {
                $this->telephone_whatsapp = $this->phone_primary->number;
            }
            if ($this->phone_secondary) {
                $this->telephone_secondary = $this->phone_secondary->number;
            }
            if ($this->phone_tertiary) {
                $this->landline = $this->phone_tertiary->number;
            }
        }
        if ($this->person) {
            $this->ci = $this->person->ci;
            $this->expedition_ci = $this->person->expedition_ci;
            $this->code_ci = $this->person->code_ci;
            $this->name = $this->person->name;
            $this->address = $this->person->address;
        }
    }
    public function render()
    {
        return view('livewire.employee.employee-update');
    }
    protected $rules = [
        //restriccion person
        'ci' => 'nullable',
        'expedition_ci' => 'required',
        'code_ci' => 'nullable',
        'name' => 'required|max:255|min:2',
        'address' => 'nullable',
        //restriccion employee
        'description' => 'nullable',
        'email' => 'nullable',
        'nit' => 'nullable',
        'state' => 'required',
        //restriccion telefonos
        'telephone_whatsapp' => 'nullable',
        'telephone_secondary' => 'nullable',
        'landline' => 'nullable',

    ];
    public function submit()
    {
        //Funcion para validar mediante las reglas
        $this->rules['slug'] = 'required|unique:employees,slug,' . $this->employee->id;
        $this->validate();

        //Actualizando registro
        $this->employee->update([
            'description' => $this->description,
            'email' => $this->email,
            'nit' => $this->nit,
            'state' => $this->state,
        ]);
        $this->person->update([
            'ci' => $this->ci,
            'expedition_ci' => $this->expedition_ci,
            'code_ci' => $this->code_ci,
            'name' => $this->name,
            'name' => $this->name,
            'address' => $this->address,
        ]);

        //Editando telefonos
        $this->phone_primary->update([
            'number' => ($this->telephone_whatsapp) ? $this->telephone_whatsapp : '-',
        ]);
        $this->phone_secondary->update([
            'number' => ($this->telephone_secondary) ? $this->telephone_secondary : '-',
        ]);
        $this->phone_tertiary->update([
            'number' => ($this->landline) ? $this->landline : '-',
        ]);

        //Llamando Alerta
        $this->alert('success', 'Registro actualizado correctamente', [
            'toast' => true,
            'position' => 'top-end',
        ]);
    }
}
