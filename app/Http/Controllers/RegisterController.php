<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{

    /**
     * Register new User
     *
     * This endpoint used to register new user.
     * @bodyParam name string required The full name of the user. No-example
     * @bodyParam username string The username for access API. Example: tes_user
     * @bodyParam email string The email of the user. Example: tes@***.com
     * @bodyParam password string The password for access API. No-example
     * @bodyParam password_confirmation string Must match with password parameter. No-example
     */
    public function register(Request $request){
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'username' => 'required|string|min:4|max:255|unique:users,username',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|min:5|max:70|confirmed'
        ]);

        $model = new User;
        $model->name = $request->input('name');
        $model->username = $request->input('username');
        $model->email = $request->input('email');
        $model->password = Hash::make($request->input('password'));
        $model->is_admin = false;

        $save = $model->save();

        if($save){

            return response()->json([
                'success' => true,
                'message' => 'Registerasi berhasil, silahkan login'
            ], 200);

        }else{
            
            return response()->json([
                'success' => false,
                'message' => 'Registerasi gagal, coba sekali lagi'
            ], 400);

        }

    }
}
