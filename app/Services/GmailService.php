<?php

namespace App\Services;

use Google\Client;
use Google\Service\Gmail;
use App\Models\{User, Attachment};
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\{Storage, Auth};

class GmailService
{
    private $client;
    public function __construct()
    {
        $this->client = new Client();
        $this->client->setAuthConfig('client.json');
        $this->client->setAccessType('offline');
        $this->client->setPrompt('consent');
        $this->client->addScope(\Google_Service_Gmail::GMAIL_READONLY);
    }

    public function authenticate()
    {
        return $this->client->createAuthUrl();
    }

    public function callback($request)
    {
        $this->client->fetchAccessTokenWithAuthCode($request->code);
            $user = \App\Models\User::find(Auth::id());
            $user->accessToken = $this->client->getAccessToken();
            $user->save();
    }

    public function getGmailInbox($request)
    {
        $this->client->setAccessToken(Auth::user()->accessToken);
        if (!$this->client->getAccessToken() || $this->client->isAccessTokenExpired()) {
            return redirect('/gmail/auth');
        }
        $service = new Gmail($this->client);
        $messages = $service->users_messages->listUsersMessages('me', ['q' => 'in:inbox has:attachment']);

        $messageIds = array_map(function ($message) {
            return $message->id;
        }, $messages->getMessages());

        $perPage = 10;
        $page = $request->input('page', 1);
        $offset = ($page - 1) * $perPage;
        $fullMessages = array_map(function ($messageId) use ($service) {
            return $service->users_messages->get('me', $messageId, ['format' => 'full']);
        }, array_slice($messageIds, $offset, $perPage));

        $total = count($messageIds);
        $paginator = new LengthAwarePaginator($fullMessages, $total, $perPage, $page);
        return $paginator;
    }

    public function downloadAttachment($messageId, $attachmentId, $attachmentIndexId)
    {
        $user = User::find(Auth::id());
        $accessToken = json_decode($user->accessToken, true);

        if ($this->client->isAccessTokenExpired()) {
            $this->client->fetchAccessTokenWithRefreshToken($accessToken['refresh_token']);
            $user->accessToken = $this->client->getAccessToken();
            $user->save();
        }

        $service = new \Google_Service_Gmail($this->client);
        $message = $service->users_messages->get('me', $messageId, ['format' => 'full']);
        $parts = $message->getPayload()->getParts();
        $attachment = $parts[$attachmentIndexId];
        $attachmentId = $attachment->getBody()->getAttachmentId();
        $attachmentData = $service->users_messages_attachments->get('me', $messageId, $attachmentId)->getData();

        $attachmentHeaders = $attachment->getHeaders();
        $filename = '';
        $filetype = '';

        foreach ($attachmentHeaders as $header) {
            if ($header->name === 'Content-Disposition') {
                $filename = substr($header->value, strpos($header->value, 'filename=') + 9, -1);
                $filename = str_replace('"', '', $filename); // remove quotes from filename
            }
            if ($header->name === 'Content-Type') {
                $filetype = $header->value;
            }
        }

        $uniqueName = md5(uniqid()) . "." . pathinfo($filename, PATHINFO_EXTENSION);
        $newAattachment = new Attachment();
        $newAattachment->file_name = $filename;
        $newAattachment->file_path = getGmailFileDirectory() .  $uniqueName;
        $newAattachment->file_size = $attachment['body']['size'];
        $newAattachment->file_extension = pathinfo($filename, PATHINFO_EXTENSION);
        $newAattachment->user_id = Auth::user()->id;
        $newAattachment->uploaded_by = Auth::user()->id;
        if ($newAattachment->save()) {
            Storage::disk('local')->put(getGmailFileDirectory() . $uniqueName, base64_decode(strtr($attachmentData, '-_', '+/')));
            return ['msg_type' => 'msg_success', 'msg_value' => 'Attachment downloaded.'];
        }
    }
}
