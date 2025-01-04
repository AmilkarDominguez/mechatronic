<?php

namespace App\Http\Livewire\Reports\UtilityReport;

use App\Models\BankAccountHistory;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class UtilityReportDashboard extends Component
{
    use WithPagination;

    public $start_date;
    public $end_date;

    public $expenses_total;
    public $incomes_total;
    public $utility;

    public function mount()
    {
        $this->start_date = Carbon::now()->format('Y-m-d');
        $this->end_date = Carbon::now()->format('Y-m-d');
    }

    public function render()
    {

        $this->calcTotals();

        return view('livewire.reports.utility-report.utility-report-dashboard', [
            'expenses_total' => $this->expenses_total,
            'incomes_total' => $this->incomes_total,
        ]);
    }

    public function emitDates()
    {
        $this->emit('setDates', $this->start_date, $this->end_date);
    }


    public function calcTotals()
    {
        $this->expenses_total = BankAccountHistory::select('*')
            ->join('transaction_types', function ($join) {
                $join->on('transaction_types.id', '=', 'bank_account_histories.transaction_type_id');
            })
            ->whereBetween('bank_account_histories.created_at', [$this->start_date, $this->end_date])
            ->where('transaction_types.type', 'EGRESO')
            ->sum('bank_account_histories.amount');

        $this->incomes_total = BankAccountHistory::select('*')
            ->join('transaction_types', function ($join) {
                $join->on('transaction_types.id', '=', 'bank_account_histories.transaction_type_id');
            })
            ->whereBetween('bank_account_histories.created_at', [$this->start_date, $this->end_date])
            ->where('transaction_types.type', 'INGRESO')
            ->sum('bank_account_histories.amount');

        $this->utility = $this->incomes_total - $this->expenses_total;
    }

    public function changeInputDate()
    {
        $this->calcTotals();
    }
}
