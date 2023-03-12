<?php

namespace App\Http\Controllers\APIs;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'guest', 'logout']]);
    }

    public function register(Request $request)
    {
        // Validate request data
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6'],
            'full_name' => ['sometimes', 'string'],
        ]);
        // Return errors if validation error occur.
        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json([
                'error' => $errors
            ], 400);
        }
        DB::beginTransaction();
        try {
            $user = User::create([
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);
            UserProfile::create(['user_id' => $user->id, 'full_name' => $request->full_name ?? 'user' . hash('crc32', $user->id),]);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }


        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'data' => [
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => new UserResource($user->load('profile', 'addresses')),
            ]
        ]);
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid login details'
            ], 401);
        }
        $user = User::where('email', $request['email'])->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'data' => [
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => new UserResource($user->load('profile', 'addresses')),
            ]
        ]);
    }

    public function completeProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => ['required'],
            'phone_number' => ['required'],
            'address' => ['required'],
        ]);
        // Return errors if validation error occur.
        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json([
                'error' => $errors
            ], 400);
        }
        $request->user()->fill([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone_number' => $request->phone_number,
            'address' => $request->address,
        ])->save();
    }

    public function logout(Request $request) 
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json();
    }
}
