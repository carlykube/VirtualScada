<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Request;

class SystemController extends Controller {

	public function scheduleDownTime()
    {
        dd(Request::all());
    }
}
