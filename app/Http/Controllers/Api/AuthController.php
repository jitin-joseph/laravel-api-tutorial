<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Auth;

class AuthController extends Controller
{
    public function login(Request $request)

    {

        // Validate the request

        $validator = Validator::make($request->all(), [

            'email'    => 'required|string|email|max:255',

            'password' => 'required|string|min:6',

        ]);

    

        // If validation fails, return a 422 Unprocessable Entity response

        if ($validator->fails()) {

            return response()->json([

                'status' => 422,

                'message' => trans('validation.validation_failed'),

                'errors' => $validator->errors(),

            ], 422);

        }

    

        // Attempt to log the user in

        if (Auth::attempt($request->only('email', 'password'))) {

            // Authentication passed

            $user = Auth::user();

            $token = $user->createToken('auth_token')->plainTextToken; // Assuming you use Laravel Sanctum for token management

    

            return response()->json([

                'status' => 200,

                'message' => trans('validation.login_successful'),

                'data' => [

                    'user' => [

                        'id' => $user->id,

                        'name' => $user->name,

                        'email' => $user->email,

                        'created_at' => $user->created_at,

                    ],

                    'token' => $token,

                    'token_type'    => 'Bearer'

                ],

            ], 200);

        }

    

        // Authentication failed

        return response()->json([

            'status' => 401,

            'message' => trans('validation.invalid_credentials'),

            'error' => trans('validation.unauthorized'),

        ], 401);

    }

    

    public function logout(){

    }
}
