<?php

namespace App\Http\Livewire\Reports\ServiceByEmployeeReport;

use App\Models\Customer;
use App\Models\LabourDetail;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class ServiceByEmployeeReportDataTable extends LivewireDatatable
{
    use LivewireAlert;

    public $exportable = false;
    public $model = Customer::class;
    public $persistSearch = false;
    public $persistComplexQuery = false;
    public $persistHiddenColumns = false;
    public $persistSort = false;
    public $persistPerPage = false;
    public $persistFilters = false;
    public $employee_id;
    public $end_date;


    protected $listeners = ['setEmployeeId'];

    public function setEmployeeId($employee_id)
    {
        $this->employee_id = $employee_id;
    }

    public function builder()
    {
        return LabourDetail::query()
            ->where('labour_details.employee_id', $this->employee_id)
            //->where('customers.state', '!=', 'DELETED')
            ->join('service_orders as so', 'so.id', '=', 'labour_details.service_order_id')
            ->join('services', 'services.id', '=', 'labour_details.service_id')
        ;
    }


    public function columns()
    {
        return [

            Column::name('so.number')
                ->searchable()
                ->label('Nro Order de Servicio')
                ->alignRight(),

            // Column::name('so.state')
            //     ->searchable()
            //     ->label('Estado')
            //     ->alignRight(),

            Column::callback(['so.state'], function ($state) {
                return view('components.datatables.state-service-order-data-table', ['state' => $state]);
            })
                ->exportCallback(function ($state) {
                    return match ($state) {
                        'PENDING' => 'EN CURSO',
                        'COMPLETED' => 'COMPLETADO',
                        'DRAFT' => 'COTIZACIÓN',
                        default => 'DESCONOCIDO',
                    };
                })
                ->label('Estado')
                ->filterable([
                    'PENDING' => 'EN CURSO',
                    'COMPLETED' => 'COMPLETADO',
                    'DRAFT' => 'COTIZACIÓN',
                ]),

            Column::name('services.name')
                ->searchable()
                ->label('Servicio')
                ->alignRight(),

            Column::name('labour_details.subtotal')
                ->searchable()
                ->label('Precio')
                ->alignRight(),

            Column::name('labour_details.employee_percentage')
                ->searchable()
                ->label('Porcentaje')
                ->alignRight(),

        ];
    }
}
