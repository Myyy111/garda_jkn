<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePengurusApplicationRequest;
use App\Services\MemberService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    public function __construct(protected MemberService $memberService) {}

    public function profile()
    {
        $member = Auth::guard('member')->user();
        return view('member.profile', compact('member'));
    }

    public function applyPengurus()
    {
        $member = Auth::guard('member')->user();
        
        if ($member->status_pengurus !== 'tidak_mendaftar') {
            return redirect()->route('member.profile')->with('info', 'Anda sudah atau sedang dalam proses pendaftaran pengurus.');
        }

        return view('member.apply_pengurus', compact('member'));
    }

    public function storePengurusApplication(StorePengurusApplicationRequest $request)
    {
        $member = Auth::guard('member')->user();

        if (!$request->input('is_interested')) {
            return redirect()->route('member.profile');
        }

        $data = $request->validated();
        if ($request->hasFile('org_certificate')) {
            $data['org_certificate'] = $request->file('org_certificate');
        }

        $this->memberService->applyForPengurus($member, $data);

        return redirect()->route('member.profile')->with('success', 'Permohonan pengurus berhasil dikirim. Menunggu persetujuan admin.');
    }

    public function informations()
    {
        return view('member.informations.index');
    }
}
