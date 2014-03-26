<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('form');
});

Route::post('/', function(){
	//First define validation rules
	$rules = array(
		'link' => 'required|url'
	);

	//Run form validation
	$validation = Validator::make(Inpute::all(),$rules);

	//if Validation fails return to '/' with an error
	if($validation->fails()){
		return Redirect::to('/')->withInput()->withErrors($validation);
	} else {
		//Check if link already in DB
		$link = Link::where('url','=',Input::get('link'))->first();
		//If we have it return it
		if($link){
			return Redirect::to('/')->withInput()->with('link',$link->hash);
		} else {
			do {
				$newHash = Str::random(6);
			} while(Link::where('hash','=',$newHash)->count() > 0);
			Link::create(array(
				'url' => Input::get('link'),
				'hash' => $newHash
			));
			return Redirect::to('/')->withInput()->with('link', $newHash);
		}
	}
});