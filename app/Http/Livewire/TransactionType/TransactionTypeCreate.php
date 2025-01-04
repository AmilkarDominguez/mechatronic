<?php

namespace App\Http\Livewire\TransactionType;

use Livewire\Component;
use App\Models\TransactionType;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;
class TransactionTypeCreate extends Component
{
    use LivewireAlert; 
    public $name;
    public $description;
    public $slug;
    public $state = "ACTIVE";
    public $type = "INGRESO";

    public function render()
    {
        return view('livewire.transaction-type.transaction-type-create');
    }

    protected $rules = [
        'name' => 'required|min:2|unique:transaction_types,name',
        'description' => 'nullable|max:225|min:2|',
        'type' => 'required',
        'state' => 'required',
    ];

    public function submit()
    {
        $this->validate();
        TransactionType::create([
            'name' => $this->name,
            'description' => $this->description,
            'slug' => Str::uuid(),
            'type' => $this->type,
            'state' => $this->state
        ]);
      
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
    }

    protected $listeners = [
        'confirmed',
    ];

    public function confirmed()
    {
        return redirect()->route('transaction-type.dashboard');
    }
}
