<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\Events\JobProcessing;
use Illuminate\Queue\Events\JobFailed;
use Spatie\WebhookServer\WebhookCall;
use Illuminate\Queue\Jobs\DatabaseJob;
use Config;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(public array $configData)
    {

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {   
        Mail::setSymfonyTransport(Mail::createSymfonyTransport($this->configData));

        return $this->view('email.basic')
            ->subject($this->configData['subject'])
            ->from($this->configData['address'])
            ->with([
                'text' => $this->configData['content'],
        ]);

    }

    public function __destruct() {

        // znam da nije najidealnije resenje, 
        // ali u nedostatku vremena sam ga odradio ovako i bez XML-a :(
        $url = $this->configData['webhook_url'];
        $projectId = $this->configData['project_id'];

        if ( !is_null($url)) {
            Queue::failing(function (JobFailed $event) use ($url, $projectId) { 

                WebhookCall::create()
                ->withHeaders([
                    'Content-Type' => 'application/json'
                ])
                ->doNotSign()
                ->url($url)
                ->payload([
                    'error_message' => $event->exception->getMessage(),
                    'project_id'  => $projectId
                ])
                ->dispatchSync();
            });
        }
    }

}