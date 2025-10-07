<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use Guiliredu\BrazilianCityMigrationSeed\Models\State;

class StatesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function lists()
    {
        return State::all(['id', 'title']);
    }
}
