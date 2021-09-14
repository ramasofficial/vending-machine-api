<?php

declare(strict_types=1);

namespace App\Services\VendingMachine\Commands;

use App\Services\VendingMachine\Repositories\VendingMachineRepository;

class AddBalanceCommand
{
    private VendingMachineRepository $vendingMachineRepository;

    public function __construct(VendingMachineRepository $vendingMachineRepository)
    {
        $this->vendingMachineRepository = $vendingMachineRepository;
    }

    public function execute(int $id, int $amount): array
    {
        $vendingMachine = $this->vendingMachineRepository->getVendingMachine($id);

        $newBalance = $vendingMachine->balance + $amount;

        return [
            'save' => $this->vendingMachineRepository->updateBalance($id, $newBalance),
            'balance' => $newBalance
        ];
    }
}
