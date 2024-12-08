<?php

namespace App\Http\Livewire\Reports\BirthdayReport;

use App\Models\Customer;
use App\Models\ServiceOrder;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class BirthdayReportDashboard extends Component
{
    use WithPagination;

    public $start_date;
    public $end_date;

    public $total;

    public function mount()
    {
        $this->start_date = Carbon::now()->format('Y-m-d');
        $this->end_date = Carbon::now()->format('Y-m-d');
    }

    public function render()
    {

        $this->calcTotals();

        return view('livewire.reports.birthday-report.birthday-report-dashboard', [
            'total' => $this->total
        ]);
    }

    public function emitDates()
    {
        $this->emit('setDates', $this->start_date, $this->end_date);
    }


    public function calcTotals(){
        $this->total = Customer::select('*')
            ->whereBetween('customers.birthday', [$this->start_date, $this->end_date])
            ->where('customers.state', 'ACTIVE')
            ->count();
    }

    public function changeInputDate()
    {
        $this->calcTotals();
    }


}
