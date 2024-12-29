<?php

namespace App\Services;

use App\Models\BankAccountHistory;

class BankAccountHistoryService
{
    /**
     * Registra un cambio en el historial de cuentas bancarias.
     *
     * @param int $bank_account_id ID de la cuenta bancaria.
     * @param int $user_id ID del usuario que realiza la acción.
     * @param float $amount Monto.
     * @param float $balance Nuevo saldo.
     */
    public function registerHistory(int $bank_account_id, float $amount, float $balance): void
    {
        if ($this->verify($amount, $balance)) {
            $user_id = Auth()->User()->id;
            BankAccountHistory::create([
                'bank_account_id' => $bank_account_id,
                'user_id' => $user_id,
                'amount' => $amount,
                'balance' => $balance,
            ]);
        }
    }

    /**
     * Verifica si el saldo actual y el Monto son diferentes.
     *
     * @param float $amount Saldo actual.
     * @param float $balance Nuevo saldo.
     * @return bool
     */
    private function verify(float $amount, float $balance): bool
    {
        return $amount !== $balance;
    }
}
