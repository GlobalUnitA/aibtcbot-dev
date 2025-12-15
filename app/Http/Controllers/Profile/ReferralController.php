<?php

namespace App\Http\Controllers\Profile;

use App\Models\Member;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReferralController extends Controller
{
    public function __construct()
    {

    }

    public function index($id)
    {
        $member = Member::find($id);
        $referrals = $member->referrals;

        $auth_member = auth()->user()->member;
        $target_member_id = (int) $id;
        $level = $this->findReferralDepth($auth_member, $target_member_id);

        return view('profile.referral', compact('referrals', 'level'));
    }

    private function findReferralDepth($member, $target_member_id, $depth = 1)
    {
        if ($member->id === $target_member_id) {
            return $depth;
        }
        foreach ($member->referrals as $referral) {
            $found = $this->findReferralDepth($referral, $target_member_id, $depth+1);

            if ($found !== null) {
                return $found;
            }
        }
        return null;
    }
}
