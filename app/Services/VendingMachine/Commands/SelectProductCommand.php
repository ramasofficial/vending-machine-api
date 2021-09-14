<?php

declare(strict_types=1);

namespace App\Services\VendingMachine\Commands;

use App\Services\VendingMachine\Exceptions\UserDoesntHaveEnoughBalanceException;
use App\Services\VendingMachine\Repositories\VendingMachineProductRepository;
use App\Services\VendingMachine\Repositories\VendingMachineRepository;

class SelectProductCommand
{
    private VendingMachineRepository $vendingMachineRepository;

    private VendingMachineProductRepository $vendingMachineProductRepository;

    public function __construct(VendingMachineRepository $vendingMachineRepository, VendingMachineProductRepository $vendingMachineProductRepository)
    {
        $this->vendingMachineRepository = $vendingMachineRepository;
        $this->vendingMachineProductRepository = $vendingMachineProductRepository;
    }

    public function execute(int $id, int $pences): array
    {
        $vendingMachine = $this->vendingMachineRepository->getVendingMachine($id);
        $product = $this->vendingMachineProductRepository->getProductByPences($pences);

        if(!$this->haveEnoughBalance($vendingMachine->balance, $product->price_in_pences)) {
            throw new UserDoesntHaveEnoughBalanceException();
        }

        $newBalance = $this->calculateNewBalance($vendingMachine, $product);

        $this->vendingMachineRepository->updateBalance($id, $newBalance);

        return [
            'selected_product' => $product->name,
            'balance' => $newBalance,
        ];
    }

    private function haveEnoughBalance(int $balance, int $productPrice): bool
    {
        return $balance >= $productPrice;
    }

    private function calculateNewBalance($vendingMachine, $product): int
    {
        return $vendingMachine->balance - $product->price_in_pences;
    }
}
