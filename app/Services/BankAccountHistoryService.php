<?php

namespace App\Services;

use App\Models\BankAccount;
use App\Models\BankAccountHistory;

class BankAccountHistoryService
{

    private function verify(float $amount, float $balance): bool
    {
        return $amount != $balance || ($amount == 0 && $balance == 0);
    }

    public function updateBankAccount(
        string $uuid,
        int $bank_account_id,
        int $transaction_type_id,
        float $amount,
        string $transaction_reference = null
    ): void {
        $bank_account = BankAccount::where('id', $bank_account_id)->firstOrFail();
        if ($bank_account) {
            $diference =  $bank_account->balance - $amount;
            $new_balance = $bank_account->balance + ($diference);
            $bank_account = $bank_account->update([
                'balance' => $new_balance,
            ]);
            $this->registerHistory(
                $uuid,
                $bank_account->id,
                $transaction_type_id,
                $diference,
                $bank_account->balance,
                $transaction_reference
            );
        }
    }

    public function registerIncome(
        string $uuid,
        int $bank_account_id,
        int $transaction_type_id,
        float $amount,
        string $transaction_reference = null
    ): void {
        $bank_account = BankAccount::where('id', $bank_account_id)->firstOrFail();
        if ($bank_account) {
            $balance =  $bank_account->balance + $amount;
            $bank_account = $bank_account->update([
                'balance' => $balance,
            ]);
            $this->registerHistory(
                $uuid,
                $bank_account_id,
                $transaction_type_id,
                $amount,
                $balance,
                $transaction_reference
            );
        }
    }

    public function registerExpense(
        string $uuid,
        int $bank_account_id,
        int $transaction_type_id,
        float $amount,
        string $transaction_reference = null
    ): void {
        $bank_account = BankAccount::where('id', $bank_account_id)->firstOrFail();
        if ($bank_account) {
            $diference =  $bank_account->balance - $amount;
            $bank_account = $bank_account->update([
                'balance' => $diference,
            ]);
            $this->registerHistory(
                $uuid,
                $bank_account_id,
                $transaction_type_id,
                $amount,
                $diference,
                $transaction_reference
            );
        }
    }

    public function registerHistory(
        string $uuid,
        int $bank_account_id,
        int $transaction_type_id,
        float $amount,
        float $balance,
        string $transaction_reference = null
    ): void {
        if ($this->verify($amount, $balance)) {
            $user_id = Auth()->User()->id;
            BankAccountHistory::create([
                'uuid' => $uuid,
                'bank_account_id' => $bank_account_id,
                'transaction_type_id' => $transaction_type_id,
                'user_id' => $user_id,
                'amount' => $amount,
                'balance' => $balance,
                'transaction_reference' => $transaction_reference
            ]);
        }
    }
}
