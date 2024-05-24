<?php

namespace App\Http\Livewire\Expense;

use Livewire\Component;
use App\Models\ExpenseType;
use App\Models\Expense;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ExpenseUpdate extends Component
{
    use LivewireAlert;
    public $expense_type_id;
    public $purchase;
    public $description;
    public $slug;
    public $state;

    public $expense_types;

    public function mount($slug)
    {
        $this->expense = Expense::where('slug', $slug)->firstOrFail();
        if ($this->expense) {
            $this->expense_type_id = $this->expense->expense_type_id;
            $this->purchase = $this->expense->purchase;
            $this->description = $this->expense->description;
            $this->state = $this->expense->state;
        }
        $this->expense_types = ExpenseType::all()->where('state', 'ACTIVE');
    }
    public function render()
    {
        return view('livewire.expense.expense-update');
    }
    protected $rules = [
        'purchase' => 'required',
        'description' => 'nullable|max:225|min:2|',
        'state' => 'required',
    ];
    public function submit()
    {
        //Funcion para validar mediante las reglas

        $this->validate();

        //Creando registro
        $this->expense->update([
            'expense_type_id' => $this->expense_type_id,
            'purchase' => $this->purchase,
            'description' => $this->description,
            'state' => $this->state,
        ]);
        //Llamando Alerta
        $this->alert('success', 'Registro actualizado correctamente', [
            'toast' => true,
            'position' => 'top-end',
        ]);
    }
    public function onChangeSelectExpenseType()
    {
        $this->expense_types = ExpenseType::all()->where('state', 'ACTIVE');
    }
}
