<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP | KPRO</title>
    <meta name="turbo-cache-control" content="no-cache">
    <link rel="icon" href="https://www.telkom.co.id/minio/show/data/image_upload/page/1594112895830_compress_PNG%20Icon%20Telkom.png" type="image/png">

    <!-- Fonts -->
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

        .app-detail {
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--text-muted);
            margin-top: 0.25rem;
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

        .form-container {
            max-width: 360px;
            width: 100%;
        }

        .logo-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 2rem;
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

        .form-instructions {
            font-size: 0.85rem;
            color: var(--text-muted);
            line-height: 1.5;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .form-instructions strong {
            color: var(--text-dark);
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
            margin-bottom: 0.5rem;
            text-align: center;
        }

        .input-wrapper {
            position: relative;
            display: flex;
            justify-content: center;
        }

        .form-input-otp {
            width: 80%;
            height: 50px;
            border: none;
            border-bottom: 2px solid #cbd5e1;
            background: transparent;
            font-size: 1.75rem;
            color: var(--text-dark);
            font-weight: 800;
            text-align: center;
            letter-spacing: 0.4em;
            padding-left: 0.4em; /* offset letter-spacing on last char */
            outline: none;
            transition: var(--transition);
        }

        .form-input-otp:focus {
            border-bottom-color: var(--border-focus);
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

        .success-alert {
            padding: 0.75rem 1rem;
            background-color: #f0fdf4;
            border: 1.5px solid #86efac;
            border-radius: 8px;
            display: flex;
            align-items: flex-start;
            gap: 0.6rem;
            margin-bottom: 1.5rem;
        }

        .success-alert svg {
            color: #16a34a;
            flex-shrink: 0;
            width: 16px;
            height: 16px;
            margin-top: 1px;
        }

        .success-alert p {
            font-size: 0.8rem;
            color: #14532d;
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
        }

        .link-item a {
            color: var(--primary);
            font-weight: 700;
            text-decoration: none;
        }

        .link-item a:hover {
            text-decoration: underline;
        }

        .btn-resend-link {
            background: none;
            border: none;
            color: var(--primary);
            font-size: 0.825rem;
            font-weight: 700;
            cursor: pointer;
            padding: 0;
            text-decoration: none;
            transition: var(--transition);
        }

        .btn-resend-link:hover {
            text-decoration: underline;
        }

        .btn-resend-link:disabled {
            color: var(--text-muted);
            cursor: not-allowed;
            text-decoration: none;
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
        
        <!-- Left Panel: Information & Image Showcase -->
        <div class="left-panel">
            <div class="left-overlay"></div>
            <div class="blob blob-1"></div>
            <div class="blob blob-2"></div>
            <div class="blob blob-3"></div>

            <div class="left-content">
                <p class="welcome-label">Verifikasi OTP</p>
                <h1 class="app-title">KPRO <span>MONITORING</span></h1>
                <p class="app-detail">Witel Cirebon - Telkom Indonesia</p>
            </div>
        </div>

        <!-- Right Panel: Form Section -->
        <div class="right-panel">
            <div class="form-container">
                
                <div class="logo-section stagger-1">
                    <img class="brand-logo-img" src="https://www.telkom.co.id/minio/show/data/image_upload/page/1594112895830_compress_PNG%20Icon%20Telkom.png" alt="Telkom Logo">
                    <div class="form-caption">Verifikasi OTP</div>
                </div>

                <div class="form-instructions stagger-2">
                    Kami telah mengirimkan 6 digit kode OTP ke email <strong>{{ $email }}</strong>. Silakan masukkan kode tersebut di bawah.
                </div>

                @if (session('status'))
                    <div class="success-alert stagger-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p>{{ session('status') }}</p>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="error-alert stagger-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                        </svg>
                        <p>{{ $errors->first() }}</p>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.verify.post') }}" id="verifyForm" data-turbo="false">
                    @csrf

                    <!-- OTP Code field -->
                    <div class="form-group stagger-3">
                        <label for="code" class="form-label">Masukkan 6 Digit OTP</label>
                        <div class="input-wrapper">
                            <input type="text" name="code" id="code" required autocomplete="off"
                                maxlength="6" pattern="\d{6}"
                                placeholder="------"
                                class="form-input-otp">
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" id="submitBtn" class="btn-submit stagger-4">
                        <svg id="btnSpinner" class="spinner hidden" style="width:16px;height:16px" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle style="opacity:.25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path style="opacity:.75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span id="btnText">Verifikasi Kode</span>
                    </button>
                </form>

                <!-- Resend Link Section with JavaScript Countdown -->
                <div class="form-footer-links stagger-5">
                    <form method="POST" action="{{ route('password.resend') }}" id="resendForm" class="hidden" data-turbo="false"></form>
                    
                    <span class="link-item" id="cooldownText">
                        Tidak menerima kode? Kirim ulang dalam <span id="timer">{{ $secondsRemaining }}</span> detik.
                    </span>
                    
                    <span class="link-item hidden" id="resendContainer">
                        Tidak menerima kode? <button type="button" class="btn-resend-link" onclick="submitResendForm()">Kirim Ulang Kode</button>
                    </span>

                    <span class="link-item" style="margin-top: 0.5rem;">
                        Kembali ke <a href="{{ route('password.request') }}" data-turbo="false">Lupa Password</a>
                    </span>
                </div>

            </div>
        </div>

    </div>

    <script>
        {
            // Handle Submit Loading state
            const verifyForm = document.getElementById('verifyForm');
            if (verifyForm) {
                verifyForm.addEventListener('submit', function() {
                    const btn = document.getElementById('submitBtn');
                    const spinner = document.getElementById('btnSpinner');
                    const text = document.getElementById('btnText');
                    setTimeout(() => {
                        if (btn) btn.disabled = true;
                    }, 0);
                    if (spinner) spinner.classList.remove('hidden');
                    if (text) text.textContent = 'Memverifikasi...';
                });
            }

            // OTP validation (only allows numbers)
            const otpInput = document.getElementById('code');
            if (otpInput) {
                otpInput.addEventListener('input', function(e) {
                    this.value = this.value.replace(/[^0-9]/g, '');
                });
            }

            // Countdown timer script
            let timeRemaining = parseInt("{{ $secondsRemaining }}", 10);
            const timerSpan = document.getElementById('timer');
            const cooldownText = document.getElementById('cooldownText');
            const resendContainer = document.getElementById('resendContainer');

            function updateTimer() {
                if (timeRemaining <= 0) {
                    if (cooldownText) cooldownText.classList.add('hidden');
                    if (resendContainer) resendContainer.classList.remove('hidden');
                } else {
                    if (timerSpan) timerSpan.textContent = timeRemaining;
                    timeRemaining--;
                    setTimeout(updateTimer, 1000);
                }
            }

            updateTimer();
        }

        function submitResendForm() {
            const form = document.getElementById('resendForm');
            if (form) {
                // Prevent duplicate clicks
                const resendBtn = document.querySelector('.btn-resend-link');
                if (resendBtn) resendBtn.disabled = true;
                
                // Add CSRF to resendForm dynamic setup
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = "{{ csrf_token() }}";
                form.appendChild(csrfInput);
                
                form.submit();
            }
        }
    </script>

</body>
</html>
