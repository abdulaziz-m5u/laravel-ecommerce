<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\BaseController;

class UserController extends BaseController
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string']
        ]);

        if($validator->fails()){
            return $this->responseError('Login Failed !', 422, $validator->errors());
        }

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = auth()->user();

            $response = [
                'token' => $user->createToken('MyToken')->accessToken,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
            ];
    
            return $this->responseOk($response);

        }else {
            return $this->responseError('wrong email or password !', 401);
        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return $this->responseError('Registration failed', 422, $validator->errors());
        }

        $params = [
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ];

        if (!$user = User::create($params)) {
            return $this->responseError('Registration failed', 400);
        } 

        $token = $user->createToken('MyToken')->accessToken;

        $response = [
            'token' => $token,
            'user' => $user,
        ];

        return $this->responseOk($response);
    }

    public function getProfile(Request $request)
    {
        return $this->responseOk($request->user());
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return $this->responseOk(null, 200, 'Logged out successfully.');
    }
}
