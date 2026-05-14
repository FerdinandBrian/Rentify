<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Rentify') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Neumorphism Base Styles adjusted for Kaiadmin theme */
        body {
            font-family: 'Public Sans', sans-serif;
            background: #e0e5ec;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            line-height: 1.6;
        }

        .login-container {
            width: 100%;
            max-width: 420px;
            margin: 0 auto;
        }

        .login-card {
            background: #e0e5ec;
            border-radius: 30px;
            padding: 50px 40px;
            box-shadow: 
                20px 20px 60px #bec3cf,
                -20px -20px 60px #ffffff;
            position: relative;
            transition: all 0.3s ease;
        }

        .login-card:hover {
            transform: translateY(-5px);
        }

        .login-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .neu-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 24px;
            background: #e0e5ec;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 
                8px 8px 20px #bec3cf,
                -8px -8px 20px #ffffff,
                inset 0 0 0 #bec3cf,
                inset 0 0 0 #ffffff;
            transition: all 0.3s ease;
        }

        .neu-icon:hover {
            box-shadow: 
                4px 4px 10px #bec3cf,
                -4px -4px 10px #ffffff,
                inset 4px 4px 10px #bec3cf,
                inset -4px -4px 10px #ffffff;
        }

        .icon-inner {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #1572e8; /* Kaiadmin Primary Blue */
        }

        .icon-inner svg {
            width: 100%;
            height: 100%;
        }

        .login-header h2 {
            color: #1a2035; /* Kaiadmin dark text */
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .login-header p {
            color: #8d9498; /* Kaiadmin muted text */
            font-size: 15px;
            font-weight: 400;
        }

        /* Neumorphic Input Styles */
        .form-group {
            margin-bottom: 28px;
            position: relative;
        }

        .neu-input {
            position: relative;
            background: #e0e5ec;
            border-radius: 15px;
            box-shadow: 
                inset 8px 8px 16px #bec3cf,
                inset -8px -8px 16px #ffffff;
            transition: all 0.3s ease;
        }

        .neu-input:focus-within {
            box-shadow: 
                inset 4px 4px 8px #bec3cf,
                inset -4px -4px 8px #ffffff;
        }

        .neu-input input {
            width: 100%;
            background: transparent;
            border: none;
            padding: 20px 24px;
            padding-left: 55px;
            color: #1a2035;
            font-size: 16px;
            font-weight: 600;
            outline: none;
            transition: all 0.3s ease;
        }

        .neu-input input::placeholder {
            color: transparent;
        }

        .neu-input label {
            position: absolute;
            left: 55px;
            top: 50%;
            transform: translateY(-50%);
            color: #8d9498;
            font-size: 16px;
            font-weight: 500;
            pointer-events: none;
            transition: all 0.3s ease;
        }

        .neu-input input:focus + label,
        .neu-input input:not(:placeholder-shown) + label {
            top: 8px;
            font-size: 12px;
            color: #1572e8;
            transform: translateY(0);
            font-weight: 600;
        }

        .input-icon {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            color: #8d9498;
            transition: all 0.3s ease;
        }

        .input-icon svg {
            width: 100%;
            height: 100%;
        }

        .neu-input:focus-within .input-icon {
            color: #1572e8;
        }

        /* Password Toggle */
        .password-group {
            padding-right: 50px;
        }

        .neu-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: #e0e5ec;
            border: none;
            width: 35px;
            height: 35px;
            border-radius: 10px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #8d9498;
            box-shadow: 
                4px 4px 10px #bec3cf,
                -4px -4px 10px #ffffff;
            transition: all 0.3s ease;
        }

        .neu-toggle:hover {
            color: #1572e8;
        }

        .neu-toggle:active {
            box-shadow: 
                inset 2px 2px 5px #bec3cf,
                inset -2px -2px 5px #ffffff;
        }

        .neu-toggle svg {
            width: 18px;
            height: 18px;
        }

        .eye-closed {
            display: none;
        }

        .neu-toggle.show-password .eye-open {
            display: none;
        }

        .neu-toggle.show-password .eye-closed {
            display: block;
        }

        /* Form Options */
        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 35px;
            flex-wrap: wrap;
            gap: 16px;
        }

        .remember-wrapper {
            display: flex;
            align-items: center;
            cursor: pointer;
        }

        .remember-wrapper input[type="checkbox"] {
            display: none;
        }

        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            user-select: none;
            color: #8d9498;
            font-size: 14px;
            font-weight: 600;
        }

        .neu-checkbox {
            width: 22px;
            height: 22px;
            background: #e0e5ec;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 
                3px 3px 8px #bec3cf,
                -3px -3px 8px #ffffff;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .remember-wrapper input[type="checkbox"]:checked + .checkbox-label .neu-checkbox {
            box-shadow: 
                inset 2px 2px 5px #bec3cf,
                inset -2px -2px 5px #ffffff;
        }

        .neu-checkbox svg {
            width: 14px;
            height: 14px;
            color: #1572e8; /* Kaiadmin primary blue */
            opacity: 0;
            transform: scale(0);
            transition: all 0.3s ease;
        }

        .remember-wrapper input[type="checkbox"]:checked + .checkbox-label .neu-checkbox svg {
            opacity: 1;
            transform: scale(1);
        }

        .forgot-link {
            color: #8d9498;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .forgot-link:hover {
            color: #1572e8;
        }

        /* Neumorphic Button */
        .neu-button {
            width: 100%;
            background: #e0e5ec;
            border: none;
            border-radius: 15px;
            padding: 18px 32px;
            color: #1a2035;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            position: relative;
            margin-bottom: 30px;
            box-shadow: 
                8px 8px 20px #bec3cf,
                -8px -8px 20px #ffffff;
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .neu-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(21, 114, 232, 0.1), transparent);
            transition: left 0.5s ease;
        }

        .neu-button:hover {
            transform: translateY(-2px);
            color: #1572e8;
            box-shadow: 
                12px 12px 30px #bec3cf,
                -12px -12px 30px #ffffff;
        }

        .neu-button:hover::before {
            left: 100%;
        }

        .neu-button:active {
            transform: translateY(0);
            color: #1a2035;
            box-shadow: 
                inset 4px 4px 10px #bec3cf,
                inset -4px -4px 10px #ffffff;
        }

        /* Signup Link */
        .signup-link {
            text-align: center;
        }

        .signup-link p {
            color: #8d9498;
            font-size: 14px;
            font-weight: 500;
        }

        .signup-link a {
            color: #1572e8;
            text-decoration: none;
            font-weight: 700;
            transition: color 0.3s ease;
        }

        .signup-link a:hover {
            color: #1a2035;
        }

        /* Error States */
        .error-message {
            color: #f25961; /* Kaiadmin danger */
            font-size: 13px;
            font-weight: 600;
            margin-top: 8px;
            margin-left: 20px;
            display: block;
        }

        .form-group.error .neu-input {
            box-shadow:
                inset 8px 8px 16px #fbc8cb,
                inset -8px -8px 16px #ffffff,
                0 0 0 2px #f25961;
        }

        /* Alert/Status Message */
        .status-message {
            color: #31ce36; /* Kaiadmin success */
            background: #e0e5ec;
            padding: 15px 20px;
            border-radius: 15px;
            margin-bottom: 25px;
            font-size: 14px;
            font-weight: 600;
            text-align: center;
            box-shadow: 
                inset 4px 4px 10px #bec3cf,
                inset -4px -4px 10px #ffffff;
        }
        .status-message.error {
            color: #f25961;
        }

        /* Responsive */
        @media (max-width: 480px) {
            body { padding: 16px; }
            .login-card { padding: 35px 25px; border-radius: 20px; }
            .login-header h2 { font-size: 1.75rem; }
            .neu-input input { padding: 18px 20px; padding-left: 50px; }
            .neu-input label { left: 50px; }
            .form-options { flex-direction: column; align-items: flex-start; gap: 16px; }
        }

        /* OTP Specific */
        .otp-inputs {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-bottom: 10px;
        }
        .otp-input-single {
            width: 45px;
            height: 55px;
            text-align: center;
            font-size: 20px;
            font-weight: 700;
            border-radius: 10px;
            padding-left: 0 !important;
            color: #1572e8 !important;
        }
        .otp-input-single:focus + label,
        .otp-input-single:not(:placeholder-shown) + label {
            display: none;
        }
    </style>
</head>
<body>
    <div class="login-container">
        {{ $slot }}
    </div>

    <script>
        function togglePassword(btn) {
            const input = btn.previousElementSibling.querySelector('input');
            const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
            input.setAttribute('type', type);
            btn.classList.toggle('show-password');
        }
    </script>
</body>
</html>
