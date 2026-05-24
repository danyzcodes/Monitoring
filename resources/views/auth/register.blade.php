<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar | KPRO</title>
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

        /* Split Layout Container */
        .split-container {
            display: flex;
            width: 100%;
            min-height: 100vh;
        }

        /* Left Panel (Visual Showcase) */
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

        /* White wash overlay + soft blurry red blobs matching user screenshot */
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

        /* Content inside Left Panel */
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

        /* Right Panel (Form Showcase) */
        .right-panel {
            width: 40%;
            background: #ffffff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 3rem 2rem;
            position: relative;
            z-index: 5;
            box-shadow: -10px 0 30px rgba(0, 0, 0, 0.02);
            overflow-y: auto;
            animation: fadeInLeft 0.9s cubic-bezier(0.25, 1, 0.5, 1) forwards;
        }

        .right-panel::-webkit-scrollbar {
            display: none;
        }
        .right-panel {
            scrollbar-width: none;
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

        /* Staggered entrance for form elements */
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
        .stagger-7 { animation: fadeInUp 0.8s cubic-bezier(0.25, 1, 0.5, 1) 0.7s both; }
        .stagger-8 { animation: fadeInUp 0.8s cubic-bezier(0.25, 1, 0.5, 1) 0.8s both; }

        .form-container {
            max-width: 360px;
            width: 100%;
        }

        /* Header Logo & Red Title */
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

        /* Input Controls - Minimalist bottom-bordered matching user screenshot */
        .form-group {
            margin-bottom: 1.25rem;
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
            height: 38px;
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

        /* Dropdown Select (Bottom-bordered matching inputs) */
        .form-select {
            width: 100%;
            height: 38px;
            border: none;
            border-bottom: 1.5px solid #cbd5e1;
            border-radius: 0;
            background: transparent;
            padding: 0.5rem 2rem 0.5rem 0.25rem;
            font-size: 0.95rem;
            color: var(--text-dark);
            font-weight: 500;
            transition: var(--transition);
            outline: none;
            cursor: pointer;
            appearance: none;
            -webkit-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2394a3b8' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 0.25rem center;
            background-size: 1.1rem;
        }

        .form-select:focus {
            border-bottom-color: var(--border-focus);
        }

        .form-select option {
            color: var(--text-dark);
            background-color: #ffffff;
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

        /* Info notice box (Compact) */
        .info-note {
            display: flex;
            align-items: flex-start;
            gap: 0.6rem;
            padding: 0.65rem 0.85rem;
            background-color: #fffbeb;
            border: 1px solid #fde68a;
            border-radius: 8px;
            margin-bottom: 1.25rem;
        }

        .info-note svg {
            color: #d97706;
            flex-shrink: 0;
            width: 16px;
            height: 16px;
            margin-top: 1px;
        }

        .info-note p {
            font-size: 0.78rem;
            color: #92400e;
            font-weight: 500;
            line-height: 1.4;
        }

        /* Submit Button */
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

        /* Error Alert box */
        .error-alert {
            padding: 0.75rem 1rem;
            background-color: var(--primary-light);
            border: 1.5px solid #fca5a5;
            border-radius: 8px;
            margin-bottom: 1.25rem;
            animation: shake 0.4s ease-in-out;
        }

        .error-alert-content {
            display: flex;
            align-items: flex-start;
            gap: 0.6rem;
        }

        .error-alert svg {
            color: var(--primary);
            flex-shrink: 0;
            width: 16px;
            height: 16px;
            margin-top: 1px;
        }

        .error-alert p {
            font-size: 0.78rem;
            color: #991b1b;
            font-weight: 600;
            line-height: 1.45;
            margin-bottom: 0.2rem;
        }

        .error-alert p:last-child {
            margin-bottom: 0;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-3px); }
            75% { transform: translateX(3px); }
        }

        /* Footer links */
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

        /* Spinner Loading */
        .spinner {
            animation: spin 0.8s linear infinite;
        }

        .hidden {
            display: none !important;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Responsive Design */
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
                <p class="welcome-label">Selamat Datang di</p>
                <h1 class="app-title">KPRO <span>MONITORING</span></h1>
                <p class="app-detail">Witel Cirebon - Telkom Indonesia</p>
            </div>

            
        </div>

        <!-- Right Panel: Form Section -->
        <div class="right-panel">
            <div class="form-container">
                
                <div class="logo-section stagger-1">
                    <img class="brand-logo-img" src="https://www.telkom.co.id/minio/show/data/image_upload/page/1594112895830_compress_PNG%20Icon%20Telkom.png" alt="Telkom Logo">
                    <div class="form-caption">Portal Monitoring </div>
                </div>

                @if ($errors->any())
                    <div class="error-alert">
                        <div class="error-alert-content">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                            </svg>
                            <div>
                                @foreach ($errors->all() as $error)
                                    <p>{{ $error }}</p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" id="registerForm">
                    @csrf

                    <!-- Nama Lengkap field -->
                    <div class="form-group stagger-2">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <div class="input-wrapper">
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required autofocus
                                placeholder="Nama Lengkap"
                                class="form-input">
                        </div>
                    </div>

                    <!-- Email field -->
                    <div class="form-group stagger-3">
                        <label for="email" class="form-label">Email</label>
                        <div class="input-wrapper">
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                placeholder="Email"
                                class="form-input">
                        </div>
                    </div>

                    <!-- Role select -->
                    <div class="form-group stagger-4">
                        <label for="role" class="form-label">Role</label>
                        <div class="input-wrapper">
                            <select name="role" id="role" required class="form-select">
                                <option value="" disabled selected>Pilih Role</option>
                                <option value="optima"       {{ old('role')=='optima'       ?'selected':'' }}>Optima</option>
                                <option value="tif"          {{ old('role')=='tif'          ?'selected':'' }}>TIF</option>
                                <option value="telkom_akses" {{ old('role')=='telkom_akses' ?'selected':'' }}>Telkom Akses</option>
                            </select>
                        </div>
                    </div>

                    <!-- Password field -->
                    <div class="form-group stagger-5">
                        <label for="passInput" class="form-label">Password</label>
                        <div class="input-wrapper">
                            <input type="password" name="password" id="passInput" required
                                placeholder="Min. 8 karakter"
                                class="form-input" style="padding-right: 2rem;">
                            <button type="button" id="togglePass" class="toggle-password" tabindex="-1">
                                <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" style="width:16px;height:16px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Confirm Password field -->
                    <div class="form-group stagger-6">
                        <label for="passConfirmInput" class="form-label">Konfirmasi Password</label>
                        <div class="input-wrapper">
                            <input type="password" name="password_confirmation" id="passConfirmInput" required
                                placeholder="Konfirmasi Password"
                                class="form-input" style="padding-right: 2rem;">
                            <button type="button" id="togglePassConfirm" class="toggle-password" tabindex="-1">
                                <svg id="eyeConfirmIcon" xmlns="http://www.w3.org/2000/svg" style="width:16px;height:16px" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Admin Approval Notice -->
                    <div class="info-note stagger-7">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p>Akun baru memerlukan persetujuan admin sebelum dapat digunakan.</p>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" id="registerBtn" class="btn-submit stagger-8">
                        <svg id="regSpinner" class="spinner hidden" style="width:16px;height:16px" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle style="opacity:.25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path style="opacity:.75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span id="regText">Daftar Sekarang</span>
                    </button>
                </form>

                <div class="form-footer-links stagger-8">
                    <span class="link-item">
                        Sudah memiliki akun? <a href="{{ route('login') }}">Masuk</a>
                    </span>
                </div>

            </div>
        </div>

    </div>

    <script>
        {
            // Password toggles
            const togglePass = document.getElementById('togglePass');
            const passInput = document.getElementById('passInput');
            const eyeIcon = document.getElementById('eyeIcon');

            if (togglePass && passInput && eyeIcon) {
                togglePass.addEventListener('click', function() {
                    const isPassword = passInput.type === 'password';
                    passInput.type = isPassword ? 'text' : 'password';
                    
                    if (isPassword) {
                        eyeIcon.innerHTML = `
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                        `;
                    } else {
                        eyeIcon.innerHTML = `
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                        `;
                    }
                });
            }

            const togglePassConfirm = document.getElementById('togglePassConfirm');
            const passConfirmInput = document.getElementById('passConfirmInput');
            const eyeConfirmIcon = document.getElementById('eyeConfirmIcon');

            if (togglePassConfirm && passConfirmInput && eyeConfirmIcon) {
                togglePassConfirm.addEventListener('click', function() {
                    const isPassword = passConfirmInput.type === 'password';
                    passConfirmInput.type = isPassword ? 'text' : 'password';
                    
                    if (isPassword) {
                        eyeConfirmIcon.innerHTML = `
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                        `;
                    } else {
                        eyeConfirmIcon.innerHTML = `
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                        `;
                    }
                });
            }

            // Submit form animation
            const registerForm = document.getElementById('registerForm');
            if (registerForm) {
                registerForm.addEventListener('submit', function() {
                    const btn = document.getElementById('registerBtn');
                    const spinner = document.getElementById('regSpinner');
                    const text = document.getElementById('regText');
                    setTimeout(() => {
                        if (btn) btn.disabled = true;
                    }, 0);
                    if (spinner) spinner.classList.remove('hidden');
                    if (text) text.textContent = 'Mendaftar...';
                });
            }
        }
    </script>

</body>
</html>
