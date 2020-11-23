<?php

namespace ToTaa\Auth\Http\Responses;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Laravel\Fortify\Contracts\TwoFactorLoginResponse as TwoFactorLoginResponseContract;

class TwoFactorLoginResponse implements TwoFactorLoginResponseContract
{

    public function toResponse($request)
    {

        // below is the existing response
        // replace this with your own code
        // the user can be located with Auth facade

        if ($request->wantsJson()) {
            return new JsonResponse('', 204);
        } elseif (!!request("urlback")) {
            return redirect(request("urlback"));
        } else {
            return redirect()->intended(config('fortify.home'));
        }
    }

}

