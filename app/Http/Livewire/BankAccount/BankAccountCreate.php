<?php

namespace App\Http\Livewire\BankAccount;

use Livewire\Component;
use App\Models\BankAccount;
use App\Services\BankAccountHistoryService;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class BankAccountCreate extends Component
{
    use LivewireAlert;
    public $name;
    public $description;
    public $slug;
    public $number;
    public $balance;
    public $state = "ACTIVE";
    public $bank_account;

    public function render()
    {
        return view('livewire.bank-account.bank-account-create');
    }

    protected $rules = [
        'name' => 'required|max:20|min:2|unique:bank_accounts,name',
        'description' => 'nullable|max:225|min:2',
        'number' => 'nullable|max:225|min:2',
        'balance' => 'nullable|max:225|min:2',
        'state' => 'required',
    ];

    public function submit()
    {
        $this->validate();
        $this->bank_account = BankAccount::create([
            'name' => $this->name,
            'description' => $this->description,
            'number' => $this->number,
            'balance' => $this->balance,
            'slug' => Str::uuid(),
            'state' => $this->state,
        ]);

        $this->registerAccountHistory();
        
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
        $this->name = "";
        $this->description = "";
        $this->number = "";
        $this->balance = "";
    }

    protected $listeners = [
        'confirmed',
    ];

    public function confirmed()
    {
        return redirect()->route('bank-account.dashboard');
    }

    private function registerAccountHistory(): void
    {
        $bankAccountHistoryService = app(BankAccountHistoryService::class);
        $bankAccountHistoryService->registerHistory($this->bank_account->id, 0, $this->bank_account->balance);
    }
}
