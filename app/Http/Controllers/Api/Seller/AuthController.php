<?php

namespace App\Http\Controllers\Api\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Seller\LoginRequest;
use App\Http\Resources\Seller\AuthResource;
use App\Models\Seller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(LoginRequest $request){
        $seller = Seller::where('phone', $request->phone)->first();
 
        if (! $seller || ! Hash::check($request->password, $seller->password)) {
            throw ValidationException::withMessages([
                'phone' => ['Phone or password dosen\' match.'],
            ]);
        }

        return $this->makeToken($seller);
    }

    public function logout(Request $request){
        $request->user()->tokens()->delete();   

        return sendSuccessResponse(false, 'Seller Logout', 200);
    }


    public function user(Request $request){
        return AuthResource::make($request->user());
    }


    public function makeToken($seller){
        $token = $seller->createToken('seller-token')->plainTextToken;

        return AuthResource::make($seller)->additional([
            'meta' => [
                'token'      => $token,
                'token_type' => 'Bearer',
            ]
        ]);
    }
}
