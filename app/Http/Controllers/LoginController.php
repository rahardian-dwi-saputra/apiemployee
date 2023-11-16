<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    
    /**
     * Login
     *
     * This endpoint is used to login a user to the system.
     * 
     * @bodyParam username string required The username you use to log into this system. No-example
     * @bodyParam password string required The password you use to log into this system. No-example
     *
     * @response scenario="Successful Login" {
     * "success": true,
     * "message": "User Login Successfully",
     * "access_token": "MgowQLkdpShwrb8AI9j1YAGmwnDjAOeE17XrP5nb",
     * "token_type": "bearer",
     * "expires_in": 86400
     * }
     *
     * @response 401 scenario="Failed Login"{
     * "success": false,
     * "message": "Invalid login credentials"
     * }
     *
     */
    public function authenticate(Request $request){
        $this->validate($request, [
          'username' => 'required',
          'password' => 'required'
        ]);

        $credentials = $request->only(['username', 'password']);

        if(!$token = Auth::attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid login credentials'
            ], 401);
        }

        return $this->respondWithToken($token);
    }

    public function me(){
        return response()->json(auth()->user());
    }

    public function logout(){
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh(){
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken($token){
        return response()->json([
            'success' => true,
            'message' => 'User Login Successfully',
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL()*60*24
        ]);
    }
}
