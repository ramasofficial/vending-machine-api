<?php

declare(strict_types=1);

namespace App\Services\VendingMachine\Repositories;

use App\Models\VendingMachine;

class VendingMachineRepository
{
    public function getVendingMachine(int $id)
    {
        return VendingMachine::findOrFail($id);
    }

    public function updateBalance(int $id, int $balance)
    {
        $vendingMachine = $this->getVendingMachine($id);

        $vendingMachine->balance = $balance;

        return $vendingMachine->save();
    }
}
