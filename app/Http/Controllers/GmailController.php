<?php

namespace App\Http\Controllers;

use App\Models\Info;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Services\GmailService;
use Illuminate\Support\Facades\Auth;

class GmailController extends Controller
{
    private $msg;
    private function getErrorMessage($exeption)
    {
        $this->msg = ['msg_type' => 'msg_error', 'msg_value' => $exeption->getMessage()];
    }

    public function authenticate(GmailService $gmailService)
    {
        $authUrl = $gmailService->authenticate();
        return redirect()->away($authUrl);
    }

    public function callback(GmailService $gmailService, Request $request)
    {
        try {
            $gmailService->callback($request);
            return redirect('/gmail-inbox');
        } catch (\Exception $exeption) {
            $this->getErrorMessage($exeption);
            return redirect('/dashboard')->with($this->msg['msg_type'], $this->msg['msg_value']);
        }
    }

    public function getGmailInbox(Request $request, GmailService $gmailService)
    {
        try {
            if (!Auth::user()->accessToken) {
                return redirect('/gmail/auth');
            }
            if (Auth::user()->role != 'admin') {
                $data = UserService::getUserDashboard();
            }
            $data['fullMessages'] = $gmailService->getGmailInbox($request);
            return view('gmail.gmail-inbox', $data);
        } catch (\Exception $exeption) {
            $this->getErrorMessage($exeption);
            return redirect('/dashboard')->with($this->msg['msg_type'], $this->msg['msg_value']);
        }
    }

    public function downloadAttachment(GmailService $gmailService, $messageId, $attachmentId, $attachmentIndexId)
    {
        try {
            $msg = $gmailService->downloadAttachment($messageId, $attachmentId, $attachmentIndexId);
            return back()->with($msg['msg_type'], $msg['msg_value']);
        } catch (\Exception $exeption) {
            $this->getErrorMessage($exeption);
            return redirect('/dashboard')->with($this->msg['msg_type'], $this->msg['msg_value']);
        }
    }
}
