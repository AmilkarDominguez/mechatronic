<?php

namespace App\Http\Livewire\Sale;

use App\Models\Batch;
use App\Models\Cart;
use App\Models\Customer;
use App\Models\Warehouse;
use Livewire\Component;
use App\Models\Sale;
use App\Models\Bonus;
use App\Models\Employee;
use App\Models\LabourDetail;
use App\Models\Promoter;
use App\Models\SaleDetail;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class SaleCreate extends Component
{
    use LivewireAlert;

    public $total;
    public $slug;


    public $customers;
    public $customer_id;
    public $customer;



    public $payment_type = 'CONTADO';
    public $price_type = 'FINAL';
    public $description;


    public $services;
    public $service_id;
    public $selected_service;
    public $employees;
    public $employee_id;
    public $selected_employee;
    public $additional_percent_employe = 0;
    public $additional_service_price = 1;
    public $additional_service_quantity = 1;
    public $labours = [];

    public $warehouses;
    public $warehouse_id;
    public $batchs;
    public $batch_id;
    public $selected_batch;
    public $sale_details = [];

    public function mount()
    {
        $this->customers = Customer::all()->where('state', 'ACTIVE');
        $this->warehouses = Warehouse::all()->where('state', 'ACTIVE');
        $this->employees = Employee::all()->where('state', 'ACTIVE');
        $this->services = Service::all()->where('state', 'ACTIVE');

        //Seleccionando primer almacen
        if ($this->warehouses[0]) {
            $this->warehouse_id = $this->warehouses[0]->id;
            $this->batchs = Batch::where('state', 'ACTIVE')->where('warehouse_id', $this->warehouse_id)->where('stock', '>', '0')->with('product')->get();
        }
    }

    public function render()
    {
        return view('livewire.sale.sale-create');
    }

    //reglas para validacion
    protected $rules = [
        'customer_id' => 'required',
        'warehouse_id' => 'required',
        'employee_id' => 'required',
        'service_id' => 'required',
    ];

    //Metodo que llama el formulario
    public function submit()
    {
        //Funcion para validar mediante las reglas
        $this->validate();
        if ($this->checkStock()) {

            $sale = Sale::create([
                'description' => $this->description,
                'total' => $this->cart->total + $this->service_price,
                'must' => $this->cart->total,
                'slug' => Str::uuid(),
                'customer_id' => $this->customer_id,
                'user_id' => Auth::user()->id,
                'state' => 'ACTIVE',
                'payment_type' => $this->payment_type,
                'warehouse_id' => $this->warehouse_id,
                'employee_id' => $this->employee_id,
                'service_id' => $this->service_id
            ]);

            // foreach ($cart_session_ as $id_ => $item) {
            //     $price_type = array_search($item['price'], $item['prices']);
            //     SaleDetail::create([
            //         'quantity' => $item['quantity'],
            //         'price' => $item['price'],
            //         'discount' => $item['discount'],
            //         'subtotal' => $item['subtotal'],
            //         'batch_id' => $id_,
            //         'sale_id' => $sale->id,
            //         'price_type' => $price_type
            //     ]);
            // }
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
            $this->updateStock();
        }
    }

    //Funcion comparar
    public function checkStock()
    {
        $cart_session_ = session()->get('cart');
        try {
            foreach ($cart_session_ as $id_ => $item) {

                $batch = Batch::find($id_);
                if ($item['quantity'] > $batch->stock) {
                    /*Mostrando mensaje */
                    $this->alert('error', 'La cantidad <span class=" text-red-500 font-bold text-xl">' . $item['quantity'] . '</span> es superior al stok disponible.', [
                        'position' => 'top-end',
                        'timer' => 3000,
                        'toast' => true,
                        'text' => '',
                        'confirmButtonText' => 'Ok',
                    ]);
                    return false;
                }
            }
            return true;
        } catch (\Throwable $th) {
            $this->alert('error', '<span class=" text-red-500 font-bold text-xl">La lista de productos esta vacía.</span>', [
                'position' => 'top-end',
                'timer' => 3000,
                'toast' => true,
                'text' => '',
                'confirmButtonText' => 'Ok',
            ]);
            return false;
        }
    }

    public function updateStock()
    {
        $cart_session_ = session()->get('cart');
        foreach ($cart_session_ as $id_ => $item) {
            $batch = Batch::find($id_);
            $batch->stock = $batch->stock - $item['quantity'];
            $batch->update([
                'stock' => $batch->stock,
            ]);
        }
    }

    public function cleanInputs()
    {
        $this->total = "";
    }

    protected $listeners = [
        'confirmed',
    ];

    public function confirmed()
    {
        return redirect()->route('sale.dashboard');
    }

    public function showInfoCustomer()
    {
        $this->customer = Customer::find($this->customer_id);
    }


    public function updatePrice($id)
    {
        session()->put('cart', $this->cart_session_);
        foreach ($this->cart_session_ as $id_ => $item) {
            if ($id_ == $id) {
                $this->updateQuantity($id);
            }
        }
    }

    public function addItemCart()
    {
        if (!$this->customer) {
            $this->toastError('Seleccione un cliente.');
            return;
        }
        if (!$this->service_price) {
            $this->toastError('Seleccione un servicio.');
            return;
        }
        $this->cart->addProductCart($this->batch_id, 1, $this->batch->final_price, $this->service_price);
        $this->toastAddProduct();
    }

    public function updateQuantity($id)
    {
        foreach ($this->cart_session_ as $id_ => $item) {
            if ($id_ == $id) {
                $this->cart->updateProductCart($id, $item['quantity'], $this->service_price);
            }
        }
    }

    public function updateDiscount($id)
    {
        foreach ($this->cart_session_ as $id_ => $item) {
            if ($id_ == $id) {
                $this->cart->updateProductCartDiscount($id, $item['discount'], $this->service_price);
            }
        }
    }



    public function onChangeSelect()
    {
        $this->emit('refreshSelects', $this->batchs);
    }

    public function deleteProductCart($id)
    {
        $this->cart->deleteProductCart($id, $this->service_price);
        $this->alert('info', 'Producto quitado correctamente.', [
            'position' => 'top-end',
            'timer' => 3000,
            'toast' => true,
            'text' => '',
            'confirmButtonText' => 'Ok',
        ]);
    }

    public function toastAddProduct()
    {
        $this->alert('success', 'Producto agregado correctamente.', [
            'position' => 'top-end',
            'timer' => 3000,
            'toast' => true,
            'text' => '',
            'confirmButtonText' => 'Ok',
        ]);
    }

    public function toastSuccess($message)
    {
        $this->alert('success', $message, [
            'position' => 'top-end',
            'timer' => 3000,
            'toast' => true,
            'text' => '',
            'confirmButtonText' => 'Ok',
        ]);
    }

    private function toastError($message)
    {
        $this->alert('error', $message, [
            'position' => 'top-end',
            'timer' => 3000,
            'toast' => true,
            'text' => '',
            'confirmButtonText' => 'Ok',
        ]);
    }

    function goCreateBatch()
    {
        return redirect()->route('batch.create');
    }

    public function onChangeSelectWarehouse()
    {
        $this->batchs = Batch::where('state', 'ACTIVE')->where('warehouse_id', $this->warehouse_id)->where('stock', '>', '0')->with('product')->get();
        $this->selected_batch = null;
        $this->onChangeSelect();
    }

    public function onChangeSelectBatch()
    {
        if ($this->batch_id > 0) {
            $this->selected_batch = Batch::find($this->batch_id);
        }
        $this->onChangeSelect();
    }

    public function onChangeSelectService()
    {
        if ($this->service_id > 0) {
            $this->selected_service = Service::find($this->service_id);
            $this->additional_service_price = $this->selected_service->price;
        }
        $this->onChangeSelect();
    }

    public function onChangeSelectEmployee()
    {
        if ($this->employee_id > 0) {
            $this->selected_employee = Employee::find($this->service_id);
        }
        $this->onChangeSelect();
    }

    function addLabour()
    {
        if ($this->selected_employee != null && $this->selected_service != null) {
            $uuid = (string) Str::uuid();
            $item = [
                'uuid' => $uuid,
                'employee_percentage' => $this->additional_percent_employe,
                'price' => $this->additional_service_price,
                'quantity' => $this->additional_service_quantity,
                'subtotal' => $this->additional_service_quantity * $this->additional_service_price,
                'employee_id' => $this->employee_id,
                'employee' => $this->selected_employee->person->name,
                'service_id' => $this->service_id,
                'service' => $this->selected_service->name,
            ];
            $this->labours[$uuid] = $item;
            $this->toastSuccess('Item agregado.');
        } else {
            $this->toastError('Seleccione los datos correctamente.');
        }
    }

    function updateLabour($uuid)
    {
        $price = $this->labours[$uuid]['price'];
        $quantity = $this->labours[$uuid]['quantity'];
        $this->labours[$uuid]['subtotal'] = $price * $quantity;
    }

    function removeLabour($uuid)
    {
        if (isset($this->labours[$uuid])) {
            unset($this->labours[$uuid]);
            $this->toastSuccess('Item removido.');
        }
    }
    function addBatch()
    {
        if ($this->selected_batch != null) {
            $id = $this->selected_batch->id;
            //verificacion si el producto existe
            if ($this->sale_details && isset($this->sale_details[$id])) {
                $this->sale_details[$id]['quantity'] += 1;
                $this->updateSaleDetail($id);
            } else {
                $item = [
                    'id' => $id,
                    'name' => $this->selected_batch->product->name,
                    'price' => $this->selected_batch->wholesale_price,
                    'quantity' => 1,
                    'discount' => 0,
                    'subtotal' => $this->selected_batch->wholesale_price * 1
                ];
                $this->sale_details[$id] = $item;
            }
            $this->toastSuccess('Item agregado.');
        } else {
            $this->toastError('Seleccione los datos correctamente.');
        }
    }

    function updateSaleDetail($id)
    {
        $price = $this->sale_details[$id]['price'];
        $quantity = $this->sale_details[$id]['quantity'];
        $discount = $this->sale_details[$id]['discount'];
        $subtotal =  $price * $quantity;
        $subtotal =  $subtotal - ($subtotal * ($discount / 100));
        $this->sale_details[$id]['subtotal'] = $subtotal;
    }

    function removeSaleDetail($id)
    {
        if (isset($this->sale_details[$id])) {
            unset($this->sale_details[$id]);
            $this->toastSuccess('Item removido.');
        }
    }
}
