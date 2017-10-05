<?php

namespace App\Jobs;

use App\Business\Services\NewsletterManager;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class MailChimp implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * @var string
     */
    private $email;

    /**
     * Create a new job instance.
     *
     * @param string $email
     */
    public function __construct(string $email)
    {
        //
        $this->email = $email;
    }

    /**
     * Execute the job.
     *
     * @param NewsletterManager $newsletterManager
     * @return void
     */
    public function handle(NewsletterManager $newsletterManager)
    {
        $newsletterManager->addEmailToList($this->email);
    }
}
