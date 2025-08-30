@extends('layouts.guest')
<title>BiyaNow - Login</title>

@section('content')
<div class="login-card">
    <div class="login-main w-100" style="max-width: 500px;">
        <form method="POST" action="{{ route('login') }}" class="theme-form" novalidate>
            @csrf

            <!-- Logo -->
            <div class="text-center mb-3">
                <img src="{{ asset('assets/images/logo/logo.png') }}" alt="Logo" style="max-width: 50px;">
            </div>

            <!-- Title -->
            <h4 class="text-center mb-2">Sign in to your account</h4>
            <p class="text-center text-muted mb-4">Enter your credentials to continue</p>

            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                           class="form-control @error('email') is-invalid @enderror"
                           placeholder="you@example.com" required autofocus>
                </div>
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-3 position-relative">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                    <input type="password" id="password" name="password"
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="********" required minlength="8">
                    <i class="bi bi-eye-slash toggle-password" id="togglePassword"></i>
                </div>
                @error('password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Remember Me + Forgot Password -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="remember_me" name="remember">
                    <label class="form-check-label" for="remember_me">Remember Me</label>
                </div>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-decoration-none">Forgot Password?</a>
                @endif
            </div>

            <!-- Submit -->
            <button type="submit" class="btn btn-primary w-100">Sign In</button>

            <!-- Register -->
            <p class="mt-4 text-center mb-0">
                Don’t have an account?
                <a href="{{ route('register') }}" class="text-primary">Create Account</a>
            </p>
        </form>
    </div>
</div>
@endsection
