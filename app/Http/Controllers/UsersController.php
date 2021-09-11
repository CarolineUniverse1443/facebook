<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\User;


class UsersController extends Controller
{
    // 
    public function getUsers()
    {
    	return response()->json(User::get());
    }

    public function signUp(Request $req)
    {
    	$validator = Validator::make($req->all(), [
    		'name' => 'required',
    		'surname' => 'required',
    		'login' => 'required|unique:users',
    		'password' => 'required',
    		'api_token' => 'nullable',
    	]);

    	if($validator->fails())
    		return response()->json($validator->errors());

    	User::create($req->all());
    	return response()->json("You have registered");
    }

    public function signIn(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'login' => 'required|exists:users,login',
            'password' => 'required|exists:users,password',
        ]);
 
        $user = User::where("login",$req->login)->first();

        if($validator->fails())
        {
            if(!$user || $req->password != $user->password)
                return respoonse()->json("Login or password is invalid");
            return response()->json($validator->errors());
        }

        $user->api_token = Str::random(50);
        $user->save();
        return response()->json($user->name.", you logged in! api_token: ".$user->api_token);
    }

    public function logOut(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'api_token' => 'required|exists:users,api_token',
        ]);

        $user = User::where('api_token',$req->api_token)->first();

        if($validator->fails())
            return response()->json($validator->errors());

        $user->api_token = null;
        $user->save();
        return response()->json($user->name.", you logged out. See you later!");
    }

    public function addUser(Request $req)
    {
        User::create($req->all());
        return response()->json("User was added");
    }

    public function editProfile(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'id' => 'required|exists:users, id',
        ]);

        $user = User::where("id", $req->all())->first();

        if(!$user || $user->api_token == null)
            return response()->json("User not found");

        $user->update($req->all());
        return response()->json("Changes saved");
    }

    public function deleteUser(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'id' => 'required|exists:users, id',
        ]);

        $user = User::where("id", $req->all())->first();

        if(!$user || $user->api_token == null)
            return response()->json("User not found");

        $user->delete();
        return response()->json("User was deleted");        
    }

    
}
