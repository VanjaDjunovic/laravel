<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $email = $request->query('email', '');
        $page = intval($request->query('page', 1));
        $size = intval($request->query('size', 20));
        $orders =  Order::where('email', 'like', '%' . $email . '%')->paginate($size, ['*'], 'page', $page);
        return response()->json(new OrderCollection($orders));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $order = Order::create([
            "address" => $data['address'],
            "email" => $data['email'],
            "phone" => $data['phone'],
            "name" => $data['name'],
            "delivered" => 0,
        ]);
        foreach ($data['items'] as $item) {
            $product = Product::find($item['productId']);
            OrderItem::create([
                'count' => $item['count'],
                'unit_price' => $product['price'],
                'product_id' => $item['productId'],
                'order_id' => $order->id
            ]);
        }

        return response()->json(new OrderResource(Order::find($order->id)));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::find($id);
        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }
        return response()->json(new OrderResource($order));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $order = Order::find($id);
        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        $order->update($request->all());
        return response()->json(new OrderResource($order));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::find($id);
        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }
        $order->delete();
        return response()->noContent();
    }
}
