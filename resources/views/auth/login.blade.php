<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <meta name="turbo-cache-control" content="no-cache">
    <link rel="icon" href="https://www.telkom.co.id/minio/show/data/image_upload/page/1594112895830_compress_PNG%20Icon%20Telkom.png" type="image/png">

    <!-- PWA Settings -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#ffffff">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * { font-family: 'Inter', sans-serif; box-sizing: border-box; }

        .auth-body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            background: linear-gradient(rgba(15, 23, 42, 0.75), rgba(15, 23, 42, 0.75)), url('{{ asset("images/hero-banner.jpg") }}') no-repeat center center fixed;
            background-size: cover;
        }

        @keyframes fadeInScale {
            from { opacity: 0; transform: scale(0.97) translateY(8px); }
            to   { opacity: 1; transform: scale(1) translateY(0); }
        }
        @keyframes slideInLeft {
            from { opacity: 0; transform: translateX(-20px); }
            to   { opacity: 1; transform: translateX(0); }
        }
        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(20px); }
            to   { opacity: 1; transform: translateX(0); }
        }

        /* ── Main card ── */
        .auth-card {
            position: relative;
            display: flex;
            width: 100%;
            max-width: 900px;
            min-height: 520px;
            border-radius: 28px;
            overflow: hidden;
            background: #ffffff;
            flex-direction: row-reverse;
            box-shadow:
                0 20px 60px rgba(0, 0, 0, 0.10),
                0 4px 20px rgba(0, 0, 0, 0.06),
                0 0 0 1px rgba(0,0,0,0.06);
            animation: fadeInScale 0.6s cubic-bezier(0.22, 1, 0.36, 1) forwards;
        }

        /* ── Left: Form panel ── */
        .form-panel {
            flex: 1;
            background: #ffffff;
            padding: 3rem 2.5rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        /* ── Right: Info panel ── */
        .info-panel {
            width: 340px;
            background: linear-gradient(145deg, #dc2626 0%, #b91c1c 40%, #7f1d1d 100%);
            padding: 3rem 2.5rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .info-panel::before {
            content: '';
            position: absolute;
            width: 350px; height: 350px;
            background: rgba(255,255,255,0.06);
            border-radius: 50%;
            top: -100px; right: -100px;
        }
        .info-panel::after {
            content: '';
            position: absolute;
            width: 250px; height: 250px;
            background: rgba(255,255,255,0.05);
            border-radius: 50%;
            bottom: -80px; left: -80px;
        }

        /* ── Form elements ── */
        .form-title {
            font-size: 1.75rem;
            font-weight: 800;
            color: #1a1a2e;
            letter-spacing: -0.5px;
            margin-bottom: 0.4rem;
        }
        .form-subtitle {
            font-size: 0.875rem;
            color: #94a3b8;
            margin-bottom: 2rem;
        }

        .form-group { margin-bottom: 1.1rem; }
        .form-label {
            display: block;
            font-size: 0.7rem;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-bottom: 0.5rem;
        }
        .input-wrap { position: relative; }
        .input-icon {
            position: absolute;
            left: 0.875rem;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            width: 16px;
            height: 16px;
            pointer-events: none;
        }
        .form-input {
            width: 100%;
            padding: 0.8rem 1rem 0.8rem 2.6rem;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            background: #f8fafc;
            font-size: 0.875rem;
            color: #1e293b;
            transition: all 0.2s ease;
            outline: none;
        }
        .form-input::placeholder { color: #cbd5e1; }
        .form-input:focus {
            background: #fff;
            border-color: #ef4444;
            box-shadow: 0 0 0 3px rgba(239,68,68,0.12);
        }
        .form-input:hover:not(:focus) { border-color: #cbd5e1; }

        .toggle-pass {
            position: absolute;
            right: 0.875rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #94a3b8;
            padding: 0;
            display: flex;
            align-items: center;
            transition: color 0.2s;
        }
        .toggle-pass:hover { color: #64748b; }

        .form-check {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1.25rem;
        }
        .form-check input[type="checkbox"] {
            width: 16px;
            height: 16px;
            border-radius: 4px;
            border: 1.5px solid #e2e8f0;
            accent-color: #dc2626;
            cursor: pointer;
        }
        .form-check label {
            font-size: 0.875rem;
            color: #64748b;
            cursor: pointer;
        }

        .btn-primary {
            width: 100%;
            padding: 0.9rem 1.5rem;
            background: linear-gradient(135deg, #dc2626 0%, #991b1b 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 0.9rem;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.6rem;
            box-shadow: 0 4px 20px rgba(220,38,38,0.4);
            transition: all 0.25s ease;
            position: relative;
            overflow: hidden;
        }
        .btn-primary::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, transparent 50%);
            opacity: 0;
            transition: opacity 0.2s;
        }
        .btn-primary:hover:not(:disabled)::before { opacity: 1; }
        .btn-primary:hover:not(:disabled) {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(220,38,38,0.55);
        }
        .btn-primary:active:not(:disabled) { transform: translateY(0); }
        .btn-primary:disabled { opacity: 0.75; cursor: not-allowed; }

        .error-box {
            padding: 0.75rem 1rem;
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 10px;
            display: flex;
            align-items: flex-start;
            gap: 0.6rem;
            margin-bottom: 1.25rem;
        }
        .error-box p { font-size: 0.8rem; color: #b91c1c; font-weight: 500; }

        .divider {
            margin: 1.5rem 0 1.2rem;
            border: none;
            border-top: 1px solid #f1f5f9;
        }
        .form-footer {
            text-align: center;
            font-size: 0.875rem;
            color: #94a3b8;
        }
        .form-footer a {
            color: #dc2626;
            font-weight: 700;
            text-decoration: none;
            margin-left: 0.25rem;
            transition: color 0.2s;
        }
        .form-footer a:hover { color: #b91c1c; }

        /* ── Info panel content ── */
        .info-logo {
            width: 70px;
            height: 70px;
            background: rgba(255,255,255,0.15);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.75rem;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
        }
        .info-logo img { width: 46px; }
        .info-title {
            font-size: 1.6rem;
            font-weight: 800;
            color: #fff;
            margin-bottom: 0.75rem;
            line-height: 1.2;
            position: relative;
            z-index: 1;
        }
        .info-desc {
            font-size: 0.875rem;
            color: rgba(255,255,255,0.75);
            line-height: 1.65;
            margin-bottom: 2rem;
            position: relative;
            z-index: 1;
        }
        .info-btn {
            display: inline-block;
            padding: 0.7rem 2rem;
            border: 2px solid rgba(255,255,255,0.6);
            color: #fff;
            border-radius: 10px;
            font-size: 0.8rem;
            font-weight: 700;
            text-decoration: none;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            transition: all 0.25s ease;
            position: relative;
            z-index: 1;
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(6px);
        }
        .info-btn:hover {
            background: rgba(255,255,255,0.25);
            border-color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        }

        /* ── Spinner ── */
        @keyframes spin { to { transform: rotate(360deg); } }
        .spinner { animation: spin 0.8s linear infinite; }

        /* ── Mobile: stack vertically ── */
        @media (max-width: 768px) {
            .auth-body {
                padding: 0;
                align-items: stretch;
                background: #fff;
            }
            .auth-card {
                flex-direction: column;
                border-radius: 0;
                max-width: 100%;
                min-height: auto;
                box-shadow: none;
                animation: none;
                opacity: 1;
            }
            .info-panel {
                width: 100%;
                padding: 2rem 1.25rem 3.5rem;
                min-height: auto;
                animation: none;
                opacity: 1;
                border-radius: 0;
            }
            .form-panel {
                padding: 2rem 1.25rem 2.5rem;
                flex: 1;
                animation: none;
                opacity: 1;
                justify-content: flex-start;
                border-radius: 28px 28px 0 0;
                margin-top: -28px;
                position: relative;
                z-index: 1;
            }
            .info-title { font-size: 1.25rem; }
            .info-logo { width: 56px; height: 56px; margin-bottom: 1.25rem; }
            .info-logo img { width: 36px; }
            .form-title { font-size: 1.5rem; }
        }

        @media (max-width: 400px) {
            .form-panel { padding: 1.75rem 1rem 2rem; }
            .info-panel { padding: 1.5rem 1rem; }
        }
    </style>
</head>

<body class="auth-body">

    <!-- Main Card -->
    <div class="auth-card">

        <!-- ══ LEFT: Info Panel ══ -->
        <div class="info-panel">
            <h2 class="info-title">Halo,<br>Selamat Datang!</h2>
            <p class="info-desc">
               Masuk untuk mengakses dashboard monitoring
            </p>
        </div>

        <!-- ══ RIGHT: Form Panel ══ -->
        <div class="form-panel">
            
            {{-- Error Alert --}}
            @if ($errors->any())
                <div class="error-box">
                    <svg xmlns="http://www.w3.org/2000/svg" style="width:16px;height:16px;color:#ef4444;flex-shrink:0;margin-top:1px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                    </svg>
                    <p>Email atau password salah. Silakan coba lagi.</p>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" id="loginForm">
                @csrf

                {{-- Email --}}
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <div class="input-wrap">
                        <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                        </svg>
                        <input type="email" name="email" id="email" required autofocus
                            value="{{ old('email') }}"
                            placeholder="nama@telkom.co.id"
                            class="form-input">
                    </div>
                </div>

                {{-- Password --}}
                <div class="form-group">
                    <label class="form-label">Password</label>
                    <div class="input-wrap">
                        <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                        </svg>
                        <input type="password" name="password" id="passwordInput" required
                            placeholder="••••••••"
                            class="form-input" style="padding-right:2.6rem">
                        <button type="button" id="togglePassword" class="toggle-pass">
                            <svg xmlns="http://www.w3.org/2000/svg" style="width:16px;height:16px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Remember --}}
                <div class="form-check">
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember">Ingat saya</label>
                </div>

                {{-- Submit --}}
                <button type="submit" id="loginBtn" class="btn-primary">
                    <svg id="btnSpinner" class="spinner hidden" style="width:16px;height:16px" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle style="opacity:.25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path style="opacity:.75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span id="btnText">Masuk</span>
                </button>
            </form>

            <hr class="divider">
            <p class="form-footer">
                Belum punya akun?
                <a href="{{ route('register') }}">Daftar Sekarang </a>
            </p>
        </div>

    </div>

    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            const inp = document.getElementById('passwordInput');
            inp.type = inp.type === 'password' ? 'text' : 'password';
        });

        document.getElementById('loginForm').addEventListener('submit', function() {
            const btn = document.getElementById('loginBtn');
            const spinner = document.getElementById('btnSpinner');
            const text = document.getElementById('btnText');
            btn.disabled = true;
            spinner.classList.remove('hidden');
            text.textContent = 'Masuk...';
        });
    </script>

    {{-- Service Worker Registration for PWA --}}
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js')
                    .then(registration => {
                        console.log('ServiceWorker registration successful with scope: ', registration.scope);
                    })
                    .catch(err => {
                        console.log('ServiceWorker registration failed: ', err);
                    });
            });
        }
    </script>
</body>
</html>
