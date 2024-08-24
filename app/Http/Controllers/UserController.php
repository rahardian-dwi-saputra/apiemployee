<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\UserResource;

/**
 * @group User Management
 *
 * API to manage the user resource.
 */
class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        if (Gate::denies('isAdmin')){
            return response()->json([
                'success' => false,
                'message' => 'You must be an administrator'
            ], 403); 
        }
    }

    /**
     * View all users
     *
     * This endpoint is used to fetch all employees available in the database.
     * @authenticated
     */
    public function index(){
        $users = User::where('is_admin', '=', false);
        if(User::count() == 0){
            return response()->json([
                'success' => false,
                'message' => 'Data User masih kosong' 
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => UserResource::collection(User::all())
        ], 200);
    }

    /**
     * Get a Single User
     *
     * This endpoint is used to return a single users from the database.
     * @authenticated
     * @urlParam id string required The ID of the user. Example: 1
     */
    public function show($id){
        $user = User::find($id);

        if(!$user){
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan' 
            ], 404); 
        }
        return response()->json([
            'success' => true,
            'data' => new UserResource($user)
        ], 200);  
    }

    /**
     * Delete a user
     *
     * This endpoint lets you delete a user.
     * @authenticated
     * @urlParam id required The id of the user. Example: 1
     * 
     * @response {
     *  "success": true,
     *  "message": "Data berhasil dihapus",
     * }
     */
    public function destroy($id){
        $user = User::find($id);

        if(!$user){
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan' 
            ], 404); 
        }

        if (in_array($user->username, array('admin','guest'))){
            return response()->json([
                'success' => false,
                'message' => 'Data tidak dapat dihapus' 
            ], 400);
        }

        $user->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data berhasil dihapus'
        ], 200); 

    }
}
