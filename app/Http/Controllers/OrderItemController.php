<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class OrderItemController extends Controller
{
    public function store(Request $request)
    {
        try {
            $orderItem = new OrderItem();
            $orderItem->order_id = $request->input('order_id');
            $orderItem->product_id = $request->input('product_id');
            $orderItem->quantity = $request->input('quantity', 1); // Default quantity is 1
            $orderItem->save();

            return response()->json($orderItem, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create order item: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $orderItem = OrderItem::findOrFail($id);
            $orderItem->quantity = $request->input('quantity');
            $orderItem->save();

            return response()->json($orderItem);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Order item not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update order item: ' . $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $orderItem = OrderItem::findOrFail($id);
            $orderItem->delete();

            return response()->json(['message' => 'Order item deleted successfully']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Order item not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete order item: ' . $e->getMessage()], 500);
        }
    }
}
