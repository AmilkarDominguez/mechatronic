<?php

namespace App\Http\Livewire\Payment;

use App\Models\Sale;
use Livewire\Component;

class PaymentDashboard extends Component
{
    public $slug;
    public $sale;

    public function mount($slug)
    {
        $this->sale = Sale::where('slug', $slug)->firstOrFail();
        //dd($this->sale);
    }
    public function render()
    {
        return view('livewire.payment.payment-dashboard', ['sale' => $this->sale]);
    }
}
