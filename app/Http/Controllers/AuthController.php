<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller as BaseController;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Validator;
use Hash;

class AuthController extends BaseController
{

 
     /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request){
       
        $input = $request->all();
        $field = 'email';
        $request->merge([$field => $request->input('email')]);
        
        if (! $token = Auth::attempt([$field => $request->input('email'), 'password' => $request->input('password')])) {
            return   $this->sendjwtError('Unauthorized','', 401); 
        }
        $data = auth()->user();
       
        $response = [
            'status' => 1,
            'access_token' => $token,
            'admin' => $data,
            'message' => 'Logged successfully.',
        ];
        return response()->json($response, 200);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request) {
        auth()->logout();
        return redirect(route('home_login'));
    }

   /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh() {
        return $this->createNewToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'users' => auth()->user()
        ]);
    }


 }
