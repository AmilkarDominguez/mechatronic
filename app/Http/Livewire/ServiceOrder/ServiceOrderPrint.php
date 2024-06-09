<?php

namespace App\Http\Livewire\ServiceOrder;

use App\Models\Customer;
use App\Models\Person;
use App\Models\ServiceOrder;
use App\Models\ServiceOrderBatch;
use App\Models\Setting;
use Livewire\Component;

class ServiceOrderPrint extends Component
{
    public $service_order;
    public $saledetails;
    public $customer;
    public $person;
    public $setting;
    public function mount($slug)
    {
        $this->setting = Setting::where('slug', 'configuration')->firstOrFail();
        $this->service_order = ServiceOrder::where('slug', $slug)->firstOrFail();
        if ($this->service_order) {
            $this->saledetails = ServiceOrderBatch::all()->where('service_order_id', $this->service_order->id);
            $this->customer = Customer::where('id', $this->service_order->customer_id)->firstOrFail();
            $this->person = Person::where('id', $this->customer->person_id)->firstOrFail();
        }
    }
    public function render()
    {
        return view('livewire.service-order.service-order-print')->layout('layouts.guest');
    }
}
