<?php

namespace App\Http\Livewire\Reports\ServiceByEmployeeReport;

use App\Models\Customer;
use App\Models\Employee;
use App\Models\LabourDetail;
use App\Models\ServiceOrder;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class ServiceByEmployeeReportDashboard extends Component
{
    use WithPagination;

    public $employee_id;
    public $employees;
    public $total = 0;

    public function mount()
    {
    }

    public function render()
    {
        $this->employees = Employee::all()->where('state', 'ACTIVE');
        $this->calcTotals();

        return view('livewire.reports.service-by-employee-report.service-by-employee-report-dashboard', [
            'total' => $this->total,
            'employees' => $this->employees,
        ]);
    }

    public function emitEmployee()
    {
        $this->emit('setEmployeeId', $this->employee_id);
    }

    public function calcTotals(){
        if ($this->employee_id){
            $this->total = LabourDetail::select('*')
            ->where('labour_details.employee_id', $this->employee_id)
            ->count();
        }
    }

    public function changeSelectEmployee()
    {
        $this->calcTotals();
    }
}
