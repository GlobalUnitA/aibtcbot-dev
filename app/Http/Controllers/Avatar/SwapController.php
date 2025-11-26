<?php

namespace App\Http\Controllers\Avatar;


use App\Models\Asset;
use App\Models\Coin;
use App\Models\Income;
use App\Services\MemberService;
use App\Models\User;
use App\Models\Avatar;
use App\Models\Member;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class SwapController extends Controller
{
    public function __construct()
    {

    }


    public function index(Request $request)
    {
        $view = Avatar::find($request->id);

        return view('avatar.swap', compact('view'));

    }

    public function process(Request $request)
    {


    }
}
