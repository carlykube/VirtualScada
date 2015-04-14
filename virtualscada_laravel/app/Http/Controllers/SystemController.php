<?php namespace App\Http\Controllers;

use App\Downtime;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use Request;

class SystemController extends Controller {

	public function scheduleDownTime()
    {
        // get start and end time from user
        $input = Request::all();

        // add other fields for downtime table
        $input['user_id'] = Auth::id();

        // store downtime in database
        Downtime::create($input);

        // redirect user to home page
        flash()->success("Downtime scheduled.");
        return redirect('/home');
    }
}
