<?php

namespace App\Http\Livewire\Sale;

use App\Models\Sale;
use App\Models\Customer;
use App\Models\Person;
use App\Models\SaleDetail;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class SaleInformation extends Component
{
    use LivewireAlert;
    //Sale
    public $total;
    //Person
    public $ci;
    public $expedition_ci;
    public $code_ci;
    public $name;
    public $address;
    //saledetails
    public $saledetails;
    public $slug;


    public function mount($slug)
    {
        $this->sale = Sale::where('slug', $slug)->firstOrFail();
        if ($this->sale) {
            $this->customer = Customer::where('id', $this->sale->customer_id)->firstOrFail();
            $this->person = Person::where('id', $this->customer->person_id)->firstOrFail();
            $this->saledetails = SaleDetail::all()->where('sale_id', $this->sale->id);
            $this->name = $this->person->name;
            $this->ci = $this->person->ci;
            $this->expedition_ci = $this->person->expedition_ci;
            $this->code_ci = $this->person->code_ci;
            $this->address = $this->person->address;
            $this->total = $this->sale->total;
        }
    }
    public function render()
    {
        return view('livewire.sale.sale-information');
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
        $this->sale->update([
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
