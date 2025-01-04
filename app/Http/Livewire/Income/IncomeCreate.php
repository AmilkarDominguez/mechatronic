<?php

namespace App\Http\Livewire\Income;

use App\Models\BankAccount;
use App\Models\TransactionType;
use App\Services\BankAccountHistoryService;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Str;

class IncomeCreate extends Component
{
    use LivewireAlert;
    public $bank_account_id;
    public $transaction_type_id;
    public $amount;

    public $transaction_types;
    public $bank_accounts;

    public function mount()
    {
        $this->transaction_types = TransactionType::all()
        ->where('state', 'ACTIVE')
        ->where('type', 'INGRESO')
        ->where('id','!=',1);

        $this->bank_accounts = BankAccount::all()->where('state', 'ACTIVE');

        if ($this->bank_accounts->isNotEmpty()) {
            $this->bank_account_id = $this->bank_accounts->first()->id;
        }

        if ($this->transaction_types->isNotEmpty()) {
            $this->transaction_type_id = $this->transaction_types->first()->id;
        }
    }
    public function render()
    {
        return view('livewire.income.income-create');
    }

    protected $rules = [
        'bank_account_id' => 'required',
        'transaction_type_id' => 'required',
        'amount' => 'required|numeric'
    ];

    public function submit()
    {

        $this->validate();

        $bankAccountHistoryService = app(BankAccountHistoryService::class);

        $bankAccountHistoryService->registerIncome(
            Str::uuid(),
            $this->bank_account_id,
            $this->transaction_type_id,
            $this->amount
        );

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
    }
    public function cleanInputs()
    {
        $this->transaction_type_id = 1;
        $this->bank_account_id = 1;
        $this->amount = "";
    }

    protected $listeners = [
        'confirmed',
    ];

    public function confirmed()
    {
        return redirect()->route('income.dashboard');
    }
}
