<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password </title>
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
        }

        .link-item a {
            color: var(--primary);
            font-weight: 700;
            text-decoration: none;
        }

        .link-item a:hover {
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
                <p class="welcome-label">Lupa Kata Sandi?</p>
                <h1 class="app-title">PORTAL <span>MONITORING</span></h1>
                <p class="app-detail">Witel Cirebon - Telkom Indonesia</p>
            </div>
        </div>

        
        <div class="right-panel">
            <div class="form-container">
                
                <div class="logo-section stagger-1">
                    <img class="brand-logo-img" src="https://www.telkom.co.id/minio/show/data/image_upload/page/1594112895830_compress_PNG%20Icon%20Telkom.png" alt="Telkom Logo">
                    <div class="form-caption">Reset Kata Sandi</div>
                </div>

                <div class="form-instructions stagger-2">
                    Masukkan email Anda yang terdaftar. Kami akan mengirimkan kode verifikasi (OTP) untuk mereset kata sandi Anda.
                </div>

                @if ($errors->any())
                    <div class="error-alert stagger-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                        </svg>
                        <p>{{ $errors->first() }}</p>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}" id="forgotForm" data-turbo="false">
                    @csrf

                    
                    <div class="form-group stagger-3">
                        <label for="email" class="form-label">Alamat Email</label>
                        <div class="input-wrapper">
                            <input type="email" name="email" id="email" required autofocus
                                value="{{ old('email') }}"
                                placeholder="Masukkan Email Anda"
                                class="form-input">
                        </div>
                    </div>

                    
                    <button type="submit" id="submitBtn" class="btn-submit stagger-4">
                        <svg id="btnSpinner" class="spinner hidden" style="width:16px;height:16px" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle style="opacity:.25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path style="opacity:.75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span id="btnText">Kirim Kode OTP</span>
                    </button>
                </form>

                <div class="form-footer-links stagger-5">
                    <span class="link-item">
                        Kembali ke <a href="{{ route('login') }}" data-turbo="false">Login</a>
                    </span>
                </div>

            </div>
        </div>

    </div>

    <script>
        {
            const forgotForm = document.getElementById('forgotForm');
            if (forgotForm) {
                forgotForm.addEventListener('submit', function() {
                    const btn = document.getElementById('submitBtn');
                    const spinner = document.getElementById('btnSpinner');
                    const text = document.getElementById('btnText');
                    setTimeout(() => {
                        if (btn) btn.disabled = true;
                    }, 0);
                    if (spinner) spinner.classList.remove('hidden');
                    if (text) text.textContent = 'Mengirim...';
                });
            }
        }
    </script>

</body>
</html>
