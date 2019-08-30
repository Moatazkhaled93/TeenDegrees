<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;

class UserController extends BaseController

{
     /**
    * login api
    *
    * @return \Illuminate\Http\Response
    */
   public function login(){
    if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
        $user = Auth::user();
        $success['token'] =  $user->createToken('MyApp')->accessToken;
        return $this->sendResponse( $success,'User login successfully.');
    }
    else{
        return $this->sendError('Unauthorised',NULL, 401);
    }
}
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'picture' => 'image|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if($validator->fails()){

            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $input['picture'] = time().'.'.$request->picture->getClientOriginalExtension();
        $request->picture->move(public_path('profilePicture'), $input['picture']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $success['name'] =  $user->name;

        return $this->sendResponse($success, 'User register successfully.');
    }

}
