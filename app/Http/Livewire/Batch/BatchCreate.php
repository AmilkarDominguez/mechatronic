<?php

namespace App\Http\Livewire\Batch;

use App\Models\Batch;
use App\Models\Expense;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Industry;
use App\Models\Warehouse;
use Livewire\Component;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;
class BatchCreate extends Component
{
    use LivewireAlert;
    public $batch;
    public $product_id;
    public $warehouse_id;
    public $wholesale_price;
    public $retail_price;
    public $final_price;
    public $stock;
    public $description;
    public $brand;
    public $model;
    public $expiration_date;
    public $slug;
    public $state = 'ACTIVE';
    public $warehouses;
    public $products;
    public $supplier_id;
    public $suppliers;
    public $industry_id;
    public $industries;
    public $purchase_price;

    public function mount()
    {
        $this->products = Product::where('state', 'ACTIVE')->orderBy('name', 'ASC')->get();
        $this->warehouses = Warehouse::where('state', 'ACTIVE')->orderBy('name', 'ASC')->get();
        $this->suppliers = Supplier::where('state', 'ACTIVE')->orderBy('name', 'ASC')->get();
        $this->industries = Industry::where('state', 'ACTIVE')->orderBy('name', 'ASC')->get();
    }
    public function render()
    {
        return view('livewire.batch.batch-create');
    }
    protected $rules = [
        'product_id' => 'required',
        'warehouse_id' => 'required',
        'supplier_id' => 'required',
        'industry_id' => 'required',
        'wholesale_price' => 'required',
        'retail_price' => 'nullable',
        'final_price' => 'nullable',
        'suppliers' => 'required',
        'stock' => 'required',
        'description' => 'nullable',
        'brand' => 'nullable',
        'model' => 'nullable',
        'expiration_date' => 'nullable',
        'state' => 'required',
    ];
    public function submit()
    {
        $this->validate();
        $slug = Str::uuid();
        $this->batch = Batch::create([
            'product_id' => $this->product_id,
            'warehouse_id' => $this->warehouse_id,
            'supplier_id' => $this->supplier_id,
            'industry_id' => $this->industry_id,
            'wholesale_price' => $this->wholesale_price,
            'retail_price' => $this->retail_price,
            'final_price' => $this->final_price,
            'stock' => $this->stock,
            'description' => $this->description,
            'brand' => $this->brand,
            'model' => $this->model,
            'expiration_date' => $this->expiration_date,
            'slug' => $slug,
            'state' => $this->state,
        ]);
        $this->registerExpense($this->batch->product->name, $this->purchase_price, $slug);

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

    //Funcion para limpiar imputs
    public function cleanInputs()
    {
        $this->purchase_price = "";
        $this->product_id = "";
        $this->warehouse_id = "";
        $this->supplier_id = "";
        $this->industry_id = "";
        $this->wholesale_price = "";
        $this->retail_price = "";
        $this->final_price = "";
        $this->stock = "";
        $this->description = "";
        $this->brand = "";
        $this->model = "";
        $this->expiration_date = "";
        $this->state = "";
    }
    //Escuchadores para botones de alertas
    protected $listeners = [
        'confirmed',
        'selectedCustomer' => 'selectedCustomer'
    ];

    //Funcion que llama la alerta para redigir al dashboar
    public function confirmed()
    {
        return redirect()->route('batch.dashboard');
    }

    public function registerExpense($name, $purchase, $slug)
    {
        Expense::create([
            'expense_type_id' => 1,
            'purchase' => $purchase,
            'description' => 'Compra de lote de producto ' . $name,
            'slug' => $slug,
            'state' => 'ACTIVE',
        ]);
    }
}
