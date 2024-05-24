<?php

namespace App\Http\Livewire\Expense;


use App\Models\ExpenseType;
use App\Models\Expense;
use Illuminate\Support\Str;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ExpenseCreate extends Component
{
    use LivewireAlert;
    public $expense_type_id;
    public $purchase;
    public $description;
    public $slug;
    public $state = "ACTIVE";

    public $expense_types;

    public function mount()
    {
        $this->expense_types = ExpenseType::all()->where('state', 'ACTIVE');
    }
    public function render()
    {
        return view('livewire.expense.expense-create');
    }
    protected $rules = [
        'purchase' => 'required',
        'description' => 'nullable|max:225|min:2|',
        'state' => 'required',
    ];
    public function submit()
    {
        //dd($this->name,$this->description);
        //Funcion para validar mediante las reglas

        $this->validate();
        //Creando registro
        Expense::create([
            'expense_type_id' => $this->expense_type_id,
            'purchase' => $this->purchase,
            'description' => $this->description,
            'slug' => Str::uuid(),
            'state' => $this->state,
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
        $this->expense_type_id = "";
        $this->purchase = "";
        $this->description = "";
    }

    //Escuchadores para botones de alertas
    protected $listeners = [
        'confirmed',
    ];

    //Funcion que llama la alerta para redigir al dashboar
    public function confirmed()
    {
        return redirect()->route('expense.dashboard');
    }
    public function onChangeSelectExpenseType()
    {
        $this->expense_types = ExpenseType::all()->where('state', 'ACTIVE');
    }
}
