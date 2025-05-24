<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function updateProfile(Request $request) {
        $user = User::find($request->user_id);

        if(!$user) {
            return response()->json([
                'ok' => false,
                'message' => 'User not found'
            ]);
        }

        $fileName = null;
        if($request->hasFile('profile_image')) {
            $fileName = time() . '.' . $request->file('profile_image')->getClientOriginalExtension();
            $request->file('profile_image')->storeAs('public/images/profile', $fileName);
        }

        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->city = $request->city;
        $user->state = $request->state;
        $user->zip_code = $request->zip_code;
        $user->address = $request->address;
        $user->profile_image = $fileName ? '/images/profile/' . $fileName : $user->profile_image;
        $user->save();

        $user->profile_image = $user->profile_image ? asset('storage/' . $user->profile_image) : null;

        return response()->json([
            'ok' => true,
            'message' => 'Profile updated successfully',
            'user' => $user
        ]);
    }
}
