<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

/**
 * @group Auth endpoints
 */
class LoginController extends Controller
{
    
    /**
     * Login
     *
     * Handle a login request to the application.
     * 
     * @bodyParam username string required The username you use to log into this system. No-example
     * @bodyParam password string required The password you use to log into this system. No-example
     *
     * @response scenario="Successful Login" {
     * "success": true,
     * "message": "User Login Successfully",
     * "access_token": "token",
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

    /**
     * User Profile
     * 
     * This endpoint is used to get user profile
     * @authenticated
     */
    public function profile(){
        return response()->json([
            'name' => auth()->user()->name,
            'username' => auth()->user()->username,
            'email' => auth()->user()->email,
            'admin' => auth()->user()->is_admin == 1 ? true : false,
        ]);
    }

    /**
     * Regenerate Auth
     * 
     * This endpoint is used to regenerate auth
     * @authenticated
     */
    public function refresh(){
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Log out
     * 
     * Voluntatirly end access to the application
     * @authenticated
     * 
     * @response {
     * "message":"Successfully logged out"
     * }
     */
    public function logout(){
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
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
