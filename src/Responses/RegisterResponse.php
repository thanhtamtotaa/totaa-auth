<?php

namespace ToTaa\Auth\Responses;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;

class RegisterResponse implements RegisterResponseContract
{

    public function toResponse($request)
    {

        // below is the existing response
        // replace this with your own code
        // the user can be located with Auth facade

        if ($request->wantsJson()) {
            return new JsonResponse('', 201);
        } elseif (!!request("urlback")) {
            return redirect(request("urlback"));
        } else {
            return redirect()->config('fortify.home');
        }
    }

}
