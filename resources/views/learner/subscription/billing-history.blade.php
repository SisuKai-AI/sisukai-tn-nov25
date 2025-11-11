@extends('layouts.learner')

@section('title', 'Billing History')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-10 mx-auto">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="mb-0">Billing History</h1>
                <a href="{{ route('learner.payment.manage-subscription') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Back to Subscription
                </a>
            </div>
            
            @if($payments->count() > 0)
                <div class="card">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Date</th>
                                        <th>Description</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Payment Method</th>
                                        <th>Transaction ID</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($payments as $payment)
                                        <tr>
                                            <td>{{ $payment->created_at->format('M j, Y') }}</td>
                                            <td>
                                                @if($payment->type === 'subscription')
                                                    Subscription Payment
                                                @elseif($payment->type === 'single_certification')
                                                    Single Certification Purchase
                                                @else
                                                    {{ ucfirst($payment->type) }}
                                                @endif
                                            </td>
                                            <td>
                                                <strong>${{ number_format($payment->amount, 2) }}</strong>
                                                <small class="text-muted">{{ strtoupper($payment->currency) }}</small>
                                            </td>
                                            <td>
                                                @if($payment->status === 'completed')
                                                    <span class="badge bg-success">Paid</span>
                                                @elseif($payment->status === 'pending')
                                                    <span class="badge bg-warning">Pending</span>
                                                @elseif($payment->status === 'failed')
                                                    <span class="badge bg-danger">Failed</span>
                                                @elseif($payment->status === 'refunded')
                                                    <span class="badge bg-info">Refunded</span>
                                                @else
                                                    <span class="badge bg-secondary">{{ ucfirst($payment->status) }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <i class="bi bi-credit-card"></i>
                                                {{ ucfirst($payment->payment_method ?? 'Card') }}
                                            </td>
                                            <td>
                                                <small class="text-muted font-monospace">
                                                    {{ Str::limit($payment->transaction_id, 20) }}
                                                </small>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Pagination -->
                @if($payments->hasPages())
                    <div class="mt-4">
                        {{ $payments->links() }}
                    </div>
                @endif

                <!-- Summary Card -->
                <div class="row mt-4">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body text-center">
                                <h6 class="text-muted mb-2">Total Paid</h6>
                                <h3 class="mb-0 text-success">${{ number_format($totalPaid, 2) }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body text-center">
                                <h6 class="text-muted mb-2">Total Transactions</h6>
                                <h3 class="mb-0 text-primary">{{ $payments->total() }}</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body text-center">
                                <h6 class="text-muted mb-2">Last Payment</h6>
                                <h3 class="mb-0">{{ $payments->first()->created_at->format('M j') }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="alert alert-info">
                    <h4 class="alert-heading">No Payment History</h4>
                    <p class="mb-0">You haven't made any payments yet.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
