<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddBalanceRequest;
use App\Http\Requests\SelectProductRequest;
use App\Models\VendingMachine;
use App\Services\VendingMachine\Commands\AddBalanceCommand;
use App\Services\VendingMachine\Commands\GetBalanceCommand;
use App\Services\VendingMachine\Commands\GetProductsCommand;
use App\Services\VendingMachine\Commands\RefundCommand;
use App\Services\VendingMachine\Commands\SelectProductCommand;
use App\Services\VendingMachine\Repositories\VendingMachineProductRepository;
use App\Services\VendingMachine\Repositories\VendingMachineRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VendingMachineController extends Controller
{
    private VendingMachineRepository $vendingMachineRepository;

    private VendingMachineProductRepository $vendingMachineProductRepository;

    public function __construct(VendingMachineRepository $vendingMachineRepository, VendingMachineProductRepository $vendingMachineProductRepository)
    {
        $this->vendingMachineRepository = $vendingMachineRepository;
        $this->vendingMachineProductRepository = $vendingMachineProductRepository;
    }

    public function balance(Request $request): JsonResponse
    {
        $balanceCommand = new GetBalanceCommand($this->vendingMachineRepository);
        $balance = $balanceCommand->execute($request->id);

        return response()->json([
            'balance' => $balance,
        ]);
    }

    public function add(AddBalanceRequest $request): JsonResponse
    {
        $addBalanceCommand = new AddBalanceCommand($this->vendingMachineRepository);
        $add = $addBalanceCommand->execute($request->id, $request->amount);

        if(!$add) {
            return $this->errorResponse();
        }

        return response()->json([
            'balance' => $add['balance'],
            'currency' => VendingMachine::PENCES,
        ]);
    }

    public function refund(Request $request): JsonResponse
    {
        $refundCommand = new RefundCommand($this->vendingMachineRepository);
        $refund = $refundCommand->execute($request->id);

        if(!$refund) {
            return $this->errorResponse();
        }

        return response()->json([
            'refund' => $refund['refund'],
            'currency' => VendingMachine::PENCES,
        ]);
    }

    public function products(Request $request): JsonResponse
    {
        $getProductsCommand = new GetProductsCommand($this->vendingMachineProductRepository);
        $products = $getProductsCommand->execute($request->id);

        if($products->isEmpty()) {
            return $this->errorResponse();
        }

        return response()->json([
            'products' => $products
        ]);
    }

    public function select(SelectProductRequest $request): JsonResponse
    {
        $selectProductCommand = new SelectProductCommand($this->vendingMachineRepository, $this->vendingMachineProductRepository);
        $selectProduct = $selectProductCommand->execute($request->id, $request->pence);

        if(!$selectProduct) {
            return $this->errorResponse();
        }

        return response()->json([
            'selected_product' => $selectProduct['selected_product'],
            'current_balance' => $selectProduct['balance'],
        ]);
    }

    private function errorResponse(): JsonResponse
    {
        return response()->json([
            'error' => 'Something wrong with vending machine, try again later.'
        ]);
    }
}
