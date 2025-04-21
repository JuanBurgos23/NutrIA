<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PlanNutricionalMail extends Mailable
{
    use Queueable, SerializesModels;

    public $planNutricional;
    public $pdf;

    public function __construct($planNutricional, $pdf)
    {
        $this->planNutricional = $planNutricional;
        $this->pdf = $pdf;
    }

    public function build()
    {
        return $this->subject('Plan Nutricional')
            ->view('emails.plan_nutricional') // Blade view for email body
            ->attachData($this->pdf, 'plan_nutricional.pdf', [
                'mime' => 'application/pdf',
            ]);
    }
}
