<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestingController extends Controller
{
    public function index() {
        echo "Testing Oke";
    }

    public function test() {
        $qrydata = DB::select("SELECT t.* FROM mbs.dms_users t");
        dd($qrydata);
    }
}
