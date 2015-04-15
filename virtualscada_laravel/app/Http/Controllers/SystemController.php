<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Request;

/**
 * Controller for all system based tasks
 *
 * Class SystemController
 * @package App\Http\Controllers
 */
class SystemController extends Controller {

    /**
     * Schedules the downtime for the server
     *
     */
    public function scheduleDownTime()
    {
        dd(Request::all());
    }
}
