<?php namespace App\Http\Controllers;

use App\Downtime;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use Auth;
use DB;
use Mail;
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
        $i = compact('input');

        // email users about downtime
        $emails = DB::table('users')->lists('email');
        Mail::send('emails.downtime', ['start' => $input['start_time'], 'end' => $input['end_time']], function($message) use ($emails)
        {
            $message->to($emails)->subject('Server Maintenance');
        });

        // redirect user to home page
        flash()->success("Downtime scheduled.");
        return redirect('/home');
    }
}
