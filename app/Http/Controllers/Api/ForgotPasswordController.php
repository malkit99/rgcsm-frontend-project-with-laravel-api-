<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPasswordRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    public function sendResetLinkEmail(ForgotPasswordRequest $request)
    {
        // $this->validateEmail($request);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $response = $this->broker()->sendResetLink(
            $request->only('email')
        );

        return $response == Password::RESET_LINK_SENT
                    ? $this->sendResetLinkResponse($request, $response)
                    : $this->sendResetLinkFailedResponse($request, $response);
    }





    protected function sendResetLinkResponse(Request $request, $response)
    {
        // dd($response);
        return response()->json([
            'message'=> 'Email sent',
            'reponse' => $response
        ], 200);
    }





    protected function sendResetLinkFailedResponse(Request $request, $response)
    {

        return response()->json([
            'message'=> 'Failed to send email',
            'reponse' => $response
        ],500);

    }



    public function broker()
    {
        return Password::broker();
    }




}
