<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FlashSaleController extends Controller
{
    public function startFlashSale(Request $request, $productId)
    {
        //Melakukan pemeriksaan apakah Id dari product terdapat pada sistem
        $product = Product::find($productId);
        if (!$product) {
            return response()->json(['error' => 'Product not found.'], 404);
        }

        if ($product->inventory <= 0) {
            return response()->json(['error' => 'Product out of stock.'], 400);
        }

        //Melakukan Transaksi
        return DB::transaction(function () use ($product) {
            //Setial kali transaksi terjadi data pada inventory
            //produk akan selalu berkurang
            $product->inventory--;
            $product->save();

            //Setiap kali transaksi terjadi akan terjadi proses order
            $order = new Order();
            $order->save();

            $orderItem = new OrderItem();
            $orderItem->product_id = $product->id;
            $orderItem->order_id = $order->id;
            $orderItem->save();

            return response()->json(['message' => 'Flash sale successful.', 'order_id' => $order->id], 200);
        }, 5); 
    }
}
