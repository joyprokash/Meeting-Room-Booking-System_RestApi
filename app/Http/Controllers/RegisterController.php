<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use App\User;

class RegisterController extends Controller
{
    public function index(StoreUserRequest $request){
    
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            if($user->save()){
                $response = ['MSG' => 'data saved successfully'];
            }else{
                $response = ['MSG' => 'error'];
            }
            return response()->json($response);
    }
}
