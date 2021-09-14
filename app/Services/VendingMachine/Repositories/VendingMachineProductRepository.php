<?php

declare(strict_types=1);

namespace App\Services\VendingMachine\Repositories;

use App\Models\VendingMachineProduct;

class VendingMachineProductRepository
{
    public function getProducts(int $id)
    {
        return VendingMachineProduct::where('vending_machine_id', $id)->oldest('price_in_pences')->get(['name', 'price_in_pences']);
    }

    public function getProductByPences(int $pences)
    {
        return VendingMachineProduct::where('price_in_pences', $pences)->firstOrFail();
    }
}
