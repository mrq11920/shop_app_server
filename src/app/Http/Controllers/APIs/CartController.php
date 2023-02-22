<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCartRequest;
use App\Http\Resources\CartResource;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\ShoppingSession;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $userId = $request->user()->id;
        $cart = ShoppingSession::firstOrCreate([
            'user_id' => $userId,
            'valid' => true,
        ],[
            'user_id' => $userId,
            'total' => 0,
            'valid' => true,
        ]);
        return new CartResource($cart->load('cartItems'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCartRequest $request)
    {
        $userId = $request->user()->id;
        $product = Product::findOrFail($request->product_id);
        $productQuantity = $request->quantity;
        if ($productQuantity == 0) return response()->json();
        // get shopping session if not found create a new shopping_session
        DB::beginTransaction();
        try {
            $shoppingSession = ShoppingSession::firstOrCreate([
                'user_id' => $userId,
                'valid' => true,
            ],[
                'user_id' => $userId,
                'total' => 0,
                'valid' => true,
            ]);
         
            // check if item is already in cart, if not then create a new cart item
            $cartItem = CartItem::where('shopping_session_id', $shoppingSession->id)
                ->where('product_id', $product->id)->first();
            if (empty($cartItem)) {
                $cartItem = CartItem::create([
                    'shopping_session_id' => $shoppingSession->id,
                    'product_id' => $product->id,
                    'quantity' => $productQuantity,
                ]);
            } else {
                // update quantity of cart item
                // if total quantity is equal zero then delete that cart item
                $quantity = $cartItem->quantity + $productQuantity;
                if ($quantity <= 0) {
                    $cartItem->delete();
                } else{
                    $cartItem->fill([
                        'quantity' => $quantity,
                    ])->save();
                }
            }
    
            $total = $shoppingSession->total + $product->price * $productQuantity;
            // update shopping session
            $shoppingSession->fill([
                'total' => $total > 0 ? $total : 0,
            ])->save();
            DB::commit();

            return new CartResource($shoppingSession->load('cartItems'));
        } catch(Throwable $e) {
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
    }
}
