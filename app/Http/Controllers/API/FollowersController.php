<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;

class FollowersController extends BaseController
{ 

    public function store(Request $request)
    {
        $input = $request->all();
        $userFollower = User::find($input['follower_id']);
        if(!$userFollower) {
            return $this->sendError('User does not exist.', NULL);       
        }
        
        $userFollower->followers()->attach(auth()->user()->id);
        return $this->sendResponse($userFollower->followers(), 'Successfully followed the user.');
    }
}
