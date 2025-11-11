@extends('emails.layout')

@section('title', 'Payment Received')

@section('content')
    <h1>✅ Payment Received, {{ $learnerName }}!</h1>
    
    <p>Thank you for your payment. Your subscription is now active and you have full access to all SisuKai features.</p>

    <div class="info-box">
        <strong>Payment Details:</strong><br>
        Amount: <strong>${{ number_format($amount, 2) }}</strong><br>
        Plan: <strong>{{ $planName }}</strong><br>
        Next Billing Date: <strong>{{ $nextBillingDate }}</strong><br>
        Payment Method: <strong>{{ $paymentMethod }}</strong>
    </div>

    <a href="{{ $dashboardUrl }}" class="button">Go to Dashboard</a>

    <p><strong>What's included in your subscription:</strong></p>
    <ul>
        <li>✅ Access to all {{ $certificationCount ?? '18' }} certifications</li>
        <li>✅ Unlimited practice questions</li>
        <li>✅ Adaptive learning engine</li>
        <li>✅ Performance analytics dashboard</li>
        <li>✅ Timed exam simulations</li>
        <li>✅ Mobile app access</li>
    </ul>

    <p><strong>Manage your subscription:</strong></p>
    <p>You can update your payment method, change your plan, or cancel anytime from your <a href="{{ $manageSubscriptionUrl }}">subscription settings</a>.</p>

    <p><strong>Need your receipt?</strong></p>
    <p>You can download your invoice from your <a href="{{ $billingHistoryUrl }}">billing history</a>.</p>

    <p>Happy studying!<br>
    <strong>The SisuKai Team</strong></p>
@endsection
