@extends('layouts.guest')
<title>BiyaNow - Password Reset</title>

@section('content')
<div class="login-card">
    <div class="login-main w-100" style="max-width: 500px;">
        <form method="POST" action="{{ route('password.store') }}" class="theme-form" id="resetForm" novalidate>
            @csrf

            <!-- Logo -->
            <div class="text-center mb-3">
                <img src="{{ asset('assets/images/logo/logo.png') }}" alt="Logo" style="max-width: 50px;">
            </div>

            <!-- Heading -->
            <h4 class="text-center">Reset Password</h4>
            <p class="text-center text-muted mb-4">Enter your new password below.</p>

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email', $request->email) }}" 
                        class="form-control" 
                        readonly 
                    >
                </div>
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- New Password -->
            <div class="mb-3">
                <label for="password" class="form-label">New Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        class="form-control @error('password') is-invalid @enderror" 
                        placeholder="********" 
                        required 
                        minlength="8"
                    >
                </div>
                <!-- Strength Meter -->
                <div class="progress mt-2" style="height: 6px;">
                    <div id="strengthBar" class="progress-bar"></div>
                </div>
                <small id="strengthMessage" class="d-block fw-bold mt-1"></small>
                @error('password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                    <input 
                        type="password" 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        class="form-control" 
                        placeholder="********" 
                        required
                    >
                </div>
                <small id="matchMessage" class="d-block mt-1 fw-bold"></small>
                @error('password_confirmation')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Submit -->
            <button type="submit" class="btn btn-primary w-100" id="submitBtn" disabled>
                Reset Password
            </button>

            <!-- Back to login -->
            <p class="mt-4 text-center mb-0">
                <a href="{{ route('login') }}" class="text-primary">Back to Login</a>
            </p>
        </form>
    </div>
</div>
@endsection
