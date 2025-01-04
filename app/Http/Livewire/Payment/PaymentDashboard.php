<?php

namespace App\Http\Livewire\Payment;

use App\Models\ServiceOrder;
use Livewire\Component;

class PaymentDashboard extends Component
{
    public $slug;
    public $service_order;

    public function mount($slug)
    {
        $this->service_order = ServiceOrder::where('slug', $slug)->firstOrFail();
    }
    public function render()
    {
        return view('livewire.payment.payment-dashboard', ['service_order' => $this->service_order]);
    }
}
