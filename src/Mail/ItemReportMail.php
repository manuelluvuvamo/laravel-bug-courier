<?php

namespace ManuelLuvuvamo\BugCourier\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ItemReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public array $emailData;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $emailData)
    {
        $this->emailData = $emailData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('bug-courier::emails.item_report')
                    ->with($this->emailData)
                    ->subject('Error 500 - Execution Failure on '.date('Y/m/d H:i:s').' ['.env('APP_NAME').']')
                    ->to(config('bug-courier.reporting.email.address'));
    }
}
