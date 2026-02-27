<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminLoginRequest;
use App\Models\AdminUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.admin_login');
    }

    public function login(AdminLoginRequest $request)
    {
        $credentials = $request->validated();

        $admin = AdminUser::where('username', $credentials['username'])->first();

        if (!$admin || !Hash::check($request->password, $admin->password)) {
            return back()->withErrors(['username' => 'Username atau Password salah.']);
        }

        Auth::guard('admin')->login($admin, $request->remember);
        $token = $admin->createToken('admin-token')->plainTextToken;

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => [
                    'token' => $token,
                    'user' => $admin,
                    'redirect' => '/admin/dashboard'
                ]
            ]);
        }

        return redirect()->intended('/admin/dashboard');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
