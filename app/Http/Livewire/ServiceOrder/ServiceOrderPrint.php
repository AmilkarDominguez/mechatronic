<?php

namespace App\Http\Livewire\ServiceOrder;

use App\Models\Batch;
use App\Models\Customer;
use App\Models\Warehouse;
use Livewire\Component;
use App\Models\ServiceOrder;
use App\Models\Employee;
use App\Models\ExtraItem;
use App\Models\LabourDetail;
use App\Models\ServiceOrderBatch;
use App\Models\Service;
use App\Models\ServiceOrderExtraItem;
use App\Models\Setting;
use App\Models\Vehicle;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ServiceOrderPrint extends Component
{
    use LivewireAlert;

    public $service_order;
    public $payment_type;
    public $setting;
    
    public $description = '';

    public $labours_details = [];
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

    public $serviceOrderBatches = [];
    public $warehouses;
    public $warehouse_id;
    public $batches;
    public $batch_id;
    public $selected_batch;
    public $sale_details = [];
    public $sale_details_total = 0;

    public $serviceOrderExtraItems = [];
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

    public $vehicle;

    public $total;

    public function mount($slug)
    {

        $this->setting = Setting::where('slug', 'configuration')->firstOrFail();

        $this->service_order = ServiceOrder::where('slug', $slug)->firstOrFail();
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
        $this->selected_customer = Customer::where('id', $this->service_order->customer_id)->firstOrFail();
        $this->vehicle = Vehicle::where('id', $this->service_order->vehicle_id)->firstOrFail();

        $this->customer_id = $this->service_order->customer_id;
        $this->payment_type = $this->service_order->payment_type;
        $this->description = $this->service_order->description;

        $this->loadLabours();
        $this->loadSaleDetails();
        $this->loadExtraItems();
    }

    public function loadLabours()
    {
        $this->labours = [];
        $this->labours_details = LabourDetail::all()->where('service_order_id', $this->service_order->id);
        foreach ($this->labours_details as $item) {
            $employee = Employee::where('id', $item->employee_id)->firstOrFail();
            $service = Service::where('id', $item->service_id)->firstOrFail();
            $item = [
                'uuid' => $item->uuid,
                'employee_percentage' => $item->employee_percentage,
                'price' => $item->price,
                'quantity' => $item->quantity,
                'subtotal' => $item->subtotal,
                'employee_id' => $item->employee_id,
                'employee' => $employee->person->name,
                'service_id' => $item->service_id,
                'service' => $service->name
            ];
            $this->labours[$item['uuid']] = $item;
        }
        $this->calcLaboursTotal();
    }

    function calcLaboursTotal()
    {
        $this->labours_total = 0;
        foreach ($this->labours as $item) {
            $this->labours_total += $item['subtotal'];
        }
        $this->calcTotal();
    }

    public function loadSaleDetails()
    {
        $this->serviceOrderBatches = ServiceOrderBatch::all()->where('service_order_id', $this->service_order->id);
        foreach ($this->serviceOrderBatches as $item) {
            $batch = Batch::where('id', $item->batch_id)->firstOrFail();
            $item = [
                'uudid' => $item->uudid,
                'id' => $batch->id,
                'name' => $batch->product->name,
                'price' => $item->price,
                'quantity' => $item->quantity,
                'discount' => $item->discount,
                'subtotal' => $item->subtotal
            ];
            $this->sale_details[$item['id']] = $item;
        }
        $this->calcSaleDetailsTotal();
    }

    function calcSaleDetailsTotal()
    {
        $this->sale_details_total = 0;
        foreach ($this->sale_details as $item) {
            $this->sale_details_total += $item['subtotal'];
        }
        $this->calcTotal();
    }


    public function loadExtraItems()
    {
        $this->serviceOrderExtraItems = ServiceOrderExtraItem::all()->where('service_order_id', $this->service_order->id);
        foreach ($this->serviceOrderExtraItems as $item) {
            $extraItem = ExtraItem::where('id', $item->extra_item_id)->firstOrFail();
            $item = [
                'uuid' => $item->uudid,
                'id' => $extraItem->id,
                'name' => $extraItem->name,
                'cost' => $item->cost,
                'price' => $item->price,
                'quantity' => $item->quantity,
                'subtotal' => $item->subtotal
            ];
            $this->additional_extra_items[$item['uuid']] = $item;
        }
        $this->calcExtraItemsTotal();
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

    public function render()
    {
        return view('livewire.service-order.service-order-print')->layout('layouts.guest');
    }
}
