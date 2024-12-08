<?php

namespace App\Http\Livewire\Reports\BirthdayReport;

use App\Models\Customer;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class BirthdayReportDataTable extends LivewireDatatable
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
    public $start_date;
    public $end_date;


    protected $listeners = ['setDates'];

    public function setDates($start, $end)
    {
        $this->start_date = $start;
        $this->end_date = $end;
    }

    public function builder()
    {
        return Customer::query()
            ->whereBetween('customers.birthday', [$this->start_date, $this->end_date])
            ->where('customers.state', '!=', 'DELETED')
            ->join('people as person', 'person.id', '=', 'customers.person_id')
            ->leftJoin('telephones as phone1', function ($join) {
                $join->on('phone1.person_id', '=', 'person.id')
                    ->where('phone1.type', '=', 'primary');
            })
            ->leftJoin('telephones as phone2', function ($join) {
                $join->on('phone2.person_id', '=', 'person.id')
                    ->where('phone2.type', '=', 'secondary');
            })
            ->leftJoin('telephones as phone3', function ($join) {
                $join->on('phone3.person_id', '=', 'person.id')
                    ->where('phone3.type', '=', 'tertiary');
            })
            ->groupBy('customers.id');
    }


    public function columns()
    {
        return [
            Column::name('person.name')
                ->searchable()
                ->label('Nombre completo')
                ->alignRight(),

            Column::name('customers.birthday')
                ->searchable()
                ->label('Cumpleaños')
                ->alignRight(),

            Column::callback(['phone1.number'], function ($number) {
                if ($number) {
                    $url = "https://wa.me/591" . $number;
                    return '<a href="' . $url . '" target="_blank" class="text-blue-500 underline">' . $number . '</a>';
                }
                return '-';
            })
                ->label('Nro. Principal (Whatsapp)')
                ->alignRight()
                ->unsortable(),

            Column::name('phone2.number')
                ->label('Nro. Secundario')
                ->alignRight(),

            Column::name('phone3.number')
                ->label('Teléfono fijo')
                ->alignRight(),

            Column::name('email')
                ->searchable()
                ->label('Correo electrónico')
                ->alignRight(),
        ];
    }
}
