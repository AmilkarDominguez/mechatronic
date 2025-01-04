<?php

namespace App\Http\Livewire\TransactionType;

use Livewire\Component;
use App\Models\TransactionType;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class TransactionTypeUpdate extends Component
{
    use LivewireAlert; 
    public $transactionType;
    public $name;
    public $description;
    public $slug;
    public $state;
    public $type;

    public function mount($slug)
    {
        $this->transactionType = TransactionType::where('slug', $slug)->firstOrFail();
        if ($this->transactionType) {
            $this->name = $this->transactionType->name;
            $this->description = $this->transactionType->description;
            $this->type = $this->transactionType->type;
            $this->state = $this->transactionType->state;
        }
    }
    public function render()
    {
        return view('livewire.transaction-type.transaction-type-update');
    }
    protected $rules = [
        'name' => 'required|max:20|min:2|unique:transaction_types,name',
        'description' => 'nullable|max:225|min:2|',
        'type' => 'required',
        'state' => 'required',
    ];
    public function submit()
    {
        $this->rules['name'] = 'required|unique:transaction_types,name,' .$this->transactionType->id;
        $this->validate();
        
        $this->transactionType->update([
            'name' => $this->name,
            'description' => $this->description,
            'type' => $this->type,
            'state' => $this->state
        ]);
        $this->alert('success', 'Registro actualizado correctamente', [
            'toast' => true,
            'position' => 'top-end',
        ]);
    }
}
