<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\MemberLoginRequest;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(MemberLoginRequest $request)
    {
        $credentials = $request->validated();

        $member = Member::where('nik', $credentials['nik'])->first();


        if (!$member || !Hash::check($request->password, $member->password)) {
            return back()->withErrors(['nik' => 'NIK atau Kata Sandi salah.']);
        }

        // Check if role matches
        if ($member->role !== $request->role) {
            return back()->withErrors(['role' => "Anda tidak terdaftar sebagai " . ucfirst($request->role)]);
        }

        Auth::guard('member')->login($member, $request->remember);
        $token = $member->createToken('member-token')->plainTextToken;

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => [
                    'token' => $token,
                    'user' => $member,
                    'redirect' => $member->role === 'pengurus' ? '/pengurus/dashboard' : '/member/profile'
                ]
            ]);
        }

        if ($member->role === 'pengurus') {
            return redirect()->intended('/pengurus/dashboard');
        }

        return redirect()->intended('/member/profile');
    }

    public function logout()
    {
        Auth::guard('member')->logout();
        return redirect()->route('login');
    }
}
