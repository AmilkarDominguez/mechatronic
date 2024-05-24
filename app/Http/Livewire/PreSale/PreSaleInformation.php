<?php

namespace App\Http\Livewire\PreSale;

use App\Models\PreSale;
use App\Models\Customer;
use App\Models\Person;
use App\Models\PresaleDetail;
use Livewire\Component;

class PreSaleInformation extends Component
{
    //Presale
    public $total;
    //Person
    public $ci;
    public $expedition_ci;
    public $code_ci;
    public $name;
    public $address;
    //presaledetails
    public $presaledetails;
    public $slug;
    public $presale;


    public function mount($slug)
    {
        $this->presale = PreSale::where('slug', $slug)->firstOrFail();
        if ($this->presale) {
            $this->customer = Customer::where('id', $this->presale->customer_id)->firstOrFail();
            $this->person = Person::where('id', $this->customer->person_id)->firstOrFail();
            $this->presaledetails = PreSaleDetail::all()->where('pre_sale_id', $this->presale->id);
            $this->name = $this->person->name;
            $this->ci = $this->person->ci;
            $this->expedition_ci = $this->person->expedition_ci;
            $this->code_ci = $this->person->code_ci;
            $this->address = $this->person->address;
            $this->total = $this->presale->total;
        }
    }
    public function render()
    {
        return view('livewire.pre-sale.pre-sale-information');
    }
    protected $rules = [
        'total' => 'required',
        'state' => 'required',
    ];
    public function submit()
    {
        //Funcion para validar mediante las reglas
        $this->rules['total'];
        $this->validate();

        //Creando registro
        $this->presale->update([
            'total' => $this->total,
            'state' => $this->state,
        ]);
        //Llamando Alerta
        $this->alert('success', 'Registro actualizado correctamente', [
            'toast' => true,
            'position' => 'top-end',
        ]);
    }
}
