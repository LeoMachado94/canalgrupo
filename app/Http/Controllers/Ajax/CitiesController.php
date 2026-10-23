<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\City;

class CitiesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function lists($stateId = null)
    {
        if (!empty($stateId)) {
            return City::where('state_id', $stateId)->get(['id', 'title']);
        }
        return City::all(['id', 'title']);
    }
}
