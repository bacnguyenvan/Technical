<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class InventoryController extends Controller
{
    public function handle()
    {
        \Log::info(request()->header('user-agent'));
        
        $productId = 1;

        $inventory = Inventory::where('product_id', $productId)->first();
        $quantity = $inventory->quantity;
        
        if($quantity <= 0) {
            throw ValidationException::withMessages([
                'Product out sell!',
            ]);
        }

        $inventory->update(['quantity' => $quantity - 1]);
        return "order success";
    }
}
