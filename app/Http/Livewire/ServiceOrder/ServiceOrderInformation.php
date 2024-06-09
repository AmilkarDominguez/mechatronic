<?php

namespace App\Http\Livewire\ServiceOrder;

use App\Models\ServiceOrder;
use App\Models\Customer;
use App\Models\Person;
use App\Models\ServiceOrderBatch;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ServiceOrderInformation extends Component
{
    use LivewireAlert;
    //ServiceOrder
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
        $this->service_order = ServiceOrder::where('slug', $slug)->firstOrFail();
        if ($this->service_order) {
            $this->customer = Customer::where('id', $this->service_order->customer_id)->firstOrFail();
            $this->person = Person::where('id', $this->customer->person_id)->firstOrFail();
            $this->saledetails = ServiceOrderBatch::all()->where('service_order_id', $this->service_order->id);
            $this->name = $this->person->name;
            $this->ci = $this->person->ci;
            $this->expedition_ci = $this->person->expedition_ci;
            $this->code_ci = $this->person->code_ci;
            $this->address = $this->person->address;
            $this->total = $this->service_order->total;
        }
    }
    public function render()
    {
        return view('livewire.service-order.service-order-information');
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
        $this->service_order->update([
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
