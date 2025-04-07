<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dashboard;
use App\Helpers\Helper;

class DashbaordController extends Controller
{
    public function index(Request $request)
    {
        $dashboard=Dashboard::find(1);
        return Helper::Response(true,'Get Dashbaord Vedio url.',$dashboard ,false);
    }
}
