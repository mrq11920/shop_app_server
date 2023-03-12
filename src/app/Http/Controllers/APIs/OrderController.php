<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\ShoppingSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $userId = $request->user()->id;
        $orders = Order::where('user_id', $userId)->get();
        return OrderResource::collection($orders->load([
            'shoppingSession', 
            'shoppingSession.cartItems',
            'shoppingSession.cartItems.product', 
            'shoppingSession.cartItems.product.images',
            'userAddress']
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrderRequest $request)
    {
        $shoppingSessionId = $request->shopping_session_id;
        DB::beginTransaction();
        try {
            $order = Order::create([
                'status' => Order::OPEN,
                'shopping_session_id' => $shoppingSessionId,
                'user_id' => $request->user()->id,
                'total_discount' => 0,
                'user_address_id' => $request->user_address_id,
            ]);

            // update product quantity 
            $shoppingSession = ShoppingSession::find($shoppingSessionId);
            foreach($shoppingSession->cartItems as $cartItem) {
                $product = $cartItem->product;
                if ($product->quantity < $cartItem->quantity) {
                    abort(400, 'Invalid order item');
                }
                $product->fill(['quantity' => $product->quantity - $cartItem->quantity])->save();
            }
    
            // update current cart to invalid 
            ShoppingSession::where('id', $shoppingSessionId)->update(['valid' => false]);
            DB::commit();

            return new OrderResource($order->load('shoppingSession', 'userAddress'));

        } catch(Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new OrderResource(Order::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrderRequest $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->fill(['status' => $request->status])->save();

        return new OrderResource($order);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
