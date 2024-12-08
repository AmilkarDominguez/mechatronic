<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Batch;
use App\Models\Customer;
use App\Models\Product;
use App\Models\ServiceOrder;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Dashboard extends Component
{
    use WithPagination;

    public int $current_year = 0;
    public int $current_month = 1;
    public int $current_day = 1;

    public int $count_comleted_services_ordes = 0;
    public int $count_pending_services_ordes = 0;
    public int $total_customers = 0;

    public $chart_data_months = [];
    public $chart_data_months_total = [];
    public $chart_months = [];


    public function mount()
    {
        $this->current_year = now()->year;
        $this->current_month = now()->month;
        $this->current_day = now()->day;
        $this->count_comleted_services_ordes = ServiceOrder::all()->where('state','COMPLETED')->count();
        $this->count_pending_services_ordes = ServiceOrder::all()->where('state','PENDING')->count();
        $this->total_customers = Customer::all()->count();
        $this->calcSalesChar();
    }

    public function render()
    {
        $batches = Batch::select('batches.*')
            ->whereMonth('batches.expiration_date', $this->current_month)
            ->where('batches.state', 'ACTIVE')
            ->orderBy('batches.expiration_date', 'ASC')
            ->paginate(10);

        return view('livewire.dashboard.dashboard', [
            'batches' => $batches,
        ]);
    }

    public function calcSalesChar()
    {

        $this->chart_data_months = [];
        $this->chart_data_months_total = [];
        $this->chart_months = [];
        $months = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

        for ($month = 1; $month <= $this->current_month; $month++) {

            $data_month = ServiceOrder::select('*')
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', $this->current_year)
                ->where('service_orders.state', 'COMPLETED')
                ->count();

            $total = DB::table("service_orders")
                ->whereMonth('created_at', $month)
                ->whereYear('created_at', $this->current_year)
                ->where('service_orders.state', 'COMPLETED')
                ->get()->sum("have");

            $this->chart_data_months[$month] = $data_month;
            $this->chart_data_months_total[$month] = round($total, 2);
            $this->chart_months[$month] = $months[$month - 1];
        }
    }
}
