<?php

namespace App\Http\Livewire\Payment;

use App\Models\Payment;
use App\Models\ServiceOrder;
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

    // Variable que llega desde la vista Blade payment-dashboard.blade
    public $service_order_id;
    public $service_order;

    public $hideable = 'select';

    public function builder()
    {
        return (Payment::query()
            ->join('service_orders', function ($join) {
                $join->on('service_orders.id', '=', 'payments.service_order_id');
            })
            ->where('payments.service_order_id', $this->service_order_id)
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
            Column::name('service_orders.id')
                ->searchable()
                ->label('Código de Orden de Servicio'),

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
        $this->confirm(__('¿Estás seguro de que deseas eliminar el registro?'), [
            'icon' => 'warning',
            'position' => 'center',
            'toast' => false,
            'confirmButtonText' => 'Sí',
            'showConfirmButton' => true,
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
            $this->service_order = ServiceOrder::where('id', $Payment->service_order_id)->firstOrFail();
            $this->service_order->update([
                'have' => $this->service_order->have - $Payment->amount,
                'must' => $this->service_order->must + $Payment->amount,
            ]);
            $Payment->delete();
            return redirect()->route('payment.dashboard', [$this->service_order->slug]);
        }
    }
}
