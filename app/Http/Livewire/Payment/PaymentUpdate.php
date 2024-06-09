<?php

namespace App\Http\Livewire\Payment;

use App\Models\Payment;
use App\Models\ServiceOrder;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class PaymentUpdate extends Component
{
    use LivewireAlert;
    public $amount;
    public $slug;

    public $service_order;
    public function mount($slug)
    {
        $this->payment = Payment::where('slug', $slug)->firstOrFail();
        if ($this->payment) {
            $this->amount = $this->payment->amount;
            $this->service_order = ServiceOrder::where('id', $this->payment->service_order_id)->firstOrFail();
        }
    }
    public function render()
    {
        return view('livewire.payment.payment-update');
    }
    public function submit()
    {
        if ('amount'> $this->payment->amount) {
            dd('1');
        }
        else {
            dd('2');
        }
        /*$this->payment->update([
            'amount' => $this->amount

        ]);*/
        //Llamando Alerta
        $this->alert('success', 'Registro actualizado correctamente', [
            'toast' => true,
            'position' => 'top-end',
        ]);
    }
}
