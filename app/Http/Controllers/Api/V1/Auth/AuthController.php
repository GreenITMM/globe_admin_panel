<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Admin\StoreUserRequest;

class AuthController extends Controller
{
    public function register(StoreUserRequest $request) {
        DB::beginTransaction();
        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->password = Hash::make($request->password);
            $user->save();

            $token = $user->createToken('globe')->plainTextToken;

            $user->profile_image = $user->profile_image ? asset('storage/' . $user->profile_image) : null;

            $response = [
                'ok' => true,
                'user' => $user,
                'token' => $token,
            ];

            DB::commit();

            return response()->json($response, 201);
        } catch(\Exception $error) {
            logger($error);
            DB::rollBack();

            return response()->json(['message' => 'register error', 'error' => $error->getMessage()],400);
        }
    }

    public function login(LoginRequest $request) {
        $user = User::where('email', $request->input('email'))->first();

        if(!$user || !Hash::check($request->input('password'), $user->password)) {
            return response()->json(['ok' => false, 'message' => 'wrong credentials'], 401);
        }

        $token = $user->createToken('globe')->plainTextToken;

        $user->profile_image = $user->profile_image ? asset('storage/' . $user->profile_image) : null;


        // if($user) {
        //     $order = Order::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
        // }

        $response = [
            'ok' => true,
            'user' => $user,
            'token' => $token,
            // 'order' => $user ? OrderResource::collection($order->load('customer')) : null
        ];

        return response()->json($response, 201);
    }
}
