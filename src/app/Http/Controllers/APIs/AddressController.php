<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAddressRequest;
use App\Http\Requests\UpdateAddressRequest;
use App\Http\Resources\AddressResource;
use App\Http\Resources\UserAddressResource;
use App\Models\UserAddress;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $addresses = $request->user()->addresses;
        return AddressResource::collection($addresses->load('province'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAddressRequest $request)
    {
        $address = UserAddress::create([
            'user_id' => $request->user()->id,
            'name' => $request->name,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'province_id' => $request->province_id,
        ]);
        return new UserAddressResource($address);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new UserAddressResource(UserAddress::findOrFail($id)->load('province'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAddressRequest $request, $id)
    {
        $info = $request->only(['province_id', 'address', 'name', 'phone_number']);

        $userAddress = UserAddress::findOrFail($id);
        $userAddress->fill($info)->save();

        return new UserAddressResource($userAddress);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        UserAddress::findOrFail($id)->delete();
        return response()->json([], 200);
    }
}
