<?php

namespace App\Http\Livewire\Reports\BatchStockReport;

use App\Models\Batch;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class BatchStockReportDashboard extends Component
{
    use WithPagination;

    public $limit;

    public $total;

    public function mount()
    {
        $this->limit = 0;
    }

    public function render()
    {

        $this->calcTotals();

        return view('livewire.reports.batch-stock-report.batch-stock-report-dashboard', [
            'total' => $this->total
        ]);
    }

    public function emitLimit()
    {
        $this->emit('setNumberLimit', $this->limit);
    }


    public function calcTotals(){
        $this->total = Batch::select('*')
            ->where('batches.stock','<=', $this->limit)
            ->where('batches.state', 'ACTIVE')
            ->count();
    }

    public function changeInputLimit()
    {
        $this->calcTotals();
    }


}
