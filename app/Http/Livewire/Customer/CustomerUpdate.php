<?php

namespace App\Http\Livewire\Customer;

use App\Models\Person;
use App\Models\CustomerType;
use App\Models\Customer;
use App\Models\Telephone;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;


class CustomerUpdate extends Component
{
    use LivewireAlert;
    //person
    public $person;
    public $ci;
    public $expedition_ci;
    public $code_ci;
    public $name;
    public $address;
    //customer
    public $description;
    public $customer;
    public $person_id;
    public $email;
    public $nit;
    public $slug;
    public $state;
    public $birthday;
    //telephones

    public $phone_primary;
    public $phone_secondary;
    public $phone_tertiary;

    public $telephone_whatsapp;
    public $telephone_secondary;
    public $landline;

    public function mount($slug)
    {
        $this->customer = Customer::where('slug', $slug)->firstOrFail();
        $this->person = Person::where('id', $this->customer->person_id)->firstOrFail();
        if ($this->customer) {
            //cargando datos del cliente
            $this->person_id = $this->customer->person_id;
            $this->email = $this->customer->email;
            $this->nit = $this->customer->nit;
            $this->state = $this->customer->state;
            $this->birthday = $this->customer->birthday;

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
        return view('livewire.customer.customer-update');
    }
    protected $rules = [
        //restriccion person
        'ci' => 'nullable',
        'expedition_ci' => 'required',
        'code_ci' => 'nullable',
        'name' => 'required|max:255|min:2',
        'address' => 'nullable',
        //restriccion customer
        'description' => 'nullable',
        'email' => 'nullable',
        'nit' => 'nullable',
        'state' => 'required',
        'birthday' => 'required',
        //restriccion telefonos
        'telephone_whatsapp' => 'nullable',
        'telephone_secondary' => 'nullable',
        'landline' => 'nullable',

    ];
    public function submit()
    {
        //Funcion para validar mediante las reglas
        $this->rules['slug'] = 'required|unique:customers,slug,' . $this->customer->id;
        $this->validate();

        //Actualizando registro
        $this->customer->update([
            'description' => $this->description,
            'email' => $this->email,
            'nit' => $this->nit,
            'state' => $this->state,
            'birthday' => $this->birthday,
        ]);
        $this->person->update([
            'ci' => $this->ci,
            'expedition_ci' => $this->expedition_ci,
            'code_ci' => $this->code_ci,
            'name' => $this->name,
            'name' => $this->name,
            'address' => $this->address,
        ]);

        // Actualizar los teléfonos
        $this->updateTelephones();

        //Llamando Alerta
        $this->alert('success', 'Registro actualizado correctamente', [
            'toast' => true,
            'position' => 'top-end',
        ]);
    }

    /**
     * Método para actualizar o crear teléfonos.
     */
    private function updateTelephones()
    {
        // Actualizar o crear el teléfono primario
        if ($this->phone_primary) {
            $this->phone_primary->update([
                'number' => $this->telephone_whatsapp ?: '-',
            ]);
        } else {
            Telephone::create([
                'person_id' => $this->person->id,
                'type' => 'PRIMARY',
                'number' => $this->telephone_whatsapp ?: '-',
            ]);
        }

        // Actualizar o crear el teléfono secundario
        if ($this->phone_secondary) {
            $this->phone_secondary->update([
                'number' => $this->telephone_secondary ?: '-',
            ]);
        } else {
            Telephone::create([
                'person_id' => $this->person->id,
                'type' => 'SECONDARY',
                'number' => $this->telephone_secondary ?: '-',
            ]);
        }

        // Actualizar o crear el teléfono terciario
        if ($this->phone_tertiary) {
            $this->phone_tertiary->update([
                'number' => $this->landline ?: '-',
            ]);
        } else {
            Telephone::create([
                'person_id' => $this->person->id,
                'type' => 'TERTIARY',
                'number' => $this->landline ?: '-',
            ]);
        }
    }
}
