<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportarController extends Controller
{
    public function index(){
        return view('reportar.reportar');
    }
}
