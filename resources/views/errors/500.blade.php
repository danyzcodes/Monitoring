<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 | Terjadi Kesalahan Server</title>
    <link rel="icon" href="https://www.telkom.co.id/minio/show/data/image_upload/page/1594112895830_compress_PNG%20Icon%20Telkom.png" type="image/png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #e32b2b;
            --primary-hover: #b81c1c;
            --text-dark: #1e293b;
            --text-muted: #64748b;
            --bg-gray: #f8fafc;
        }
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--bg-gray);
            color: var(--text-dark);
            padding: 1.5rem;
        }
        .error-card {
            background: #ffffff;
            padding: 3rem 2rem;
            border-radius: 16px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
            max-width: 480px;
            width: 100%;
            text-align: center;
            animation: fadeInUp 0.6s ease-out;
        }
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .logo-img {
            height: 50px;
            margin-bottom: 1.5rem;
        }
        .error-code {
            font-size: 6rem;
            font-weight: 800;
            color: var(--primary);
            line-height: 1;
            margin-bottom: 0.5rem;
            letter-spacing: -2px;
        }
        .error-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: var(--text-dark);
        }
        .error-desc {
            font-size: 0.95rem;
            color: var(--text-muted);
            line-height: 1.6;
            margin-bottom: 2rem;
        }
        .btn-back {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            height: 44px;
            padding: 0 1.5rem;
            background-color: var(--primary);
            color: #ffffff;
            border: none;
            border-radius: 8px;
            font-size: 0.95rem;
            font-weight: 700;
            text-decoration: none;
            box-shadow: 0 4px 12px rgba(227, 43, 43, 0.25);
            transition: all 0.2s ease-in-out;
        }
        .btn-back:hover {
            background-color: var(--primary-hover);
            box-shadow: 0 6px 16px rgba(227, 43, 43, 0.35);
            transform: translateY(-1px);
        }
        .btn-back:active {
            transform: translateY(0);
        }
    </style>
</head>
<body>
    <div class="error-card">
        <img class="logo-img" src="https://www.telkom.co.id/minio/show/data/image_upload/page/1594112895830_compress_PNG%20Icon%20Telkom.png" alt="Telkom Logo">
        <div class="error-code">500</div>
        <h1 class="error-title">Terjadi Kesalahan Server</h1>
        <p class="error-desc">Maaf, terjadi kesalahan internal pada server kami atau koneksi sedang lambat/terputus. Silakan coba beberapa saat lagi atau kembali ke halaman utama.</p>
        <a href="/" class="btn-back">Kembali ke Beranda</a>
    </div>
</body>
</html>
