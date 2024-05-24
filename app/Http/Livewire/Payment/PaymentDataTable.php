<?php

namespace App\Http\Livewire\Payment;

use App\Models\Payment;
use App\Models\Sale;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class PaymentDataTable extends LivewireDatatable
{
    use LivewireAlert;
    public $exportable = true;
    public $model = Payment::class;

    //variable que llega desde la vista blade payment-dashboard.blade
    public $sale_id;

    public $hideable = 'select';

    public function builder()
    {
        return (Payment::query()
            ->join('sales', function ($join) {
                $join->on('sales.id', '=', 'payments.sale_id');
            })
            ->where('payments.sale_id',  $this->sale_id)
            ->where('payments.state', 'ACTIVE'));
    }
    public function edit($id)
    {
        $this->emit('edit_documento', $id);
        return redirect()->to('/store-documentos');
    }

    public function columns()
    {
        return [
            Column::name('sales.id')
                ->searchable()
                ->label('Código de venta'),

            Column::name('amount')
                ->searchable()
                ->label('Monto'),

            DateColumn::name('created_at')
                ->label('Creado')
                ->format('d/m/Y h:i:s')
                ->filterable(),


            Column::callback(['id', 'slug'], function ($id, $slug) {
                return view('livewire.payment.payment-table-actions', ['id' => $id, 'slug' => $slug]);
            })->label('Opciones')
                ->excludeFromExport()

        ];
    }

    public $idDelet;
    public function toastConfirmDelet($id)
    {
        $this->idDelet = $id;
        $this->confirm(__('¿Estas seguro que seas eliminar el registro?'), [
            'icon' => 'warning',
            'position' =>  'center',
            'toast' =>  false,
            'confirmButtonText' =>  'Si',
            'showConfirmButton' =>  true,
            'showCancelButton' => true,
            'onConfirmed' => 'confirmed',
            'confirmButtonColor' => '#A5DC86',
        ]);
    }

    protected $listeners = [
        'confirmed',
    ];
    public function confirmed()
    {
        if ($this->idDelet) {
            $Payment = Payment::find($this->idDelet);
            $this->sale = Sale::where('id', $Payment->sale_id)->firstOrFail();
            $this->sale->update([
                'have' => $this->sale->have - $Payment->amount,
                'must' => $this->sale->must + $Payment->amount,
            ]);
            $Payment->delete();
            // $Payment->state = "DELETED";
            // $Payment->update();
            return redirect()->route('payment.dashboard', [$this->sale->slug]);
        }
    }
}
