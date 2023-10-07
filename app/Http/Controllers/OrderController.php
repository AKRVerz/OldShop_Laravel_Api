<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function show($id)
    {
        $order = Order::with('items.product')->find($id);
        if (!$order) {
            return response()->json(['error' => 'Order not found.'], 404);
        }
        return response()->json($order);
    }

    public function createOrder(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::find($request->input('product_id'));

        if ($product->inventory < $request->input('quantity')) {
            return response()->json(['error' => 'Not enough stock.'], 400);
        }

        $order = new Order();
        $order->save();

        $orderItem = new OrderItem();
        $orderItem->product_id = $product->id;
        $orderItem->order_id = $order->id;
        $orderItem->quantity = $request->input('quantity');
        $orderItem->save();

        return response()->json(['message' => 'Order created successfully.', 'order_id' => $order->id], 201);
    }
}
