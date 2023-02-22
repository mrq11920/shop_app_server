<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Http\Resources\SmallCategoryResource;
use App\Models\SmallCategory;
use Illuminate\Http\Request;

class SmallCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($largeCategoryId)
    {
        $smallCategories = SmallCategory::where('large_category_id', $largeCategoryId)->get();
        return SmallCategoryResource::collection($smallCategories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($largeCategoryId ,Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($largeCategoryId, $id)
    {
        $smallCategory = SmallCategory::where('large_category_id', $largeCategoryId)
            ->where('id', $id)->firstOrFail();
        return new SmallCategoryResource($smallCategory);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($largeCategoryId, Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($largeCategoryId, $id)
    {
        //
    }
}
