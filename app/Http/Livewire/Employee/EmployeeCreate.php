<?php

namespace App\Http\Livewire\Employee;

use App\Models\Employee;
use App\Models\Person;
use App\Models\DocumentPerson;
use App\Models\Telephone;
use Livewire\Component;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class EmployeeCreate extends Component
{
    use LivewireAlert;
    //person
    public $ci;
    public $expedition_ci;
    public $code_ci;
    public $name;
    public $address;
    //employee
    public $description;
    public $employee_type_id;
    public $person_id;
    public $email;
    public $nit;
    public $state = "ACTIVE";
    //telephone
    public $telephone_whatsapp;
    public $telephone_secondary;
    public $landline;
    public function mount()
    {

    }
    public function render()
    {
        return view('livewire.employee.employee-create');
    }
    //reglas para validacion
    protected $rules = [
        //restriccion person
        'ci' => 'nullable',
        'expedition_ci' => 'nullable',
        'code_ci' => 'nullable',
        'name' => 'required|max:255|min:2',
        'address' => 'nullable',
        //restriccion employee
        'description' => 'nullable',
        'email' => 'nullable',
        'nit' => 'nullable',
        'state' => 'required',
        //restriccion telefonos
        'telephone_whatsapp' => 'nullable|integer',
        'telephone_secondary' => 'nullable|integer',
        'landline' => 'nullable|integer',
    ];
    //Metodo que llama el formulario
    public function submit()
    {
        //Funcion para validar mediante las reglas
        $this->validate();
        //Creando registro person
        $Person = Person::create([
            'ci' => $this->ci,
            'expedition_ci' => $this->expedition_ci,
            'code_ci' => $this->code_ci,
            'name' => $this->name,
            'address' => $this->address,
        ]);
        //Creando registro employee
        $Employee = Employee::create([
            'person_id' => $Person->id,
            'description' => $this->description,
            'email' => $this->email,
            //encriptando slug
            'slug' => Str::uuid(),
            'state' => $this->state,
        ]);

        //Creando registro de telefonos
        Telephone::create([
            'person_id' => $Person->id,
            'number' => ($this->telephone_whatsapp) ? $this->telephone_whatsapp : '-',
            'type' => 'PRIMARY',
        ]);
        Telephone::create([
            'person_id' => $Person->id,
            'number' => ($this->telephone_secondary) ? $this->telephone_secondary : '-',
            'type' => 'SECONDARY',
        ]);
        Telephone::create([
            'person_id' => $Person->id,
            'number' => ($this->landline) ? $this->landline : '-',
            'type' => 'TERTIARY',
        ]);

        $this->cleanInputs();

        $this->confirm('Registro creado correctamente', [
            'icon' => 'success',
            'toast' => false,
            'position' => 'center',
            'showConfirmButton' => true,
            'showCancelButton' => false,
            'cancelButtonText' => 'Cancelar',
            'confirmButtonText' => 'Aceptar',
            'onConfirmed' => 'confirmed',
        ]);
    }

    //Funcion para limpiar imputs
    public function cleanInputs()
    {
        $this->ci = "";
        $this->expedition_ci = "";
        $this->code_ci = "";
        $this->name = "";
        $this->address = "";
        $this->email = "";
        $this->nit = "";
        $this->telephone_whatsapp = "";
        $this->telephone_secondary = "";
        $this->landline = "";
    }

    //Escuchadores para botones de alertas
    protected $listeners = [
        'confirmed',
    ];

    //Funcion que llama la alerta para redigir al dashboar
    public function confirmed()
    {
        return redirect()->route('employee.dashboard');
    }
}
