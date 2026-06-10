<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <meta name="turbo-cache-control" content="no-cache">
    <link rel="icon" href="https://www.telkom.co.id/minio/show/data/image_upload/page/1594112895830_compress_PNG%20Icon%20Telkom.png" type="image/png">

    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --primary: #e32b2b;
            --primary-hover: #b81c1c;
            --primary-light: #fff5f5;
            --text-dark: #1e293b;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
            --border-focus: #e32b2b;
            --transition: all 0.2s ease-in-out;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            background-color: #ffffff;
            overflow-x: hidden;
        }

        
        .split-container {
            display: flex;
            width: 100%;
            min-height: 100vh;
        }

        
        .left-panel {
            width: 60%;
            position: relative;
            background: url('{{ asset("images/telkom_cirebon.png") }}') no-repeat center center;
            background-size: cover;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 4rem;
            overflow: hidden;
        }

        
        .left-overlay {
            position: absolute;
            inset: 0;
            background: rgba(255, 255, 255, 0.85);
            z-index: 1;
            pointer-events: none;
        }

        .blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.6;
            z-index: 2;
            pointer-events: none;
        }

        .blob-1 {
            width: 250px;
            height: 250px;
            background-color: rgba(227, 43, 43, 0.35);
            left: 10%;
            bottom: 10%;
        }

        .blob-2 {
            width: 320px;
            height: 320px;
            background-color: rgba(227, 43, 43, 0.25);
            right: 5%;
            top: 25%;
        }

        .blob-3 {
            width: 200px;
            height: 200px;
            background-color: rgba(227, 43, 43, 0.2);
            left: 45%;
            top: 10%;
        }

        
        .left-content {
            position: relative;
            z-index: 3;
            margin-top: auto;
            margin-bottom: auto;
            max-width: 520px;
            animation: fadeInRight 0.9s cubic-bezier(0.25, 1, 0.5, 1) forwards;
        }

        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(-40px) scale(0.98);
                filter: blur(8px);
            }
            to {
                opacity: 1;
                transform: translateX(0) scale(1);
                filter: blur(0);
            }
        }

        .welcome-label {
            font-size: 1.5rem;
            font-weight: 500;
            color: #475569;
            margin-bottom: 0.5rem;
        }

        .app-title {
            font-size: 3rem;
            font-weight: 800;
            color: #0f172a;
            line-height: 1.1;
            letter-spacing: -1.5px;
            text-transform: uppercase;
        }

        .app-title span {
            color: var(--primary);
        }

        .app-subtitle {
            font-size: 1.05rem;
            font-weight: 500;
            color: #475569;
            margin-top: 1rem;
        }

        .app-detail {
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--text-muted);
            margin-top: 0.25rem;
        }

        .left-footer {
            position: relative;
            z-index: 3;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .dot-pulse {
            width: 8px;
            height: 8px;
            background-color: var(--primary);
            border-radius: 50%;
            box-shadow: 0 0 8px var(--primary);
        }

        
        .right-panel {
            width: 40%;
            background: #ffffff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 4rem 2rem;
            position: relative;
            z-index: 5;
            box-shadow: -10px 0 30px rgba(0, 0, 0, 0.02);
            animation: fadeInLeft 0.9s cubic-bezier(0.25, 1, 0.5, 1) forwards;
        }

        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(40px) scale(0.98);
                filter: blur(8px);
            }
            to {
                opacity: 1;
                transform: translateX(0) scale(1);
                filter: blur(0);
            }
        }

        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
                filter: blur(4px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
                filter: blur(0);
            }
        }

        .stagger-1 { animation: fadeInUp 0.8s cubic-bezier(0.25, 1, 0.5, 1) 0.1s both; }
        .stagger-2 { animation: fadeInUp 0.8s cubic-bezier(0.25, 1, 0.5, 1) 0.2s both; }
        .stagger-3 { animation: fadeInUp 0.8s cubic-bezier(0.25, 1, 0.5, 1) 0.3s both; }
        .stagger-4 { animation: fadeInUp 0.8s cubic-bezier(0.25, 1, 0.5, 1) 0.4s both; }
        .stagger-5 { animation: fadeInUp 0.8s cubic-bezier(0.25, 1, 0.5, 1) 0.5s both; }
        .stagger-6 { animation: fadeInUp 0.8s cubic-bezier(0.25, 1, 0.5, 1) 0.6s both; }

        .form-container {
            max-width: 360px;
            width: 100%;
        }

        
        .logo-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 2.5rem;
            text-align: center;
        }

        .brand-logo-img {
            height: 48px;
            width: auto;
            margin-bottom: 1.25rem;
        }

        .form-caption {
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--primary);
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        
        .form-group {
            margin-bottom: 1.75rem;
        }

        .form-label {
            display: block;
            font-size: 0.725rem;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 0.25rem;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .form-input {
            width: 100%;
            height: 40px;
            border: none;
            border-bottom: 1.5px solid #cbd5e1;
            border-radius: 0;
            background: transparent;
            padding: 0.5rem 0.25rem;
            font-size: 0.95rem;
            color: var(--text-dark);
            font-weight: 500;
            transition: var(--transition);
            outline: none;
        }

        .form-input::placeholder {
            color: #cbd5e1;
            font-weight: 400;
        }

        .form-input:focus {
            border-bottom-color: var(--border-focus);
        }

        .toggle-password {
            position: absolute;
            right: 0.25rem;
            background: none;
            border: none;
            cursor: pointer;
            color: #94a3b8;
            padding: 0.2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
        }

        .toggle-password:hover {
            color: var(--text-dark);
        }

        
        .form-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 1rem 0 2rem;
        }

        .checkbox-container {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            user-select: none;
        }

        .checkbox-container input {
            display: none;
        }

        .custom-checkmark {
            width: 16px;
            height: 16px;
            border: 1.5px solid #cbd5e1;
            border-radius: 4px;
            background-color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
        }

        .checkbox-container input:checked ~ .custom-checkmark {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .custom-checkmark svg {
            width: 10px;
            height: 10px;
            color: #ffffff;
            opacity: 0;
            transform: scale(0.5);
            transition: var(--transition);
        }

        .checkbox-container input:checked ~ .custom-checkmark svg {
            opacity: 1;
            transform: scale(1);
        }

        .checkbox-label {
            font-size: 0.8rem;
            font-weight: 500;
            color: var(--text-muted);
            transition: var(--transition);
        }

        .checkbox-container:hover .checkbox-label {
            color: var(--text-dark);
        }

        .checkbox-container:hover .custom-checkmark {
            border-color: var(--primary);
        }

        
        .btn-submit {
            width: 100%;
            height: 44px;
            background-color: var(--primary);
            color: #ffffff;
            border: none;
            border-radius: 6px;
            font-size: 0.95rem;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            box-shadow: 0 4px 12px rgba(227, 43, 43, 0.2);
            transition: var(--transition);
        }

        .btn-submit:hover:not(:disabled) {
            background-color: var(--primary-hover);
            box-shadow: 0 6px 16px rgba(227, 43, 43, 0.3);
        }

        .btn-submit:active:not(:disabled) {
            transform: translateY(1px);
        }

        .btn-submit:disabled {
            opacity: 0.8;
            cursor: not-allowed;
        }

        
        .error-alert {
            padding: 0.75rem 1rem;
            background-color: var(--primary-light);
            border: 1.5px solid #fca5a5;
            border-radius: 8px;
            display: flex;
            align-items: flex-start;
            gap: 0.6rem;
            margin-bottom: 1.5rem;
            animation: shake 0.4s ease-in-out;
        }

        .error-alert svg {
            color: var(--primary);
            flex-shrink: 0;
            width: 16px;
            height: 16px;
            margin-top: 1px;
        }

        .error-alert p {
            font-size: 0.8rem;
            color: #991b1b;
            font-weight: 600;
            line-height: 1.45;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-3px); }
            75% { transform: translateX(3px); }
        }

        
        .form-footer-links {
            margin-top: 1.5rem;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            align-items: center;
            text-align: center;
        }

        .link-item {
            font-size: 0.825rem;
            color: var(--text-muted);
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
        }

        .link-item a {
            color: var(--primary);
            font-weight: 700;
            text-decoration: none;
        }

        .link-item a:hover {
            text-decoration: underline;
        }

        .forgot-pass {
            color: var(--primary);
            font-weight: 600;
        }

        .forgot-pass:hover {
            text-decoration: underline;
        }

        
        .spinner {
            animation: spin 0.8s linear infinite;
        }

        .hidden {
            display: none !important;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        
        @media (max-width: 900px) {
            .left-panel {
                display: none;
            }

            .right-panel {
                width: 100%;
                padding: 3rem 1.5rem;
            }
        }
    </style>
</head>
<body>

    <div class="split-container">
        
        
        <div class="left-panel">
            <div class="left-overlay"></div>
            <div class="blob blob-1"></div>
            <div class="blob blob-2"></div>
            <div class="blob blob-3"></div>

            <div class="left-content">
                <p class="welcome-label">Selamat Datang di</p>
                <h1 class="app-title">PORTAL <span>MONITORING</span></h1>
                <p class="app-detail">Witel Cirebon - Telkom Indonesia</p>
            </div>

            
        </div>

        
        <div class="right-panel">
            <div class="form-container">
                <div class="logo-section stagger-1">
                    <img class="brand-logo-img" src="https://www.telkom.co.id/minio/show/data/image_upload/page/1594112895830_compress_PNG%20Icon%20Telkom.png" alt="Telkom Logo">
                    <div class="form-caption">Login</div>
                    <p class="app-detail">Silakan login untuk mengakses dashboard</p>
                </div>

                @if ($errors->any())
                    <div class="error-alert">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                        </svg>
                        <p>Email atau password salah. Silakan coba lagi.</p>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" id="loginForm" data-turbo="false">
                    @csrf

                    
                    <div class="form-group stagger-2">
                        <label for="email" class="form-label">Email</label>
                        <div class="input-wrapper">
                            <input type="email" name="email" id="email" required autofocus
                                value="{{ old('email') }}"
                                placeholder="Email"
                                class="form-input">
                        </div>
                    </div>

                    
                    <div class="form-group stagger-3">
                        <label for="passwordInput" class="form-label">Password</label>
                        <div class="input-wrapper">
                            <input type="password" name="password" id="passwordInput" required
                                placeholder="Password"
                                class="form-input" style="padding-right: 2rem;">
                            <button type="button" id="togglePassword" class="toggle-password" tabindex="-1">
                                <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" style="width:18px;height:18px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    
                    <div class="form-options stagger-4">
                        <label class="checkbox-container">
                            <input type="checkbox" name="remember" id="remember">
                            <div class="custom-checkmark">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <span class="checkbox-label">Ingat saya</span>
                        </label>
                    </div>

                    
                    <button type="submit" id="loginBtn" class="btn-submit stagger-5">
                        <svg id="btnSpinner" class="spinner hidden" style="width:16px;height:16px" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle style="opacity:.25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path style="opacity:.75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span id="btnText">Login</span>
                    </button>
                </form>

                <div class="form-footer-links stagger-6">
                    <a href="{{ route('password.request') }}" class="link-item forgot-pass">
                        <svg xmlns="http://www.w3.org/2000/svg" style="width:14px;height:14px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        Lupa Password ?
                    </a>
                    <span class="link-item">
                        Belum memiliki akun? <a href="{{ route('register') }}" data-turbo="false">Register</a>
                    </span>
                </div>

            </div>
        </div>

    </div>

    <script>
        {
            // Password toggle visibility
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('passwordInput');
            const eyeIcon = document.getElementById('eyeIcon');

            if (togglePassword && passwordInput && eyeIcon) {
                togglePassword.addEventListener('click', function() {
                    const isPassword = passwordInput.type === 'password';
                    passwordInput.type = isPassword ? 'text' : 'password';
                    
                    if (isPassword) {
                        eyeIcon.innerHTML = `
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                        `;
                    } else {
                        eyeIcon.innerHTML = `
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        `;
                    }
                });
            }

            // Submit form animation
            const loginForm = document.getElementById('loginForm');
            if (loginForm) {
                loginForm.addEventListener('submit', function() {
                    const btn = document.getElementById('loginBtn');
                    const spinner = document.getElementById('btnSpinner');
                    const text = document.getElementById('btnText');
                    setTimeout(() => {
                        if (btn) btn.disabled = true;
                    }, 0);
                    if (spinner) spinner.classList.remove('hidden');
                    if (text) text.textContent = 'Login...';
                });
            }
        }
    </script>

</body>
</html>
