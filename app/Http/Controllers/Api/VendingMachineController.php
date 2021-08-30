<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddBalanceRequest;
use App\Http\Requests\SelectProductRequest;
use App\Models\VendingMachine;
use App\Models\VendingMachineProduct;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VendingMachineController extends Controller
{
    private const ZERO_BALANCE = 0;

    public function balance(Request $request): JsonResponse
    {
        $vendingMachine = $this->getVendingMachine($request->id);

        return response()->json([
            'balance' => $vendingMachine->balance,
        ]);
    }

    public function add(AddBalanceRequest $request): JsonResponse
    {
        $vendingMachine = $this->getVendingMachine($request->id);

        $newBalance = $vendingMachine->balance + $request->amount;

        $update = $this->updateBalance($vendingMachine, $newBalance);

        if(!$update) {
            return $this->errorResponse();
        }

        return response()->json([
            'balance' => $newBalance,
            'currency' => VendingMachine::PENCES,
        ]);
    }

    public function refund(Request $request): JsonResponse
    {
        $vendingMachine = $this->getVendingMachine($request->id);

        $balance = $vendingMachine->balance;

        $update = $this->updateBalance($vendingMachine, self::ZERO_BALANCE);

        if(!$update) {
            return $this->errorResponse();
        }

        return response()->json([
            'refund' => $balance,
            'currency' => VendingMachine::PENCES,
        ]);
    }

    public function products(Request $request): JsonResponse
    {
        $products = VendingMachineProduct::where('vending_machine_id', $request->id)->oldest('price_in_pences')->get(['name', 'price_in_pences']);

        if($products->isEmpty()) {
            return $this->errorResponse();
        }

        return response()->json([
            'products' => $products
        ]);
    }

    public function select(SelectProductRequest $request): JsonResponse
    {
        $pences = $request->pence;

        $vendingMachine = $this->getVendingMachine($request->id);
        $product = VendingMachineProduct::where('price_in_pences', $pences)->firstOrFail();

        if(!$this->haveEnoughBalance($vendingMachine->balance, $product->price_in_pences)) {
            return response()->json([
                'error' => 'Your balance is lower than product price, insert the money and try again.'
            ]);
        }

        $newBalance = $vendingMachine->balance - $product->price_in_pences;

        $update = $this->updateBalance($vendingMachine, $newBalance);

        if(!$update) {
            return $this->errorResponse();
        }

        return response()->json([
            'selected_product' => $product->name,
            'current_balance' => $newBalance,
        ]);
    }

    private function getVendingMachine(int $id): VendingMachine
    {
        return VendingMachine::findOrFail($id);
    }

    private function updateBalance(VendingMachine $vendingMachine, int $newBalance): bool
    {
        return $vendingMachine->update(['balance' => $newBalance]);
    }

    private function errorResponse(): JsonResponse
    {
        return response()->json([
            'error' => 'Something wrong with vending machine, try again later.'
        ]);
    }

    private function haveEnoughBalance(int $balance, int $productPrice): bool
    {
        return $balance >= $productPrice;
    }
}
