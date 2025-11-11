<?php

namespace App\Mail;

use App\Models\Learner;
use App\Models\LearnerSubscription;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentFailedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $learner;
    public $subscription;
    public $amount;
    public $failureReason;

    public function __construct(Learner $learner, LearnerSubscription $subscription, float $amount, string $failureReason = null)
    {
        $this->learner = $learner;
        $this->subscription = $subscription;
        $this->amount = $amount;
        $this->failureReason = $failureReason ?? 'Payment declined';
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Payment Failed - Action Required',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.payment-failed',
            with: [
                'email' => $this->learner->email,
                'learnerName' => $this->learner->name,
                'amount' => $this->amount,
                'planName' => $this->subscription->plan->name,
                'failureReason' => $this->failureReason,
                'updatePaymentUrl' => route('learner.payment.manage-subscription'),
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
