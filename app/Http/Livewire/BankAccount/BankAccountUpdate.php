<?php

namespace App\Http\Livewire\BankAccount;

use Livewire\Component;
use App\Models\BankAccount;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class BankAccountUpdate extends Component
{
    use LivewireAlert;
    public $name;
    public $description;
    public $number;
    public $balance;
    public $backup_balance;
    public $slug;
    public $state;
    public $bank_account;

    public function mount($slug)
    {
        $this->bank_account = BankAccount::where('slug', $slug)->firstOrFail();
        if ($this->bank_account) {
            $this->name = $this->bank_account->name;
            $this->description = $this->bank_account->description;
            $this->number = $this->bank_account->number;
            $this->balance = $this->bank_account->balance;
            $this->backup_balance = $this->bank_account->balance;
            $this->state = $this->bank_account->state;
        }
    }

    public function render()
    {
        return view('livewire.bank-account.bank-account-update');
    }

    protected $rules = [
        'name' => 'required|max:20|min:2|unique:bank_accounts,name',
        'description' => 'nullable|max:225|min:2',
        'number' => 'nullable|max:225|min:2',
        'state' => 'required',
    ];

    public function submit()
    {
        $this->rules['name'] = 'required|unique:bank_accounts,name,' . $this->bank_account->id;
        $this->validate();

        $this->bank_account->update([
            'name' => $this->name,
            'description' => $this->description,
            'number' => $this->number,
            'state' => $this->state,
        ]);

        $this->alert('success', 'Registro actualizado correctamente', [
            'toast' => true,
            'position' => 'top-end',
        ]);
    }
}
