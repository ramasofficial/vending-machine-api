<?php

declare(strict_types=1);

namespace App\Services\VendingMachine\Commands;

use App\Services\VendingMachine\Repositories\VendingMachineRepository;

class RefundCommand
{
    private const ZERO_BALANCE = 0;

    private VendingMachineRepository $vendingMachineRepository;

    public function __construct(VendingMachineRepository $vendingMachineRepository)
    {
        $this->vendingMachineRepository = $vendingMachineRepository;
    }

    public function execute(int $id): array
    {
        $vendingMachine = $this->vendingMachineRepository->getVendingMachine($id);

        $newBalance = self::ZERO_BALANCE;

        return [
            'save' => $this->vendingMachineRepository->updateBalance($id, $newBalance),
            'refund' => $vendingMachine->balance
        ];
    }
}
