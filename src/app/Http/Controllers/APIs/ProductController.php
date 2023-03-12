<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
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
        // GET: api/products?keyword=buoi&large_category[]=19&small_category[]=1&provice_id[]=1
        $query = Product::query();
        if ($request->has('large_category_id')) {
            $query = $query->where('large_category_id', $request->large_category_id);
        }
        if($request->has('keyword')) {
            $query = $query->where('name', 'like', '%'. $request->keyword. '%');
        }
        $query = $query->where('status', config('product.status.approved'))
            ->orderBy('created_at', 'desc');
        $products = $query->with(['images', 'province', 'smallCategory'])->paginate(4);
        return ProductResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new ProductResource(Product::findOrFail($id)->load('images', 'province', 'smallCategory'));
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
        //
    }
}
