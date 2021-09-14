<?php

declare(strict_types=1);

namespace App\Services\VendingMachine\Commands;

use App\Services\VendingMachine\Repositories\VendingMachineProductRepository;

class GetProductsCommand
{
    private VendingMachineProductRepository $vendingMachineProductRepository;

    public function __construct(VendingMachineProductRepository $vendingMachineProductRepository)
    {
        $this->vendingMachineProductRepository = $vendingMachineProductRepository;
    }

    public function execute(int $id)
    {
        return $this->vendingMachineProductRepository->getProducts($id);
    }
}
