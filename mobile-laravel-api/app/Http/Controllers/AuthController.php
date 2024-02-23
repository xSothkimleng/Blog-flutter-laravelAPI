<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use HttpResponses;
    public function List(){
        $user = User::with('personal')->get();
        return response()->json($user);
    }

    public function login(LoginUserRequest $request){
        $request->validated($request->only(['username','password']));

        if(!Auth::attempt($request->only(['username', 'password']))) {
            return $this->error('', 'Credentials is in Valid', 401);
        }

        $user = User::where('username', $request->username)->first();
        // $user = User::with('personal.department')->where('username', $request->username)->first();

        return $this->success([
            'user' => $user,
            'token' => $user->createToken('API Token')->plainTextToken
        ], "User successfully login", 200);
    }

    public function register(StoreUserRequest $request){
        $validatedData = $request->validated();

        $user = User::create([
            'email' => $validatedData['email'],
            'username' => $validatedData['username'],
            'password' => Hash::make($request->password),  
        ]);

        return $this->success([ "Account" => $user,]);
    }

    public function update(Request $request, $id){
        $personal = User::findOrFail($id);
        $personal->update($request->all());
        return new UserResource($personal);
    }

    public function logout(){
        Auth::user()->currentAccessToken()->delete(); // currentAccessToken() is not recognize by intelephense
        return $this->success([
            'message' => 'successfully logout' 
        ]);
    }
    
}