@extends('layouts.guest')
<title>BiyaNow - Verify Email</title>

@section('content')
<div class="login-card">
    <div class="login-main w-100" style="max-width: 500px;">

        <!-- Logo -->
        <div class="text-center mb-3">
            <img src="{{ asset('assets/images/logo/logo.png') }}" alt="Logo" style="max-width: 50px;">
        </div>

        <!-- Title -->
        <h4 class="text-center">Verify Your Email</h4>
        <p class="text-center text-muted mb-4">
            Thanks for signing up! We’ve sent a verification link to your email address.  
            Please check your inbox and click the link to activate your account.  
            <br><br>
            Didn't receive the email? No worries!
        </p>

        <!-- Success Message -->
        @if (session('status') === 'verification-link-sent')
            <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                A new verification link has been sent to your email address.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Actions -->
        <div class="d-flex flex-column gap-3">
            <!-- Resend Verification -->
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-arrow-repeat me-1"></i> Resend Verification Email
                </button>
            </form>

            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-secondary w-100">
                    <i class="bi bi-box-arrow-right me-1"></i> Log Out
                </button>
            </form>
        </div>

        <!-- Footer Note -->
        <div class="text-center mt-4">
            <small class="text-muted">
                Still can't find it? Be sure to check your <strong>Spam</strong> or <strong>Junk</strong> folders.
            </small>
        </div>
    </div>
</div>
@endsection
