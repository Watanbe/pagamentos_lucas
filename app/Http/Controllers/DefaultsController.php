<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\LoanModality;
use App\Models\MaritalStatus;
use App\Models\State;
use Illuminate\Http\Request;

class DefaultsController extends Controller {

    public function __construct()
    {
    }

    public function getStates() {
        $states = State::get();
        return response()->json($states);
    }

    public function getCitiesByState($id) {
        $cities = City::where("state_id", $id)->get();

        return response()->json($cities);
    }

    public function maritalStatus() {
        $maritalStatus = MaritalStatus::get();
        return response()->json($maritalStatus);
    }

    public function loanModality() {
        $loanModalities = LoanModality::get();
        return response()->json($loanModalities);
    }

}
