@extends('layouts.guest')
<title>BiyaNow - Registration</title>

@section('content')
<div class="login-card">
    <div class="login-main w-100" style="max-width: 500px;">

        <!-- Session Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('warning'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle-fill me-2"></i> {{ session('warning') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('info'))
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <i class="bi bi-info-circle-fill me-2"></i> {{ session('info') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-x-circle-fill me-2"></i> Please fix the following errors:
                <ul class="mb-0 mt-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Form -->
        <form method="POST" action="{{ route('register') }}" class="theme-form" novalidate>
            @csrf

            <!-- Logo -->
            <div class="text-center mb-3">
                <img src="{{ asset('assets/images/logo/logo.png') }}" alt="Logo" style="max-width: 50px;">
            </div>

            <!-- Title -->
            <h4 class="text-center">Create Account</h4>
            <p class="text-center text-muted mb-4">Fill in your details to register</p>

            <!-- First & Last Name -->
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">First Name</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                        <input type="text" name="first_name" value="{{ old('first_name') }}" 
                               class="form-control @error('first_name') is-invalid @enderror" placeholder="JOEL" required>
                    </div>
                    @error('first_name') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Last Name</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                        <input type="text" name="last_name" value="{{ old('last_name') }}" 
                               class="form-control @error('last_name') is-invalid @enderror" placeholder="MUSA" required>
                    </div>
                    @error('last_name') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                    <input type="email" id="emailInput" name="email" value="{{ old('email') }}" 
                           class="form-control @error('email') is-invalid @enderror" placeholder="Example@gmail.com" required>
                </div>
                @error('email') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
             
            <!-- Referral Code -->
            <div class="mb-3">
                <label class="form-label">Referral Code (Optional)</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-gift-fill"></i></span>
                    <input type="text" name="referral_code" id="referral_code"
                           class="form-control @error('referral_code') is-invalid @enderror"
                           maxlength="15" placeholder="Enter code if you have one"
                           value="{{ old('referral', $referral) }}">
                </div>
                @error('referral_code') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <!-- Password -->
            <div class="mb-3 position-relative">
                <label class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                    <input type="password" id="password" name="password" 
                           class="form-control @error('password') is-invalid @enderror"
                          placeholder="**************" required minlength="8">
                    <i class="bi bi-eye-slash toggle-password" id="togglePassword"></i>
                </div>
                <!-- Strength Meter -->
                <div class="progress mt-1">
                    <div id="strengthBar" class="progress-bar" role="progressbar" style="width: 0%"></div>
                </div>
                <small id="strengthMessage" class="text-muted"></small>
                @error('password') <small class="text-danger d-block">{{ $message }}</small> @enderror
            </div>

            <!-- Confirm Password -->
            <div class="mb-3">
                <label class="form-label">Confirm Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                    <input type="password" id="password_confirmation" name="password_confirmation" 
                           class="form-control @error('password_confirmation') is-invalid @enderror" 
                       placeholder="*************"    required minlength="8">
                </div>
                <small id="matchMessage" class="text-muted"></small>
                @error('password_confirmation') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <!-- Terms -->
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" id="agree_terms" name="agree_terms" required>
                <label class="form-check-label" for="agree_terms">
                    I agree with the <a href="privacy-policy.html" class="ms-1">Privacy Policy</a>
                </label>
            </div>

            <!-- Submit -->
            <button type="submit" id="submitBtn" class="btn btn-primary w-100">Register</button>

            <!-- Login Link -->
            <p class="text-center mt-4">
                Already registered? 
                <a href="{{ route('login') }}" class="text-primary">Sign in</a>
            </p>
        </form>
    </div>
</div>
@endsection
