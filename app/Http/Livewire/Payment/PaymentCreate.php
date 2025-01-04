<?php

namespace App\Http\Livewire\Payment;

use App\Models\BankAccount;
use Livewire\Component;
use App\Models\Payment;
use App\Models\ServiceOrder;
use App\Services\BankAccountHistoryService;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class PaymentCreate extends Component
{
    use LivewireAlert;
    public $amount;
    public $slug;
    public $state = "ACTIVE";
    public $bank_accounts;
    public $bank_account_id;

    public $service_order;
    public function mount($slug)
    {
        $this->service_order = ServiceOrder::where('slug', $slug)->firstOrFail();
        $this->bank_accounts = BankAccount::all()->where('state', 'ACTIVE');
        if ($this->bank_accounts->isNotEmpty()) {
            $this->bank_account_id = $this->bank_accounts->first()->id;
        }
    }
    public function render()
    {
        return view('livewire.payment.payment-create');
    }

    protected $rules = [
        'amount' => 'required|numeric|min:1',
        'state' => 'required',
    ];
    public function submit()
    {
        if ($this->checkMust($this->amount)) {

            $this->validate();
            $slug = Str::uuid();
            Payment::create([
                'amount' => $this->amount,
                'slug' => $slug,
                'service_order_id' =>  $this->service_order->id,
                'state' => $this->state,
            ]);

            $this->service_order->update([
                'have' => $this->service_order->have + $this->amount,
                'must' => $this->service_order->must - $this->amount,
            ]);

            $this->registerIncome($this->amount, $slug, 'service_order_id|'.$this->service_order->id);

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
        } else {
            $this->alert('error', 'El pago <span class=" text-red-500 font-bold text-xl">' . $this->amount . '</span> es superior al a la deuda.', [
                'position' =>  'top-end',
                'timer' =>  3000,
                'toast' =>  true,
                'text' =>  '',
                'confirmButtonText' =>  'Ok',
            ]);
        }
    }

    public function checkMust($amount)
    {
        return $amount <= $this->service_order->must;
    }

    public function cleanInputs()
    {
        $this->amount = "";
    }

    protected $listeners = [
        'confirmed',
    ];

    public function confirmed()
    {
        return redirect()->route('service-order.dashboard');
    }

    public function registerIncome($amount, $slug, $transaction_reference)
    {
        $bankAccountHistoryService = app(BankAccountHistoryService::class);
        $bankAccountHistoryService->registerIncome(
            $slug,
            $this->bank_account_id,
            5,
            $amount,
            $transaction_reference
        );
    }
}
