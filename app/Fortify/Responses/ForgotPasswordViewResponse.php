<?php

namespace App\Fortify\Responses;

use Laravel\Fortify\Contracts\RequestPasswordResetLinkViewResponse as Contract;

class ForgotPasswordViewResponse implements Contract
{
    public function toResponse($request)
    {
        return view('auth.forgot-password');
    }
}
