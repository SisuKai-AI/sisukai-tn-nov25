@extends('emails.layout')

@section('title', 'Payment Failed')

@section('content')
    <h1>⚠️ Payment Failed, {{ $learnerName }}</h1>
    
    <p>We were unable to process your payment for your SisuKai subscription.</p>

    <div class="info-box" style="border-left-color: #dc2626;">
        <strong>Payment Details:</strong><br>
        Amount: <strong>${{ number_format($amount, 2) }}</strong><br>
        Plan: <strong>{{ $planName }}</strong><br>
        Reason: <strong>{{ $failureReason ?? 'Payment declined' }}</strong>
    </div>

    <p><strong>What happens now?</strong></p>
    <p>Your subscription is currently in a <strong>past due</strong> status. You still have access to SisuKai, but we'll need you to update your payment method to avoid service interruption.</p>

    <a href="{{ $updatePaymentUrl }}" class="button">Update Payment Method</a>

    <p><strong>Common reasons for payment failure:</strong></p>
    <ul>
        <li>Insufficient funds</li>
        <li>Expired card</li>
        <li>Incorrect billing information</li>
        <li>Card declined by bank</li>
    </ul>

    <p><strong>Need help?</strong></p>
    <p>If you're having trouble updating your payment method, please <a href="{{ route('landing.contact') }}">contact our support team</a> and we'll be happy to assist you.</p>

    <p>Best regards,<br>
    <strong>The SisuKai Team</strong></p>
@endsection
