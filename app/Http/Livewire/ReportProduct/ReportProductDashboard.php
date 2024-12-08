<?php

namespace App\Http\Livewire\ReportProduct;

use App\Models\Batch;
use App\Models\Expense;
use App\Models\Industry;
use App\Models\ServiceOrder;
use App\Models\ServiceOrderBatch;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class ReportProductDashboard extends Component
{
    use WithPagination;

    public $start_date;
    public $end_date;

    public $expenses_total;
    public $service_orders_total;
    public $utility;

    public $items;


    public function mount()
    {
        $this->items = [];
        $this->start_date = Carbon::now()->format('Y-m-d');
        $this->end_date = Carbon::now()->format('Y-m-d');
    }

    public function render()
    {

        $this->calcTotals();

        return view('livewire.report-product.report-product-dashboard', [
            'expenses_total' => $this->expenses_total,
            'service_orders_total' => $this->service_orders_total,
            'items' => $this->items,
        ]);
    }

    public function emitDates()
    {
        $this->emit('setDatesReportProduct', $this->start_date, $this->end_date);
    }


    public function calcTotals()
    {
        $this->expenses_total = Expense::select('*')
            ->whereBetween('expenses.created_at', [$this->start_date, $this->end_date])
            ->where('expenses.state', 'PENDING')
            ->sum('expenses.purchase');

        $this->service_orders_total = ServiceOrder::select('*')
            ->whereBetween('service_orders.created_at', [$this->start_date, $this->end_date])
            ->where('service_orders.state', 'COMPLETED')
            ->sum('service_orders.have');

        $this->items = DB::table('service_order_batches')
            ->select('name', 'product_id', 'batch_id',
                DB::raw('COUNT(*) as quantity'),
                DB::raw('SUM(service_order_batches.quantity) as total'))
            ->join('batches', function ($join) {
                $join->on('service_order_batches.batch_id', '=', 'batches.id');
            })
            ->join('products', function ($join) {
                $join->on('batches.product_id', '=', 'products.id');
            })
            //->where('service_order_batches.state', '!=', 'DELETED')
            ->whereBetween('service_order_batches.created_at', [$this->start_date, $this->end_date])
            ->groupBy('products.id')
            ->orderBy('total', 'DESC')
            ->limit(100)
            ->get();


        $this->utility = $this->service_orders_total - $this->expenses_total;
    }

    public function changeInputDate()
    {
        $this->calcTotals();
    }


}
