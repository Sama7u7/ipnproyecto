<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function show()
    {
        $deshidratadores = DB::table('deshidratadores')->get();
        $germinadores = DB::table('germinadores')->get();
        return view('admin.dashboard', compact('deshidratadores','germinadores'));
    }
}