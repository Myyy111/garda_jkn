<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PengurusPageController extends Controller
{
    public function dashboard()
    {
        return view('pengurus.dashboard');
    }

    public function informations()
    {
        return view('pengurus.informations.index');
    }
}
