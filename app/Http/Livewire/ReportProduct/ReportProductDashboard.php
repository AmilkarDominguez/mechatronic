<?php

namespace App\Http\Livewire\ReportProduct;

use App\Models\Batch;
use App\Models\Expense;
use App\Models\Industry;
use App\Models\Sale;
use App\Models\SaleDetail;
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
    public $sales_total;
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
            'sales_total' => $this->sales_total,
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
            ->where('expenses.state', 'ACTIVE')
            ->sum('expenses.purchase');

        $this->sales_total = Sale::select('*')
            ->whereBetween('sales.created_at', [$this->start_date, $this->end_date])
            ->where('sales.state', 'ACTIVE')
            ->sum('sales.have');

        $this->items = DB::table('sale_details')
            ->select('name', 'product_id', 'batch_id',
                DB::raw('COUNT(*) as quantity'),
                DB::raw('SUM(sale_details.quantity) as total'))
            ->join('batches', function ($join) {
                $join->on('sale_details.batch_id', '=', 'batches.id');
            })
            ->join('products', function ($join) {
                $join->on('batches.product_id', '=', 'products.id');
            })
            ->where('sale_details.state', '!=', 'DELETED')
            ->whereBetween('sale_details.created_at', [$this->start_date, $this->end_date])
            ->groupBy('products.id')
            ->orderBy('total', 'DESC')
            ->limit(100)
            ->get();


        $this->utility = $this->sales_total - $this->expenses_total;
    }

    public function changeInputDate()
    {
        $this->calcTotals();
    }


}
