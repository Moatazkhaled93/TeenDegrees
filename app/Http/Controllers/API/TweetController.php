<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Tweet;
use Illuminate\Support\Facades\Auth;
use Validator;

class TweetController extends BaseController
{

    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'detiles' => 'required|max:140',
            'language' => 'required'
        ]);
        if($validator->fails()){

            return $this->sendError('Validation Error.', $validator->errors());       
        }
        $user = auth()->user();
        $input['user_id'] = $user->id;
        $newTweet = Tweet::create($input);

        return $this->sendResponse($newTweet->toArray(), 'Tweet created successfully.');
    }

    public function index()
    {
        $Tweet = Auth::user()->Tweets;
        if (is_null($Tweet)) {

            return $this->sendError('Tweets not found.');
        }

        return $this->sendResponse($Tweet, 'Tweet retrieved successfully.');
    }
       
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, Tweet $Tweet)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'detiles' => 'required|max:140',
            'language' => 'required'
        ]);

        if($validator->fails()){

            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $Tweet->detiles = $input['detiles'];
        $Tweet->language = $input['language'];
        $Tweet->save();

        return $this->sendResponse($Tweet, 'Tweet updated successfully.');
    }
       
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy(Tweet $Tweet)
    {
        $Tweet->delete();

        return $this->sendResponse($Tweet, 'Product deleted successfully.');
    }
}
