<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\LargeCategory;
use App\Models\Product;
use App\Models\Province;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $largeCategories = LargeCategory::all();
        $provinces = Province::all();
        $products = [];
        $user = $request->user();
        $query = Product::query();
        $query = $query->orderBy('created_at', 'desc')->with(['largeCategory']);
        if($user->isMerchant()) {
            $query = $query->where('merchant_id', $user->id);
        }
        $products = $query->paginate(4);
        
        return view('product.index', [
            'products' => $products,
            'largeCategories' => $largeCategories,
            'user' => $user,
            'provinces' => $provinces,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = Product::create([
            'name' => $request->name,
            'merchant_id' => $request->user()->id,
            'small_category_id' => $request->large_category_id,
            'large_category_id' => $request->large_category_id,
            'description' => $request->description,
            'unit_type' => $request->unit_type,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'province_id' => $request->province_id,
            'status' => config('product.status.pending'),
        ]);
        $path = '';
        if ($request->hasFile('image')) {
            $path = $request->image->store('images');
            $image = Image::create([
                'url' => $path,
                'imageable_id' => $product->id,
                'imageable_type' => Product::class,
            ]);
        }
        
        return redirect()->back()->with("success", "Data has been saved successfully!");
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
        $params = $request->only('status');
        if ($request->user()->isAdmin()) {
            Product::where('id', $id)->update($params);
            return redirect()->back()->with("success", "Product has been updated successfully!");
        }
        return redirect()->back();
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
