@extends('layouts.guest')
<title>BiyaNow - Comfirmed Password</title>

@section('content')
<div class="login-card">
    <div class="login-main w-100" style="max-width: 500px;">
        <form method="POST" action="{{ route('password.confirm') }}" class="theme-form" novalidate>
            @csrf

            <!-- Logo -->
            <div class="text-center mb-3">
                <img src="{{ asset('assets/images/logo/logo.png') }}" alt="Logo" style="max-width: 50px;">
            </div>

            <!-- Title -->
            <h4 class="text-center">Confirm Password</h4>
            <p class="text-center text-muted mb-4">
                This is a secure area of the application.  
                Please confirm your password before continuing.
            </p>

            <!-- Password -->
            <div class="mb-3 position-relative">
                <label class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                    <input type="password" id="password" name="password" 
                           class="form-control @error('password') is-invalid @enderror"
                           required minlength="8" autocomplete="current-password" placeholder="********">
                    <i class="bi bi-eye-slash toggle-password" id="togglePassword"></i>
                </div>
                <!-- Strength Meter -->
                <div class="progress mt-1">
                    <div id="strengthBar" class="progress-bar" role="progressbar" style="width: 0%"></div>
                </div>
                <small id="strengthMessage" class="text-muted"></small>
                @error('password') <small class="text-danger d-block">{{ $message }}</small> @enderror
            </div>

            <!-- Submit -->
            <button type="submit" id="submitBtn" class="btn btn-primary w-100" disabled>
                Confirm Password
            </button>

            <!-- Forgot Password Link -->
            <p class="mt-4 mb-0 text-center">
                <a href="{{ route('password.request') }}" class="text-primary">Forgot your password?</a>
            </p>
        </form>
    </div>
</div>
@endsection
