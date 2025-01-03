<?php

namespace App\Http\Livewire\Expense;

use App\Models\BankAccountHistory;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\DateColumn;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class ExpenseDataTable extends LivewireDatatable
{
    use LivewireAlert;
    public $exportable = true;
    public $model = BankAccountHistory::class;
    public $hideable = 'select';

    public function builder()
    {
        return (BankAccountHistory::query()
            ->join('transaction_types', function ($join) {
                $join->on('transaction_types.id', '=', 'bank_account_histories.transaction_type_id');
            })
            ->join('bank_accounts', function ($join) {
                $join->on('bank_accounts.id', '=', 'bank_account_histories.bank_account_id');
            })
            ->join('users', function ($join) {
                $join->on('users.id', '=', 'bank_account_histories.user_id');
            })
            ->join('people', function ($join) {
                $join->on('people.id', '=', 'users.person_id');
            })
            ->where('transaction_types.type', 'EGRESO')
        );
    }

    public function columns()
    {
        return [

            Column::name('transaction_types.name')
                ->searchable()
                ->label('Tipo')
                ->alignRight(),

            Column::name('bank_accounts.name')
                ->searchable()
                ->label('Cuenta')
                ->alignRight(),

            Column::name('bank_account_histories.amount')
                ->searchable()
                ->label('Monto'),

            Column::name('bank_account_histories.balance')
                ->searchable()
                ->label('Balance'),

            Column::callback(['people.name', 'people.lastname'], function ($name, $lastname) {
                return $name . ' ' . $lastname;
            })
                ->label('Registrado por'),

            DateColumn::name('bank_account_histories.created_at')
                ->label('Creado')
                ->format('d/m/Y h:i:s')
                ->filterable(),

        ];
    }
}
