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

    public $batchs;
    public $batch_id;
    public $batch;

    public $payment_type = 'CONTADO';
    public $price_type = 'FINAL';
    public $description;
    public $warehouses;
    public $warehouse_id;
    public $employees;
    public $employee_id;
    public $services;
    public $service_id;
    public $service_price;

    public $cart;
    public $cart_session_ = [];

    public function mount()
    {
        $this->customers = Customer::all()->where('state', 'ACTIVE');
        $this->warehouses = Warehouse::all()->where('state', 'ACTIVE');
        $this->employees = Employee::all()->where('state', 'ACTIVE');
        $this->services = Service::all()->where('state', 'ACTIVE');
        $this->cart = new Cart();
        //Limpiando carrito
        session()->forget('cart');

        //Seleccionando primer almacen
        if ($this->warehouses[0]) {
            $this->warehouse_id = $this->warehouses[0]->id;
            $this->batchs = Batch::where('state', 'ACTIVE')->where('warehouse_id', $this->warehouse_id)->where('stock', '>', '0')->with('product')->get();
        }
    }

    public function render()
    {
        $this->cart_session_ = session()->get('cart');
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
            $cart_session_ = session()->get('cart');
            foreach ($cart_session_ as $id_ => $item) {
                $price_type = array_search($item['price'], $item['prices']);
                SaleDetail::create([
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'discount' => $item['discount'],
                    'subtotal' => $item['subtotal'],
                    'batch_id' => $id_,
                    'sale_id' => $sale->id,
                    'price_type' => $price_type
                ]);
            }
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

    //Funcion para limpiar imputs
    public function cleanInputs()
    {
        $this->total = "";
    }

    //Escuchadores para botones de alertas
    protected $listeners = [
        'confirmed',
    ];

    //Funcion que llama la alerta para redigir al dashboar
    public function confirmed()
    {
        return redirect()->route('sale.dashboard');
    }

    public function showInfoCustomer()
    {
        $this->customer = Customer::find($this->customer_id);
        //Limpiando carrito
        session()->forget('cart');
    }

    public function showInfoBatch()
    {
        $this->batch = Batch::find($this->batch_id);
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

    private function showErrorMessage($message){
        $this->alert('error', $message, [
            'position' => 'top-end',
            'timer' => 3000,
            'toast' => true,
            'text' => '',
            'confirmButtonText' => 'Ok',
        ]);
    }

    //Funciones para carrito de compras
    public function addItemCart()
    {
        if (!$this->customer) {
            $this->showErrorMessage('Seleccione un cliente.');
            return;
        }
        if (!$this->service_price) {
            $this->showErrorMessage('Seleccione un servicio.');
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

    public function onChangeSelectWarehouse()
    {
        $this->batchs = Batch::where('state', 'ACTIVE')->where('warehouse_id', $this->warehouse_id)->where('stock', '>', '0')->with('product')->get();
        $this->onChangeSelect();
    }

    public function onChangeSelectService()
    {
        if ($this->service_id > 0) {
            $this->service_price = Service::find($this->service_id)->price;
        }
        $this->onChangeSelect();
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

    function viewCart()
    {
        dd($this->cart);
        //dd(session()->get('cart'));
    }

    function addBatch()
    {
        return redirect()->route('batch.create');
    }
}
