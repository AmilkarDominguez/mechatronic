<?php

namespace App\Http\Livewire\PreSale;

use App\Models\Customer;
use App\Models\Person;
use App\Models\PreSale;
use App\Models\PreSaleDetail;
use App\Models\Setting;
use Livewire\Component;

class PreSalePrint extends Component
{
    public $sale;
    public $saledetails;
    public $customer;
    public $person;
    public $setting;
    public function mount($slug)
    {
        $this->setting = Setting::where('slug', 'configuration')->firstOrFail();
        $this->sale = PreSale::where('slug', $slug)->firstOrFail();
        if ($this->sale) {
            $this->saledetails = PreSaleDetail::all()->where('pre_sale_id', $this->sale->id);
            $this->customer = Customer::where('id', $this->sale->customer_id)->firstOrFail();
            $this->person = Person::where('id', $this->customer->person_id)->firstOrFail();
        }
    }
    public function render()
    {
        return view('livewire.pre-sale.pre-sale-print')->layout('layouts.guest');
    }
}
