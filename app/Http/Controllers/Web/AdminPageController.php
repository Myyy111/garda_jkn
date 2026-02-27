<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminPageController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function members()
    {
        return view('admin.members.index');
    }

    public function auditLogs()
    {
        return view('admin.audit_logs.index');
    }

    public function informations()
    {
        return view('admin.informations.index');
    }
}
