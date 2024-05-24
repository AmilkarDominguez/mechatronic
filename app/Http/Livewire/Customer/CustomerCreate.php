<?php

namespace App\Http\Livewire\Customer;

use App\Models\Customer;
use App\Models\Person;
use App\Models\CustomerType;
use App\Models\DocumentPerson;
use App\Models\Telephone;
use Livewire\Component;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class CustomerCreate extends Component
{
    use LivewireAlert;
    //person
    public $ci;
    public $expedition_ci;
    public $code_ci;
    public $name;
    public $address;
    //customer
    public $description;
    public $customer_type_id;
    public $customer_types;
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
        $this->customer_types = CustomerType::all()->where('state', 'ACTIVE');
    }
    public function render()
    {
        return view('livewire.customer.customer-create');
    }
    //reglas para validacion
    protected $rules = [
        //restriccion person
        'ci' => 'nullable',
        'expedition_ci' => 'nullable',
        'code_ci' => 'nullable',
        //'customer_type_id' => 'required',
        'name' => 'required|max:255|min:2',
        'address' => 'nullable',
        //restriccion customer
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
        //Creando registro customer
        $Customer = Customer::create([
            'person_id' => $Person->id,
            'description' => $this->description,
            //'customer_type_id' => $this->customer_type_id,
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
        $this->customer_type_id = "";
        $this->name = "";
        $this->address = "";

        $this->email = "";
        $this->nit = "";

        $this->telephone_whatsapp = "";
        $this->telephone_secondary = "";
        $this->landline = "";
    }

    public function onChangeSelectCustomerType()
    {
        $this->customer_types = CustomerType::all()->where('state', 'ACTIVE');
    }

    //Escuchadores para botones de alertas
    protected $listeners = [
        'confirmed',
    ];

    //Funcion que llama la alerta para redigir al dashboar
    public function confirmed()
    {
        return redirect()->route('customer.dashboard');
    }
}
