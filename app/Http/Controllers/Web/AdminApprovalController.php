<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Repositories\MemberRepository;
use App\Services\MemberService;
use Illuminate\Http\Request;

class AdminApprovalController extends Controller
{
    public function __construct(
        protected MemberRepository $memberRepo,
        protected MemberService $memberService
    ) {}

    public function index(Request $request)
    {
        $applicants = $this->memberRepo->getPendingPengurus();
        return view('admin.approvals.pengurus', compact('applicants'));
    }

    public function approve(int $id)
    {
        $member = $this->memberService->verifyPengurus($id, 'setujui', 'Disetujui via Admin Panel');
        return back()->with('success', "{$member->name} sekarang menjadi Pengurus.");
    }

    public function reject(int $id)
    {
        $member = $this->memberService->verifyPengurus($id, 'tolak', 'Ditolak via Admin Panel');
        return back()->with('error', "Pendaftaran {$member->name} ditolak.");
    }
}
