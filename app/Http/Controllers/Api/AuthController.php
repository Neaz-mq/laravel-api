<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Create User
     * @param Request $request
     * @return User
     */

     public function createUser(Request $request)
     {
        try {

        //validated

        $validateUser = Validator::make($request->all(),
        [

            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required'

        ]);

        if($validateUser->fails()){

            return response()->json([

                'status' => false,
                'message' => 'validation error',
                'errors' => $validateUser->errors()

            ], 401);
        }

        $user = User::create([

            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)

        ]);
     }
     catch(\Throwable $th){
        return response()->json([

            'status' => false,
            'message' => $th->getMessage()
            

        ], 500);

     }
}
}
