<?php

declare(strict_types=1);

namespace App\Services\VendingMachine\Commands;

use App\Services\VendingMachine\Repositories\VendingMachineRepository;

class GetBalanceCommand
{
    private VendingMachineRepository $vendingMachineRepository;

    public function __construct(VendingMachineRepository $vendingMachineRepository)
    {
        $this->vendingMachineRepository = $vendingMachineRepository;
    }

    public function execute(int $id)
    {
        $vendingMachine = $this->vendingMachineRepository->getVendingMachine($id);

        return $vendingMachine->balance;
    }
}
