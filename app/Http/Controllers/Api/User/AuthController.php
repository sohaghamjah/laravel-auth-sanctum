<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\RegisterRequest;
use App\Http\Resources\User\AuthResource;
use Illuminate\Http\Request;
use App\Models\User; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(LoginRequest $request){
        $user = User::where('phone', $request->phone)->first();
 
        if (! $user || ! Hash::check($request->p`assword, $user->password)) {
            throw ValidationException::withMessages([
                'phone' => ['Phone or password dosen\' match.'],
            ]);
        }

        return $this->makeToken($user);
    
    }


    public function register(RegisterRequest $request){
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        return $this->makeToken($user);
    }


    public function makeToken($user){
        $token = $user->createToken('user-token')->plainTextToken;

        return AuthResource::make($user)->additional([
            'meta' => [
                'token'      => $token,
                'token_type' => 'Bearer',
            ]
        ]);
    }
}
