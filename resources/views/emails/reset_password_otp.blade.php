<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode Verifikasi Reset Password</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
        }
        .container {
            max-width: 570px;
            margin: 40px auto;
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        }
        .header {
            background-color: #e32b2b;
            padding: 30px;
            text-align: center;
        }
        .header img {
            height: 40px;
            width: auto;
        }
        .content {
            padding: 40px 30px;
        }
        h1 {
            font-size: 20px;
            font-weight: 700;
            color: #0f172a;
            margin-top: 0;
            margin-bottom: 20px;
        }
        p {
            font-size: 15px;
            line-height: 1.6;
            color: #475569;
            margin-top: 0;
            margin-bottom: 24px;
        }
        .otp-container {
            background-color: #f1f5f9;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            margin: 30px 0;
            border: 1px dashed #cbd5e1;
        }
        .otp-code {
            font-size: 32px;
            font-weight: 800;
            letter-spacing: 6px;
            color: #e32b2b;
            font-family: 'Courier New', Courier, monospace;
            margin: 0;
        }
        .footer {
            padding: 30px;
            background-color: #f8fafc;
            border-top: 1px solid #e2e8f0;
            text-align: center;
            font-size: 12px;
            color: #94a3b8;
        }
        .footer a {
            color: #e32b2b;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            
            <span style="color: white; font-weight: 800; font-size: 20px; letter-spacing: 1px;">PORTAL MONITORING</span>
        </div>
        <div class="content">
            <h1>Halo,</h1>
            <p>Kami menerima permintaan untuk menyetel ulang kata sandi akun Anda di Portal Monitoring. Silakan gunakan kode verifikasi (OTP) di bawah ini untuk melanjutkan proses reset password:</p>
            
            <div class="otp-container">
                <div class="otp-code">{{ $code }}</div>
            </div>
            
            <p>Kode verifikasi ini hanya berlaku selama <strong>15 menit</strong>. Untuk keamanan akun Anda, mohon jangan bagikan kode ini kepada siapapun.</p>
            <p>Jika Anda tidak meminta perubahan kata sandi ini, silakan abaikan email ini secara aman.</p>
            
            <p>Terima kasih,<br><strong>Tim Admin</strong></p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} PT Telkom Indonesia Tbk. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
