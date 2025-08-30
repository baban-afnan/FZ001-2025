<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Title -->
    <title>{{ config('app.name', 'BiyaNow') }}</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('assets/images/logo/logo.png') }}" type="image/x-icon">

    <!-- Project Styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/color-1.css') }}" id="color">
    <link rel="stylesheet" href="{{ asset('assets/css/vendors/flag-icon.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/themify.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/iconly-icon.css') }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background: #f4f7fe;
            font-family: 'Segoe UI', sans-serif;
        }

        .login-card {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 15px;
        }

        .login-main {
            background: #fff;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            max-width: 500px;
            width: 100%;
        }

        .form-group {
            margin-bottom: 1.2rem;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #007bff;
        }

        .toggle-password {
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
            cursor: pointer;
        }

        #strengthMessage, #matchMessage {
            font-size: 0.85rem;
            margin-top: 5px;
        }

        .progress {
            height: 5px;
            margin-top: 5px;
        }

        .email-invalid {
            border-color: red !important;
        }
    </style>
</head>

<body>
    <!-- Loader -->
    <div class="loader-wrapper" id="loader">
        <div class="loader"><span></span><span></span><span></span></div>
    </div>

    <!-- Main Content -->
    @yield('content')

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/js/vendors/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
       
        // Password Toggle
        const togglePassword = document.getElementById("togglePassword");
        const password = document.getElementById("password");
        if (togglePassword && password) {
            togglePassword.addEventListener("click", function () {
                const type = password.getAttribute("type") === "password" ? "text" : "password";
                password.setAttribute("type", type);
                this.classList.toggle("bi-eye");
                this.classList.toggle("bi-eye-slash");
            });
        }

        // Password Strength & Match
        const confirmPassword = document.getElementById('password_confirmation');
        const submitBtn = document.getElementById('submitBtn');
        const strengthBar = document.getElementById('strengthBar');
        const strengthMessage = document.getElementById('strengthMessage');
        const matchMessage = document.getElementById('matchMessage');

        function checkStrength(pw) {
            let strength = 0;
            if (pw.length >= 8) strength++;
            if (/[A-Z]/.test(pw)) strength++;
            if (/[0-9]/.test(pw)) strength++;
            if (/[@$!%*?&]/.test(pw)) strength++;
            return strength;
        }

        function updateStrength() {
            if (!password) return;
            const val = password.value;
            const strength = checkStrength(val);

            let message = '';
            let color = '';
            let width = (strength / 4) * 100;

            if (strength === 0) {
                message = '';
                width = 0;
                color = 'bg-transparent';
            } else if (strength === 1) {
                message = 'Weak';
                color = 'bg-danger';
            } else if (strength === 2) {
                message = 'Fair';
                color = 'bg-warning';
            } else if (strength === 3) {
                message = 'Good';
                color = 'bg-info';
            } else if (strength === 4) {
                message = 'Strong';
                color = 'bg-success';
            }

            if (strengthBar) {
                strengthBar.style.width = width + '%';
                strengthBar.className = 'progress-bar ' + color;
            }
            if (strengthMessage) strengthMessage.textContent = message;
        }

        function checkMatch() {
            if (!password || !confirmPassword) return false;
            if (confirmPassword.value === '') {
                if (matchMessage) matchMessage.textContent = '';
                return false;
            }
            if (password.value === confirmPassword.value) {
                if (matchMessage) {
                    matchMessage.textContent = 'Passwords match ✅';
                    matchMessage.classList.remove('text-danger');
                    matchMessage.classList.add('text-success');
                }
                return true;
            } else {
                if (matchMessage) {
                    matchMessage.textContent = 'Passwords do not match ❌';
                    matchMessage.classList.remove('text-success');
                    matchMessage.classList.add('text-danger');
                }
                return false;
            }
        }

        function validateForm() {
            updateStrength();
            const match = checkMatch();
            const strength = password ? checkStrength(password.value) : 0;
            if (submitBtn) submitBtn.disabled = !(match && strength >= 3);
        }

        if (password) password.addEventListener('input', validateForm);
        if (confirmPassword) confirmPassword.addEventListener('input', validateForm);

        // Email Validation
        const emailInput = document.getElementById('emailInput');
        if (emailInput) {
            emailInput.addEventListener('input', function () {
                const emailValue = emailInput.value.trim();
                const isValid = emailValue.match(/^[^\s@]+@[^\s@]+\.(com|com\.ng|ng)$/i);
                if (isValid) {
                    emailInput.classList.remove('email-invalid');
                    if (submitBtn) submitBtn.removeAttribute('disabled');
                } else {
                    emailInput.classList.add('email-invalid');
                    if (submitBtn) submitBtn.setAttribute('disabled', true);
                }
            });
        }
    });
    </script>
</body>
</html>
