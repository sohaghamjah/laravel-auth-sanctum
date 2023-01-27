<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\LoginRequest;
use App\Http\Resources\Admin\AuthResource;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(LoginRequest $request){
        $admin = Admin::where('phone', $request->phone)->first();
 
        if (! $admin || ! Hash::check($request->password, $admin->password)) {
            throw ValidationException::withMessages([
                'phone' => ['Phone or password dosen\' match.'],
            ]);
        }

        return $this->makeToken($admin);
    }

    public function logout(Request $request){
        $request->user()->tokens()->delete();   

        return sendSuccessResponse(false, 'Admin Logout', 200);
    }


    public function user(Request $request){
        return AuthResource::make($request->user());
    }


    public function makeToken($admin){
        $token = $admin->createToken('user-token')->plainTextToken;

        return AuthResource::make($admin)->additional([
            'meta' => [
                'token'      => $token,
                'token_type' => 'Bearer',
            ]
        ]);
    }
}
