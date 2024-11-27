<?php

namespace App\Http\Livewire\Batch;

use App\Models\Expense;
use Livewire\Component;
use App\Models\Batch;
use App\Models\Warehouse;
use App\Models\Product;
use App\Models\Industry;
use App\Models\Supplier;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class BatchUpdate extends Component
{
    use LivewireAlert;
    //batch
    public $batch;
    public $expense;
    public $warehouse_id;
    public $product_id;
    public $wholesale_price;
    public $retail_price;
    public $final_price;
    public $stock;
    public $description;
    public $brand;
    public $model;
    public $expiration_date;
    public $slug;
    public $state;
    public $warehouses;
    public $products;
    public $supplier_id;
    public $suppliers;
    public $industry_id;
    public $industries;
    public $purchase_price;

    public function mount($slug)
    {
        $this->batch = Batch::where('slug', $slug)->firstOrFail();
        $this->expense = Expense::where('slug', $slug)->firstOrFail();

        if ($this->batch) {
            //cargando datos de la batch
            $this->warehouse_id = $this->batch->warehouse_id;
            $this->product_id = $this->batch->product_id;
            $this->supplier_id = $this->batch->supplier_id;
            $this->industry_id = $this->batch->industry_id;
            $this->wholesale_price = $this->batch->wholesale_price;
            $this->retail_price = $this->batch->retail_price;
            $this->final_price = $this->batch->final_price;
            $this->stock = $this->batch->stock;
            $this->description = $this->batch->description;
            $this->brand = $this->batch->brand;
            $this->model = $this->batch->model;
            $this->expiration_date = $this->batch->expiration_date;
            $this->state = $this->batch->state;
        }
        if ($this->expense) {
            $this->purchase_price = $this->expense->purchase;
        }
        $this->warehouses = Warehouse::all()->where('state', 'ACTIVE');
        $this->products = Product::all()->where('state', 'ACTIVE');
        $this->suppliers = Supplier::all()->where('state', 'ACTIVE');
        $this->industries = Industry::all()->where('state', 'ACTIVE');
    }
    public function render()
    {
        return view('livewire.batch.batch-update');
    }
    protected $rules = [
        //restriccion batch
        'product_id' => 'required',
        'warehouse_id' => 'required',
        'supplier_id' => 'required',
        'industry_id' => 'required',
        'wholesale_price' => 'required',
        'retail_price' => 'nullable',
        'final_price' => 'nullable',
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

        //Actualizando registro
        $this->batch->update([
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
            'state' => $this->state,
        ]);

        $this->expense->update([
            'purchase' => $this->purchase_price,
        ]);

        //Llamando Alerta
        $this->alert('success', 'Registro actualizado correctamente', [
            'toast' => true,
            'position' => 'top-end',
        ]);
    }
}
