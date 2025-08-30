@extends('layouts.guest')
<title>BiyaNow - Forgot Password</title>

@section('content')
<div class="login-card">
    <div class="login-main w-100" style="max-width: 500px;">
        <form method="POST" action="{{ route('password.email') }}" class="theme-form" id="forgotForm" novalidate>
            @csrf

            <!-- Logo -->
            <div class="text-center mb-3">
                <img src="{{ asset('assets/images/logo/logo.png') }}" alt="Logo" style="max-width: 50px;">
            </div>

            <!-- Heading -->
            <h4 class="text-center">Forgot Password</h4>
            <p class="text-center text-muted mb-4">
                Enter your email address and we’ll send you a link to reset your password.
            </p>

            <!-- Session Status -->
            @if (session('status'))
                <div class="alert alert-success text-center">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Email -->
            <div class="mb-3">
                <label for="emailInput" class="form-label">Email Address</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                    <input 
                        class="form-control @error('email') is-invalid @enderror" 
                        type="email" 
                        id="emailInput"
                        name="email" 
                        value="{{ old('email') }}" 
                        required 
                        autofocus 
                        placeholder="you@example.com"
                    >
                </div>
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Submit -->
            <button type="submit" class="btn btn-primary w-100">
                Send Password Reset Link
            </button>

            <!-- Back to Login -->
            <p class="mt-4 mb-0 text-center">
                <a href="{{ route('login') }}" class="text-primary">Back to Login</a>
            </p>
        </form>
    </div>
</div>
@endsection
