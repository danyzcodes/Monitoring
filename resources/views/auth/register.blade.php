<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <meta name="turbo-cache-control" content="no-cache">
    <link rel="icon" href="https://www.telkom.co.id/minio/show/data/image_upload/page/1594112895830_compress_PNG%20Icon%20Telkom.png" type="image/png">
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
        @keyframes spin { to { transform: rotate(360deg); } }

        .auth-card {
            position: relative;
            display: flex; width: 100%; max-width: 960px;
            border-radius: 28px; overflow: hidden;
            background: #ffffff;
            box-shadow: 0 20px 60px rgba(0,0,0,.10), 0 4px 20px rgba(0,0,0,.06), 0 0 0 1px rgba(0,0,0,.06);
            animation: fadeInScale 0.6s cubic-bezier(.22,1,.36,1) forwards;
        }

        /* ── Left: Info panel ── */
        .info-panel {
            width: 320px; flex-shrink: 0;
            background: linear-gradient(145deg, #dc2626 0%, #b91c1c 40%, #7f1d1d 100%);
            padding: 3rem 2.2rem;
            display: flex; flex-direction: column;
            align-items: center; justify-content: center; text-align: center;
            position: relative; overflow: hidden;
        }
        .info-panel::before {
            content:''; position:absolute;
            width:320px;height:320px;background:rgba(255,255,255,.06);
            border-radius:50%;top:-100px;left:-100px;
        }
        .info-panel::after {
            content:''; position:absolute;
            width:220px;height:220px;background:rgba(255,255,255,.05);
            border-radius:50%;bottom:-70px;right:-70px;
        }

        .info-logo {
            width:70px;height:70px;
            background:rgba(255,255,255,.15); border-radius:20px;
            display:flex;align-items:center;justify-content:center;
            margin:0 auto 1.75rem;
            backdrop-filter:blur(10px);
            border:1px solid rgba(255,255,255,.2);
        }
        .info-logo img { width:46px; }
        .info-title {
            font-size:1.5rem;font-weight:800;color:#fff;
            margin-bottom:.75rem;line-height:1.25;position:relative;z-index:1;
        }
        .info-desc {
            font-size:.85rem;color:rgba(255,255,255,.75);
            line-height:1.65;margin-bottom:2rem;position:relative;z-index:1;
        }
        .info-btn {
            display:inline-block;padding:.65rem 1.75rem;
            border:2px solid rgba(255,255,255,.6);color:#fff;
            border-radius:10px;font-size:.78rem;font-weight:700;
            text-decoration:none;letter-spacing:.08em;text-transform:uppercase;
            background:rgba(255,255,255,.1);backdrop-filter:blur(6px);
            position:relative;z-index:1;transition:all .25s ease;
        }
        .info-btn:hover {
            background:rgba(255,255,255,.25);border-color:#fff;
            transform:translateY(-2px);box-shadow:0 8px 20px rgba(0,0,0,.2);
        }

        /* ── Right: Form panel ── */
        .form-panel {
            flex:1; background:#fff;
            padding:2.5rem 2.5rem;
            display:flex; flex-direction:column; justify-content:center;
            overflow-y:auto; max-height:100vh;
        }
        /* hide scrollbar */
        .form-panel::-webkit-scrollbar { display:none; }
        .form-panel { scrollbar-width:none; }

        .form-title { font-size:1.65rem;font-weight:800;color:#1a1a2e;letter-spacing:-.5px;margin-bottom:.35rem; }
        .form-subtitle { font-size:.875rem;color:#94a3b8;margin-bottom:1.5rem; }

        .form-group { margin-bottom:.95rem; }
        .form-label {
            display:block;font-size:.68rem;font-weight:700;color:#64748b;
            text-transform:uppercase;letter-spacing:.1em;margin-bottom:.45rem;
        }
        .input-wrap { position:relative; }
        .input-icon {
            position:absolute;left:.875rem;top:50%;transform:translateY(-50%);
            color:#94a3b8;width:16px;height:16px;pointer-events:none;
        }
        .form-input {
            width:100%;padding:.78rem 1rem .78rem 2.5rem;
            border:1.5px solid #e2e8f0;border-radius:12px;
            background:#f8fafc;font-size:.875rem;color:#1e293b;
            transition:all .2s ease;outline:none;
        }
        .form-input::placeholder { color:#cbd5e1; }
        .form-input:focus { background:#fff;border-color:#ef4444;box-shadow:0 0 0 3px rgba(239,68,68,.12); }
        .form-select {
            width:100%;padding:.78rem 2.5rem .78rem 2.5rem;
            border:1.5px solid #e2e8f0;border-radius:12px;
            background:#f8fafc;font-size:.875rem;color:#1e293b;
            transition:all .2s ease;outline:none;cursor:pointer;
            appearance:none;-webkit-appearance:none;
            background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2394a3b8' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
            background-repeat:no-repeat;background-position:right .85rem center;background-size:1rem;
            padding-right:2.5rem;
        }
        .form-select:focus { background-color:#fff;border-color:#ef4444;box-shadow:0 0 0 3px rgba(239,68,68,.12); }

        .toggle-pass {
            position:absolute;right:.875rem;top:50%;transform:translateY(-50%);
            background:none;border:none;cursor:pointer;color:#94a3b8;
            padding:0;display:flex;align-items:center;transition:color .2s;
        }
        .toggle-pass:hover { color:#64748b; }

        .btn-primary {
            width:100%;padding:.85rem 1.5rem;
            background:linear-gradient(135deg,#dc2626 0%,#991b1b 100%);
            color:#fff;border:none;border-radius:12px;
            font-size:.9rem;font-weight:700;cursor:pointer;
            display:flex;align-items:center;justify-content:center;gap:.6rem;
            box-shadow:0 4px 20px rgba(220,38,38,.4);
            transition:all .25s ease;position:relative;overflow:hidden;
        }
        .btn-primary:hover:not(:disabled) { transform:translateY(-2px);box-shadow:0 8px 30px rgba(220,38,38,.55); }
        .btn-primary:disabled { opacity:.75;cursor:not-allowed; }

        .error-box {
            padding:.75rem 1rem;background:#fef2f2;border:1px solid #fecaca;
            border-radius:10px;display:flex;align-items:flex-start;gap:.6rem;margin-bottom:1.1rem;
        }
        .error-box p { font-size:.8rem;color:#b91c1c;font-weight:500;margin:0; }

        .info-note {
            display:flex;align-items:flex-start;gap:.6rem;
            padding:.65rem .9rem;background:#fffbeb;border:1px solid #fde68a;
            border-radius:10px;margin-bottom:1rem;
        }
        .info-note p { font-size:.78rem;color:#92400e;line-height:1.5;margin:0; }

        .divider { margin:1.25rem 0 1rem;border:none;border-top:1px solid #f1f5f9; }
        .form-footer { text-align:center;font-size:.875rem;color:#94a3b8; }
        .form-footer a { color:#dc2626;font-weight:700;text-decoration:none;margin-left:.25rem;transition:color .2s; }
        .form-footer a:hover { color:#b91c1c; }

        .spinner { animation:spin .8s linear infinite; }

        /* two-column grid for password fields */
        .grid-2 { display:grid;grid-template-columns:1fr 1fr;gap:.75rem; }

        @media (max-width:768px) {
            .auth-body { padding:0; align-items:stretch; background:#fff; }
            .auth-card {
                flex-direction:column;
                border-radius:0; max-width:100%; min-height:auto;
                box-shadow:none; animation:none; opacity:1;
            }
            .info-panel { width:100%; padding:1.75rem 1.25rem 3.5rem; min-height:auto; animation:none; opacity:1; border-radius:0; }
            .form-panel { padding:2rem 1.25rem 2.5rem; max-height:none; overflow-y:visible; animation:none; opacity:1; flex:1; justify-content:flex-start; border-radius:28px 28px 0 0; margin-top:-28px; position:relative; z-index:1; }
            .grid-2 { grid-template-columns:1fr; }
            .info-title { font-size:1.25rem; }
            .form-title { font-size:1.5rem; }
        }
        @media (max-width:400px) {
            .form-panel { padding:1.75rem 1rem 2rem; }
            .info-panel { padding:1.5rem 1rem; }
        }
    </style>
</head>
<body class="auth-body">

    <div class="auth-card">

        <!-- ══ LEFT: Info Panel ══ -->
        <div class="info-panel">
           
            <h2 class="info-title">Daftar<br>Sekarang!</h2>
            <p class="info-desc">
                Daftarkan diri Anda untuk bergabung
            </p>
            
        </div>

        <!-- ══ RIGHT: Form Panel ══ -->
        <div class="form-panel">

        

            @if ($errors->any())
                <div class="error-box">
                    <svg xmlns="http://www.w3.org/2000/svg" style="width:16px;height:16px;color:#ef4444;flex-shrink:0;margin-top:1px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                    </svg>
                    <div>
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" id="registerForm">
                @csrf

                {{-- Nama --}}
                <div class="form-group">
                    <label class="form-label">Nama Lengkap</label>
                    <div class="input-wrap">
                        <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                        </svg>
                        <input type="text" name="name" value="{{ old('name') }}" required autofocus
                            placeholder="Masukkan nama lengkap"
                            class="form-input">
                    </div>
                </div>

                {{-- Email --}}
                <div class="form-group">
                    <label class="form-label">Email</label>
                    <div class="input-wrap">
                        <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                        </svg>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            placeholder="nama@telkom.co.id"
                            class="form-input">
                    </div>
                </div>

                {{-- Role --}}
                <div class="form-group">
                    <label class="form-label">Role</label>
                    <div class="input-wrap">
                        <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                        </svg>
                        <select name="role" required class="form-select">
                            <option value="" disabled selected>Pilih Role</option>
                            <option value="optima"       {{ old('role')=='optima'       ?'selected':'' }}>Optima</option>
                            <option value="tif"          {{ old('role')=='tif'          ?'selected':'' }}>TIF</option>
                            <option value="telkom_akses" {{ old('role')=='telkom_akses' ?'selected':'' }}>Telkom Akses</option>
                        </select>
                    </div>
                </div>

                {{-- Password & Confirm side by side --}}
                <div class="grid-2">
                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <div class="input-wrap">
                            <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                            </svg>
                            <input type="password" name="password" id="passInput" required
                                placeholder="Min. 8 karakter"
                                class="form-input" style="padding-right:2.5rem">
                            <button type="button" id="togglePass" class="toggle-pass">
                                <svg xmlns="http://www.w3.org/2000/svg" style="width:15px;height:15px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Konfirmasi Password</label>
                        <div class="input-wrap">
                            <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <input type="password" name="password_confirmation" id="passConfirmInput" required
                                placeholder="Ulangi password"
                                class="form-input" style="padding-right:2.5rem">
                            <button type="button" id="togglePassConfirm" class="toggle-pass">
                                <svg xmlns="http://www.w3.org/2000/svg" style="width:15px;height:15px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Info note --}}
                <div class="info-note">
                    <svg xmlns="http://www.w3.org/2000/svg" style="width:14px;height:14px;color:#d97706;flex-shrink:0;margin-top:1px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                    </svg>
                    <p>Akun baru memerlukan persetujuan admin sebelum dapat digunakan.</p>
                </div>

                {{-- Submit --}}
                <button type="submit" id="registerBtn" class="btn-primary">
                    <svg id="regSpinner" class="spinner hidden" style="width:16px;height:16px" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle style="opacity:.25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path style="opacity:.75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span id="regText">Daftar Sekarang</span>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                    </svg>
                </button>
            </form>

            <hr class="divider">
            <p class="form-footer">
                Sudah punya akun?
                <a href="{{ route('login') }}">Masuk </a>
            </p>
        </div>
    </div>

    <script>
        document.getElementById('togglePass').addEventListener('click', function() {
            const i = document.getElementById('passInput');
            i.type = i.type === 'password' ? 'text' : 'password';
        });
        document.getElementById('togglePassConfirm').addEventListener('click', function() {
            const i = document.getElementById('passConfirmInput');
            i.type = i.type === 'password' ? 'text' : 'password';
        });
        document.getElementById('registerForm').addEventListener('submit', function() {
            const btn = document.getElementById('registerBtn');
            const spinner = document.getElementById('regSpinner');
            const text = document.getElementById('regText');
            const arrow = document.getElementById('regArrow');
            btn.disabled = true;
            spinner.classList.remove('hidden');
            arrow.classList.add('hidden');
            text.textContent = 'Mendaftar...';
        });
    </script>
</body>
</html>
