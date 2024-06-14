<?php

namespace App\Http\Livewire\ServiceOrder;

use App\Models\Batch;
use App\Models\Cart;
use App\Models\Customer;
use App\Models\Warehouse;
use Livewire\Component;
use App\Models\ServiceOrder;
use App\Models\Bonus;
use App\Models\Employee;
use App\Models\ExtraItem;
use App\Models\LabourDetail;
use App\Models\Promoter;
use App\Models\ServiceOrderBatch;
use App\Models\Service;
use App\Models\ServiceOrderExtraItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ServiceOrderCreate extends Component
{
    use LivewireAlert;


    public $payment_type = 'CONTADO';
    public $description;

    public $services;
    public $service_id;
    public $selected_service;
    public $employees;
    public $employee_id;
    public $selected_employee;
    public $additional_percent_employe = 0;
    public $additional_service_price = 0;
    public $additional_service_quantity = 1;
    public $labours = [];
    public $labours_total = 0;

    public $warehouses;
    public $warehouse_id;
    public $batches;
    public $batch_id;
    public $selected_batch;
    public $sale_details = [];
    public $sale_details_total = 0;
    
    public $extra_items;
    public $extra_item_id;
    public $selected_extra_item;
    public $additional_extra_item_cost = 0;
    public $additional_extra_item_price = 0;
    public $additional_extra_item_quantity = 1;
    public $additional_extra_items = [];
    public $additional_extra_items_total = 0;

    public $customers;
    public $customer_id;
    public $selected_customer;

    public $total;

    public function mount()
    {
        $this->customers = Customer::all()->where('state', 'ACTIVE');
        $this->warehouses = Warehouse::all()->where('state', 'ACTIVE');
        $this->employees = Employee::all()->where('state', 'ACTIVE');
        $this->services = Service::all()->where('state', 'ACTIVE');
        $this->extra_items = ExtraItem::all()->where('state', 'ACTIVE');

        //Seleccionando primer almacen
        if ($this->warehouses[0]) {
            $this->warehouse_id = $this->warehouses[0]->id;
            $this->batches = Batch::where('state', 'ACTIVE')->where('warehouse_id', $this->warehouse_id)->where('stock', '>', '0')->with('product')->get();
        }
    }

    public function render()
    {
        return view('livewire.service-order.service-order-create');
    }

    //reglas para validacion
    protected $rules = [
        'customer_id' => 'required',
    ];

    public function saveSale()
    {
        $this->validate();
        if ($this->checkStock()) {
            $service_order = ServiceOrder::create([
                'description' => $this->description || '',
                'total' => $this->total,
                'must' => $this->total,
                'slug' => Str::uuid(),
                'customer_id' => $this->customer_id,
                'user_id' => Auth::user()->id,
                'state' => 'PENDING',
                'payment_type' => $this->payment_type
            ]);
            foreach ($this->labours as $item) {
                LabourDetail::create([
                    'uuid' => $item['uuid'],
                    'employee_percentage' => $item['employee_percentage'],
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['subtotal'],
                    'employee_id' => $item['employee_id'],
                    'service_id' => $item['service_id'],
                    'service_order_id' => $service_order->id
                ]);
            }
            foreach ($this->sale_details as $item) {
                ServiceOrderBatch::create([
                    'uuid' => Str::uuid(),
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'discount' => $item['discount'],
                    'subtotal' => $item['subtotal'],
                    'batch_id' => $item['id'],
                    'service_order_id' => $service_order->id
                ]);
            }
            $this->updateStock();
            foreach ($this->additional_extra_items as $item) {
                ServiceOrderExtraItem::create([
                    'uuid' => $item['uuid'],
                    'cost' => $item['cost'],
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['subtotal'],
                    'extra_item_id' => $item['id'],
                    'service_order_id' => $service_order->id,
                ]);
            }

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
    }

    //Funcion comparar
    public function checkStock()
    {
        try {
            foreach ($this->sale_details as $item) {
                $batch = Batch::find($item['id']);
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
        foreach ($this->sale_details as $item) {
            $batch = Batch::find($item['id']);
            $batch->stock = $batch->stock - $item['quantity'];
            $batch->update([
                'stock' => $batch->stock,
            ]);
        }
    }

    public function onChangeSelect()
    {
        $this->emit('refreshSelects', $this->batches);
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


    public function onChangeSelectService()
    {
        if ($this->service_id > 0) {
            $this->selected_service = Service::find($this->service_id);
            $this->additional_service_price = $this->selected_service->price;
        }
    }

    public function onChangeSelectExtraItems()
    {
        if ($this->extra_item_id > 0) {
            $this->selected_extra_item = ExtraItem::find($this->extra_item_id);
            $this->additional_extra_item_cost = $this->selected_extra_item->cost;
            $this->additional_extra_item_price = $this->selected_extra_item->price;
            $this->additional_extra_item_quantity = 1;
        }
    }

    public function onChangeSelectEmployee()
    {
        if ($this->employee_id > 0) {
            $this->selected_employee = Employee::find($this->service_id);
        }
    }

    public function onChangeSelectCustomer()
    {
        if ($this->customer_id > 0) {
            $this->selected_customer = Customer::find($this->customer_id);
        }
    }

    public function onChangeSelectWarehouse()
    {
        $this->batches = Batch::where('state', 'ACTIVE')->where('warehouse_id', $this->warehouse_id)->where('stock', '>', '0')->with('product')->get();
        $this->selected_batch = null;
        $this->onChangeSelect();
    }

    public function onChangeSelectBatch()
    {
        if ($this->batch_id > 0) {
            $this->selected_batch = Batch::find($this->batch_id);
        }
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
            $this->calcLaboursTotal();
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
        $this->calcLaboursTotal();
    }

    function removeLabour($uuid)
    {
        if (isset($this->labours[$uuid])) {
            unset($this->labours[$uuid]);
            $this->calcLaboursTotal();
            $this->toastSuccess('Item removido.');
        }
    }

    function calcLaboursTotal()
    {
        $this->labours_total = 0;
        foreach ($this->labours as $item) {
            $this->labours_total += $item['subtotal'];
        }
        $this->calcTotal();
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
                $this->calcSaleDetailsTotal();
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
        $this->calcSaleDetailsTotal();
    }

    function removeSaleDetail($id)
    {
        if (isset($this->sale_details[$id])) {
            unset($this->sale_details[$id]);
            $this->calcSaleDetailsTotal();
            $this->toastSuccess('Item removido.');
        }
    }

    function calcSaleDetailsTotal()
    {
        $this->sale_details_total = 0;
        foreach ($this->sale_details as $item) {
            $this->sale_details_total += $item['subtotal'];
        }
        $this->calcTotal();
    }

    function addExtraItem()
    {
        if ($this->selected_extra_item != null) {
            $uuid = (string) Str::uuid();
            $item = [
                'uuid' => $uuid,
                'id' => $this->selected_extra_item->id,
                'name' => $this->selected_extra_item->name,
                'cost' => $this->additional_extra_item_cost,
                'price' => $this->additional_extra_item_price,
                'quantity' => $this->additional_extra_item_quantity,
                'subtotal' => $this->additional_extra_item_quantity * $this->additional_extra_item_price
            ];
            $this->additional_extra_items[$uuid] = $item;
            $this->calcExtraItemsTotal();
            $this->toastSuccess('Item agregado.');
        } else {
            $this->toastError('Seleccione los datos correctamente.');
        }
    }

    function updateExtraItem($uuid)
    {
        $price = $this->additional_extra_items[$uuid]['price'];
        $quantity = $this->additional_extra_items[$uuid]['quantity'];
        $this->additional_extra_items[$uuid]['subtotal'] = $price * $quantity;
        $this->calcExtraItemsTotal();
    }

    function removeExtraItem($uuid)
    {
        if (isset($this->additional_extra_items[$uuid])) {
            unset($this->additional_extra_items[$uuid]);
            $this->calcExtraItemsTotal();
            $this->toastSuccess('Item removido.');
        }
    }

    function calcExtraItemsTotal()
    {
        $this->additional_extra_items_total = 0;
        foreach ($this->additional_extra_items as $item) {
            $this->additional_extra_items_total += $item['subtotal'];
        }
        $this->calcTotal();
    }

    function calcTotal()
    {
        $this->total = $this->labours_total + $this->sale_details_total + $this->additional_extra_items_total;
    }


    protected $listeners = [
        'confirmed',
        'serviceAdded',
        'extraItemAdded'
    ];

    public function confirmed()
    {
        return redirect()->route('service-order.dashboard');
    }

    public function extraItemAdded($id)
    {
        $this->extra_items = ExtraItem::all()->where('state', 'ACTIVE');
        $this->extra_item_id = $id;
        $this->onChangeSelectExtraItems();
        $this->emit('extraItemAddedEvent', $this->extra_items, $id);
    }
}
