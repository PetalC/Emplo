<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Linkedin;
use App\Models\LinkedinAccess;

class LinkedinController extends Controller
{
    protected $linkedinAPI;

    public function __construct()
    {
        $this->linkedinAPI = new Linkedin();
    }

    public function redirectToProvider(Request $request)
    {
        return redirect($this->linkedinAPI->authorise());
    }

    public function handleCallback(Request $request)
    {
        $authCode = ($request->has('code')) ? $request->query('code') : '';

        if (!$authCode) {
            abort(401);
        }

        $auth = $this->linkedinAPI->accessToken($authCode);

        if ($auth) {
            $access = LinkedinAccess::firstOrNew(
                [
                    'user' => $request->user()->id,
                ]
            );

            $access->access_token = $auth->access_token;
            $access->expires_at = Carbon::now()->addSeconds(($auth->expires_in - 86400))->format('Y-m-d H:i:s');
            $access->save();
        }
        
        return redirect(\URL::to('/dashboard/schools'));
    }

}
