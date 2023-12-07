<?php

namespace App\Jobs;

use App\Mail\Api\Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var string 送信先メールアドレス
     */
    private readonly string $toAddress;

    /**
     * @var string 本文
     */
    private readonly string $body;

    /**
     * Create a new job instance.
     */
    public function __construct(string $toAddress, string $body)
    {
        $this->toAddress = $toAddress;
        $this->body = $body;

        // メール送信キューを指定
        $this->queue = config('queue.name.emails');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->toAddress)->send(new Notification($this->body));
    }
}
