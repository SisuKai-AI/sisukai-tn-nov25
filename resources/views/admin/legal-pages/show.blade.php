@extends('layouts.admin')
@section('title', $legalPage->title)
@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-1">{{ $legalPage->title }}</h4>
            <p class="text-muted mb-0">Last updated: {{ $legalPage->updated_at->format('M d, Y') }}</p>
        </div>
        <a href="{{ route('admin.legal-pages.edit', $legalPage) }}" class="btn btn-primary">
            <i class="bi bi-pencil me-2"></i>Edit
        </a>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="prose">
                {!! nl2br(e($legalPage->content)) !!}
            </div>
        </div>
    </div>
</div>
@endsection
