<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ResendService;

class ResendController extends Controller
{
    public function index()
    {
        return view('resend.index');
    }

    public function sendEmail(ResendService $resendService, Request $request)
    {
        $request->validate([
            'to' => 'required|email',
            'subject' => 'required|string',
            'body' => 'required|string',
        ]);

        try {
            $response = $resendService->sendEmail(
                $request->input('to'),
                $request->input('subject'),
                $request->input('body')
            );

            return redirect()->back()->with('success', 'Email sent successfully! Response: ' . json_encode($response));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to send email. Error: ' . $e->getMessage());
        }
    }
}
