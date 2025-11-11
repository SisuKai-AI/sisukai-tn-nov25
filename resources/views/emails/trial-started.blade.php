@extends('emails.layout')

@section('title', 'Welcome to SisuKai')

@section('content')
    <h1>🎉 Welcome to SisuKai, {{ $learnerName }}!</h1>
    
    <p>Your 7-day free trial has started! You now have full access to all SisuKai features.</p>

    <div class="info-box">
        <strong>Your Trial Details:</strong><br>
        Plan: <strong>{{ $planName }}</strong><br>
        Trial Ends: <strong>{{ $trialEndsAt }}</strong><br>
        Access: <strong>All Certifications</strong>
    </div>

    <p><strong>What you can do during your trial:</strong></p>
    <ul>
        <li>✅ Access all certification practice questions</li>
        <li>✅ Take unlimited benchmark exams</li>
        <li>✅ Use our adaptive learning engine</li>
        <li>✅ Track your performance with analytics</li>
        <li>✅ Practice with timed exam simulations</li>
    </ul>

    <a href="{{ $dashboardUrl }}" class="button">Go to Dashboard</a>

    <p><strong>What happens next?</strong></p>
    <p>Your trial is completely free for 7 days. No credit card required. We'll send you a reminder 2 days before your trial ends. If you decide SisuKai isn't for you, simply do nothing and you won't be charged.</p>

    <p><strong>Need help getting started?</strong></p>
    <p>Check out our <a href="{{ route('landing.help.index') }}">Help Center</a> or reply to this email with any questions.</p>

    <p>Happy studying!<br>
    <strong>The SisuKai Team</strong></p>
@endsection
