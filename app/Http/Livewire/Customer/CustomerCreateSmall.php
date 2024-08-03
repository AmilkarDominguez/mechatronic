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

class CustomerCreateSmall extends Component
{
    use LivewireAlert;
    //person
    public $ci;
    public $expedition_ci;
    public $code_ci;
    public $name;
    //customer
    public $customer;
    public $customer_type_id;
    public $customer_types;
    public $person_id;
    public $email;
    public $nit;
    public $birthday;
    
    public function mount()
    {
        $this->customer_types = CustomerType::all()->where('state', 'ACTIVE');
    }
    public function render()
    {
        return view('livewire.customer.customer-create-small')->layout('layouts.guest');
    }
    //reglas para validacion
    protected $rules = [
        //restriccion person
        'ci' => 'nullable',
        'expedition_ci' => 'nullable',
        'code_ci' => 'nullable',
        //'customer_type_id' => 'required',
        'name' => 'required|max:255|min:2',
        'birthday' => 'nullable',        
        //restriccion customer
        'email' => 'nullable',
        'nit' => 'nullable',
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
            'name' => $this->name
        ]);
        //Creando registro customer
        $this->customer = Customer::create([
            'person_id' => $Person->id,
            'email' => $this->email,
            'birthday' => $this->birthday,
            'slug' => Str::uuid(),
            'state' => 'ACTIVE',
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
        $this->birthday = "";
        $this->name = "";
        $this->email = "";
        $this->nit = "";
    }

    //Escuchadores para botones de alertas
    protected $listeners = [
        'confirmed',
    ];

    public function confirmed()
    {
        $this->cleanInputs();
        $this->emit('customerAdded', $this->customer->id);
    }
}
