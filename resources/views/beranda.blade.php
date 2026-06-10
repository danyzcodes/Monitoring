<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Beranda</title>
    <meta name="description" content="Halaman resmi Unit Optima PT Telkom Indonesia. Monitoring proyek deployment, perencanaan jaringan, dan pengelolaan data terpusat.">
    <meta name="turbo-visit-control" content="reload">

    <link rel="icon" href="https://www.telkom.co.id/minio/show/data/image_upload/page/1594112895830_compress_PNG%20Icon%20Telkom.png" type="image/png">

    
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    
    <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Poppins:wght@400;500;600;700;800;900&display=swap" media="print" onload="this.media='all'">
    <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Poppins:wght@400;500;600;700;800;900&display=swap"></noscript>

    <style>
        :root {
            --clr-primary: #DC2626;
            --clr-primary-dark: #991B1B;
            --clr-accent: #EF4444;
            --clr-bg: #0F172A;
            --clr-bg-light: #F8FAFC;
            --clr-surface: #1E293B;
            --clr-text: #F1F5F9;
            --clr-text-muted: #94A3B8;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            font-family: 'Inter', 'Poppins', system-ui, -apple-system, sans-serif;
            color: #1E293B;
            background: #0F172A;
            overflow-x: hidden;
            scroll-behavior: smooth;
        }

        
        .beranda-nav {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
            padding: 1rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .beranda-nav.scrolled {
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            padding: 0.75rem 2rem;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.3);
        }

        .nav-logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
        }

        .nav-logo-icon {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 4px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease;
        }

        .nav-logo:hover .nav-logo-icon {
            transform: scale(1.05) rotate(-3deg);
        }

        .nav-logo-text {
            display: flex;
            flex-direction: column;
        }

        .nav-logo-title {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 1rem;
            color: white;
            letter-spacing: -0.02em;
        }

        .nav-logo-subtitle {
            font-size: 0.65rem;
            color: rgba(255, 255, 255, 0.6);
            letter-spacing: 0.05em;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 0.25rem;
            list-style: none;
        }

        .nav-links a {
            text-decoration: none;
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.85rem;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 10px;
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-links a:hover {
            color: white;
            background: rgba(255, 255, 255, 0.08);
        }

        .nav-links a.active {
            color: white;
            background: rgba(220, 38, 38, 0.15);
        }

        .nav-login-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.6rem 1.5rem;
            background: linear-gradient(135deg, #DC2626, #B91C1C);
            color: white !important;
            font-weight: 600;
            font-size: 0.85rem;
            border-radius: 12px;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(220, 38, 38, 0.3);
        }

        .nav-login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(220, 38, 38, 0.5);
        }

        .nav-hamburger {
            display: none;
            background: none;
            border: none;
            color: white;
            cursor: pointer;
            padding: 0.5rem;
        }

        
        .hero {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            overflow: hidden;
            background: var(--clr-bg);
        }

        .hero-bg {
            position: absolute;
            inset: 0;
            z-index: 0;
        }

        .hero-bg img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.35;
            filter: brightness(0.5);
        }

        .hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(
                135deg,
                rgba(15, 23, 42, 0.92) 0%,
                rgba(15, 23, 42, 0.7) 40%,
                rgba(220, 38, 38, 0.15) 100%
            );
            z-index: 1;
        }

        .hero-particles {
            position: absolute;
            inset: 0;
            z-index: 1;
            overflow: hidden;
        }

        .particle {
            position: absolute;
            width: 3px;
            height: 3px;
            background: rgba(220, 38, 38, 0.4);
            border-radius: 50%;
            animation: floatParticle 15s infinite linear;
        }

        @keyframes floatParticle {
            0% { transform: translateY(100vh) rotate(0deg); opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { transform: translateY(-100vh) rotate(720deg); opacity: 0; }
        }

        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 1280px;
            margin: 0 auto;
            padding: 8rem 1.5rem 4rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            width: 100%;
        }

        .hero-text {
            max-width: 800px;
            margin: 0 auto;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.4rem 1rem;
            background: rgba(220, 38, 38, 0.12);
            border: 1px solid rgba(220, 38, 38, 0.25);
            border-radius: 100px;
            color: #F87171;
            font-size: 0.75rem;
            font-weight: 600;
            letter-spacing: 0.05em;
            margin-bottom: 1.5rem;
        }

        .hero-badge-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #EF4444;
            animation: pulse-dot 2s infinite;
        }

        @keyframes pulse-dot {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.5; transform: scale(1.3); }
        }

        .hero h1 {
            font-family: 'Poppins', sans-serif;
            font-size: clamp(2.2rem, 5vw, 3.5rem);
            font-weight: 800;
            color: white;
            line-height: 1.1;
            margin-bottom: 1.5rem;
            letter-spacing: -0.03em;
        }

        .hero h1 span {
            background: linear-gradient(135deg, #F87171, #DC2626);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-desc {
            font-size: 1.05rem;
            color: var(--clr-text-muted);
            line-height: 1.75;
            margin-bottom: 2.5rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .hero-actions {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            justify-content: center;
        }

        .btn-hero-primary {
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.9rem 2rem;
            background: linear-gradient(135deg, #DC2626, #B91C1C);
            color: white;
            font-weight: 600;
            font-size: 0.9rem;
            border: none;
            border-radius: 14px;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 20px rgba(220, 38, 38, 0.35);
        }

        .btn-hero-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 30px rgba(220, 38, 38, 0.5);
        }

        .btn-hero-secondary {
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            padding: 0.9rem 2rem;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: white;
            font-weight: 500;
            font-size: 0.9rem;
            border-radius: 14px;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .btn-hero-secondary:hover {
            background: rgba(255, 255, 255, 0.12);
            border-color: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
        }

        .hero-stats {
            display: flex;
            gap: 2.5rem;
            margin-top: 3rem;
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            flex-wrap: wrap;
            justify-content: center;
        }

        .hero-stat-item {
            text-align: left;
        }

        .hero-stat-value {
            font-family: 'Poppins', sans-serif;
            font-size: 1.75rem;
            font-weight: 800;
            color: white;
            line-height: 1;
        }

        .hero-stat-label {
            font-size: 0.75rem;
            color: var(--clr-text-muted);
            margin-top: 0.35rem;
        }

        .hero-visual {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .hero-card-stack {
            position: relative;
            width: 100%;
            max-width: 480px;
        }

        .hero-card-main {
            position: relative;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.4);
            animation: floatCard 6s ease-in-out infinite;
        }

        @keyframes floatCard {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
        }

        .hero-card-main img {
            width: 100%;
            aspect-ratio: 4/3;
            object-fit: cover;
        }

        .hero-card-glass {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 1.5rem;
            background: linear-gradient(to top, rgba(15, 23, 42, 0.95), transparent);
        }

        .hero-card-glass-inner {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 1rem 1.25rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .hero-card-status {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #22C55E;
            box-shadow: 0 0 10px rgba(34, 197, 94, 0.5);
            animation: pulse-dot 2s infinite;
        }

        .hero-card-label {
            color: white;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .hero-card-floating {
            position: absolute;
            top: -20px;
            right: -30px;
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 16px;
            padding: 1rem 1.25rem;
            animation: floatCard 5s ease-in-out infinite reverse;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        }

        .hero-card-floating-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: linear-gradient(135deg, #DC2626, #B91C1C);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 0.5rem;
        }

        .hero-card-floating-value {
            font-family: 'Poppins', sans-serif;
            font-size: 1.25rem;
            font-weight: 700;
            color: white;
        }

        .hero-card-floating-label {
            font-size: 0.68rem;
            color: rgba(255, 255, 255, 0.5);
        }

        
        .section {
            padding: 6rem 2rem;
        }

        .section-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .section-header {
            text-align: center;
            margin-bottom: 4rem;
        }

        .section-tag {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.3rem 0;
            padding-left: 0.85rem;
            font-size: 0.8rem;
            font-weight: 600;
            margin-bottom: 1rem;
            border-left: 3px solid;
        }

        .section-tag-red {
            color: #DC2626;
            border-color: #DC2626;
        }

        .section-tag-dark {
            color: rgba(255, 255, 255, 0.65);
            border-color: #DC2626;
        }

        .section-title {
            font-family: 'Poppins', sans-serif;
            font-size: clamp(1.8rem, 3.5vw, 2.5rem);
            font-weight: 800;
            letter-spacing: -0.03em;
            line-height: 1.2;
            margin-bottom: 1.2rem;
            padding-bottom: 0.8rem;
            position: relative;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 40px;
            height: 3px;
            background: #DC2626;
            border-radius: 2px;
        }

        .section-subtitle {
            font-size: 1rem;
            line-height: 1.7;
            max-width: 600px;
            margin: 0 auto;
        }

        
        .about {
            background: var(--clr-bg-light);
            position: relative;
        }

        .about::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: #E2E8F0;
        }

        .about-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
        }

        .about-image-wrapper {
            position: relative;
        }

        .about-image {
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .about-image img {
            width: 100%;
            aspect-ratio: 4/3;
            object-fit: cover;
            transition: transform 0.6s ease;
        }

        .about-image:hover img {
            transform: scale(1.03);
        }

        .about-image-accent {
            display: none;
        }

        .about-content h2 {
            font-family: 'Poppins', sans-serif;
            font-size: clamp(1.6rem, 3vw, 2.2rem);
            font-weight: 800;
            color: #0F172A;
            line-height: 1.2;
            margin-bottom: 1.5rem;
            padding-bottom: 0.8rem;
            letter-spacing: -0.03em;
            position: relative;
        }

        .about-content h2::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 40px;
            height: 3px;
            background: #DC2626;
            border-radius: 2px;
        }

        .about-content h2 span {
            color: inherit;
        }

        .about-content p {
            font-size: 0.95rem;
            color: #64748B;
            line-height: 1.8;
            margin-bottom: 1.5rem;
        }

        .about-features {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-top: 2rem;
        }

        .about-feature-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1rem;
            background: white;
            border-radius: 12px;
            border: 1px solid #E2E8F0;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
        }

        .about-feature-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            border-color: rgba(220, 38, 38, 0.2);
        }

        .about-feature-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            background: rgba(220, 38, 38, 0.08);
            color: #DC2626;
        }

        .about-feature-icon.red { background: rgba(220, 38, 38, 0.1); color: #DC2626; }
        .about-feature-icon.blue { background: rgba(59, 130, 246, 0.1); color: #3B82F6; }
        .about-feature-icon.green { background: rgba(34, 197, 94, 0.1); color: #22C55E; }
        .about-feature-icon.purple { background: rgba(168, 85, 247, 0.1); color: #A855F7; }

        .about-feature-label {
            font-size: 0.85rem;
            font-weight: 600;
            color: #1E293B;
        }

        
        .gallery {
            background: var(--clr-bg);
            position: relative;
            overflow: hidden;
        }

        .gallery::before {
            display: none;
        }

        .gallery .section-title { color: white; }
        .gallery .section-subtitle { color: var(--clr-text-muted); }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
        }

        .gallery-card {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            cursor: pointer;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .gallery-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.25);
        }

        .gallery-card img {
            width: 100%;
            aspect-ratio: 4/3;
            object-fit: cover;
            transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .gallery-card:hover img {
            transform: scale(1.1);
        }

        .gallery-card-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top,
                rgba(15, 23, 42, 0.95) 0%,
                rgba(15, 23, 42, 0.5) 50%,
                transparent 100%
            );
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 1.5rem;
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .gallery-card:hover .gallery-card-overlay {
            opacity: 1;
        }

        .gallery-card-title {
            color: white;
            font-weight: 700;
            font-size: 1.05rem;
            margin-bottom: 0.35rem;
            transform: translateY(10px);
            transition: transform 0.4s ease 0.1s;
        }

        .gallery-card:hover .gallery-card-title {
            transform: translateY(0);
        }

        .gallery-card-desc {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.85rem;
            transform: translateY(10px);
            transition: transform 0.4s ease 0.15s;
        }

        .gallery-card:hover .gallery-card-desc {
            transform: translateY(0);
        }

        .gallery-card-icon {
            position: absolute;
            top: 1rem;
            right: 1rem;
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: rgba(220, 38, 38, 0.9);
            backdrop-filter: blur(10px);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transform: translateY(-10px) scale(0.9);
            transition: all 0.4s ease 0.05s;
            box-shadow: 0 4px 15px rgba(220, 38, 38, 0.4);
        }

        .gallery-card:hover .gallery-card-icon {
            opacity: 1;
            transform: translateY(0) scale(1);
        }

        
        .location {
            background: var(--clr-bg-light);
            position: relative;
        }

        .location-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
            align-items: stretch;
        }

        .location-map {
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08);
            min-height: 400px;
            border: 1px solid #E2E8F0;
        }

        .location-map iframe {
            width: 100%;
            height: 100%;
            border: 0;
        }

        .location-info {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .location-info h3 {
            font-family: 'Poppins', sans-serif;
            font-size: 1.6rem;
            font-weight: 800;
            color: #0F172A;
            margin-bottom: 1rem;
            padding-bottom: 0.6rem;
            letter-spacing: -0.02em;
            position: relative;
        }

        .location-info h3::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 35px;
            height: 3px;
            background: #DC2626;
            border-radius: 2px;
        }

        .location-info > p {
            color: #64748B;
            font-size: 0.9rem;
            line-height: 1.7;
            margin-bottom: 2rem;
        }

        .location-detail-card {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            padding: 1.25rem;
            background: white;
            border-radius: 16px;
            border: 1px solid #F1F5F9;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
        }

        .location-detail-card:hover {
            transform: translateX(8px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            border-color: rgba(220, 38, 38, 0.15);
        }

        .location-detail-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            background: rgba(220, 38, 38, 0.08);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            color: #DC2626;
        }

        .location-detail-text h4 {
            font-size: 0.85rem;
            font-weight: 700;
            color: #0F172A;
            margin-bottom: 0.25rem;
        }

        .location-detail-text p {
            font-size: 0.82rem;
            color: #64748B;
            line-height: 1.6;
        }

        
        .contact {
            background: var(--clr-bg);
            position: relative;
            overflow: hidden;
        }

        .contact::before {
            display: none;
        }

        .contact .section-title { color: white; }
        .contact .section-subtitle { color: var(--clr-text-muted); }

        .contact-form-wrapper {
            max-width: 800px;
            margin: 0 auto;
            background: rgba(30, 41, 59, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 24px;
            padding: 3rem;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        }

        .contact-form .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }

        .contact-form .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.6rem;
            margin-bottom: 1.5rem;
        }

        .contact-form .form-label {
            font-size: 0.85rem;
            font-weight: 600;
            color: #E2E8F0;
            letter-spacing: 0.05em;
        }

        .contact-input, .contact-textarea {
            width: 100%;
            padding: 1rem 1.25rem;
            background: rgba(15, 23, 42, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            color: white;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            outline: none;
            font-family: inherit;
        }

        .contact-input::placeholder, .contact-textarea::placeholder {
            color: rgba(255,255,255,0.3);
        }

        .contact-input:focus, .contact-textarea:focus {
            border-color: #EF4444;
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.15);
            background: rgba(15, 23, 42, 0.8);
        }

        .contact-textarea {
            min-height: 140px;
            resize: vertical;
        }

        .btn-submit {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, #DC2626 0%, #B91C1C 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.6rem;
            margin-top: 0.5rem;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(220, 38, 38, 0.4);
        }

        @media (max-width: 768px) {
            .contact-form .form-row {
                grid-template-columns: 1fr;
                gap: 0;
            }
            .contact-form-wrapper {
                padding: 2rem 1.5rem;
            }
        }

        
        .footer {
            background: #0B1120;
            padding: 3rem 2rem 2rem;
            text-align: center;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }

        .footer-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            margin-bottom: 1rem;
        }

        .footer-logo-icon {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .footer-logo-text {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 0.95rem;
            color: white;
        }

        .footer-desc {
            font-size: 0.8rem;
            color: #64748B;
            max-width: 400px;
            margin: 0 auto 1.5rem;
            line-height: 1.6;
        }

        .footer-divider {
            height: 1px;
            background: rgba(255, 255, 255, 0.05);
            margin-bottom: 1.5rem;
        }

        .footer-copy {
            font-size: 0.72rem;
            color: #475569;
        }

        
        .scroll-top-btn {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            width: 48px;
            height: 48px;
            border-radius: 14px;
            background: linear-gradient(135deg, #DC2626, #B91C1C);
            color: white;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 25px rgba(220, 38, 38, 0.35);
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.4s ease;
            z-index: 90;
        }

        .scroll-top-btn.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .scroll-top-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(220, 38, 38, 0.5);
        }

        
        .toast-notification {
            position: fixed;
            bottom: 2rem;
            left: 50%;
            transform: translateX(-50%) translateY(100px);
            background: rgba(30, 41, 59, 0.95);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 1rem 1.25rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            opacity: 0;
            visibility: hidden;
            transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            z-index: 9999;
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        .toast-notification.show {
            transform: translateX(-50%) translateY(0);
            opacity: 1;
            visibility: visible;
        }

        .toast-icon {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: rgba(34, 197, 94, 0.15);
            color: #22C55E;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .toast-content h4 {
            font-family: 'Poppins', sans-serif;
            font-size: 0.95rem;
            font-weight: 700;
            color: white;
            margin-bottom: 0.15rem;
            margin-top: 0;
        }

        .toast-content p {
            font-size: 0.82rem;
            color: rgba(255,255,255,0.7);
            margin: 0;
        }

        .toast-close {
            background: none;
            border: none;
            color: rgba(255,255,255,0.5);
            cursor: pointer;
            padding: 0.25rem;
            margin-left: 0.5rem;
            transition: color 0.3s;
            display: flex;
            align-items: center;
        }

        .toast-close:hover {
            color: white;
        }

        @keyframes spin { 100% { transform: rotate(360deg); } }

        
        .mobile-nav-overlay {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.5);
            backdrop-filter: blur(5px);
            z-index: 200;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }

        .mobile-nav-overlay.open {
            opacity: 1;
            pointer-events: all;
        }

        .mobile-nav-panel {
            position: fixed;
            top: 0;
            right: -320px;
            width: 300px;
            height: 100%;
            background: #0F172A;
            z-index: 201;
            padding: 2rem 1.5rem;
            transition: right 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            overflow-y: auto;
            border-left: 1px solid rgba(255, 255, 255, 0.06);
        }

        .mobile-nav-panel.open {
            right: 0;
        }

        .mobile-nav-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        }

        .mobile-nav-close {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.06);
            border: none;
            color: white;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .mobile-nav-links {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .mobile-nav-links a {
            display: block;
            padding: 0.85rem 1rem;
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .mobile-nav-links a:hover {
            background: rgba(255, 255, 255, 0.06);
            color: white;
        }

        .mobile-nav-login {
            margin-top: 1.5rem;
            display: block;
            padding: 0.85rem;
            text-align: center;
            background: linear-gradient(135deg, #DC2626, #B91C1C);
            color: white !important;
            text-decoration: none;
            font-weight: 600;
            border-radius: 14px;
            transition: all 0.3s ease;
        }

        
        @media (max-width: 1024px) {
            .hero-content {
                text-align: center;
                padding: 6.5rem 1.5rem 3.5rem;
            }

            .hero-text { max-width: 100%; }
            .hero-desc { margin: 0 auto 2.5rem; }
            .hero-actions { justify-content: center; }
            .hero-stats { justify-content: center; }
            .about-grid { grid-template-columns: 1fr; gap: 2.5rem; }
            .location-grid { grid-template-columns: 1fr; }
            .nav-links { display: none; }
            .nav-hamburger { display: flex; }
        }

        @media (max-width: 768px) {
            .section { padding: 4rem 1.25rem; }
            .hero-content { padding: 5.5rem 1.25rem 3rem; }
            .hero h1 { font-size: clamp(1.75rem, 7vw, 2.5rem); }
            .hero-desc { font-size: 0.95rem; }
            .hero-stats { gap: 1.5rem; flex-wrap: wrap; justify-content: center; }
            .hero-stat-value { font-size: 1.4rem; }
            .about-features { grid-template-columns: 1fr; }
            .gallery-grid { grid-template-columns: 1fr 1fr; }
            .contact-cards { grid-template-columns: 1fr; }
            .btn-hero-primary, .btn-hero-secondary { padding: 0.8rem 1.5rem; font-size: 0.85rem; }
        }

        @media (max-width: 480px) {
            .gallery-grid { grid-template-columns: 1fr; }
            .hero-actions { flex-direction: column; align-items: center; width: 100%; }
            .btn-hero-primary, .btn-hero-secondary { width: 100%; justify-content: center; }
            .beranda-nav { padding: 0.75rem 1rem; }
            .hero-content { padding: 5rem 1rem 2.5rem; }
            .hero-badge { font-size: 0.7rem; }
        }

        
        @supports (padding-top: env(safe-area-inset-top)) {
            .beranda-nav {
                padding-top: calc(1rem + env(safe-area-inset-top));
            }
            .hero-content {
                padding-top: calc(8rem + env(safe-area-inset-top));
            }
            @media (max-width: 1024px) {
                .hero-content {
                    padding-top: calc(6.5rem + env(safe-area-inset-top));
                }
            }
            @media (max-width: 768px) {
                .hero-content {
                    padding-top: calc(5.5rem + env(safe-area-inset-top));
                }
            }
            @media (max-width: 480px) {
                .hero-content {
                    padding-top: calc(5rem + env(safe-area-inset-top));
                }
            }
        }
    </style>
</head>

<body>
    
    <nav class="beranda-nav" id="berandaNav">
        <a href="#hero" class="nav-logo">
            <div class="nav-logo-icon">
                <img src="https://www.telkom.co.id/minio/show/data/image_upload/page/1594112895830_compress_PNG%20Icon%20Telkom.png" alt="Telkom" style="width: 85%; height: auto;">
            </div>
            <div class="nav-logo-text">
                <div class="nav-logo-title">MONIKA</div>
                
            </div>
        </a>

        <ul class="nav-links">
            <li><a href="#hero" class="active">Beranda</a></li>
            <li><a href="#about">Tentang</a></li>
            <li><a href="#gallery">Dokumentasi</a></li>
            <li><a href="#location">Lokasi</a></li>
            <li><a href="#contact">Kontak</a></li>
            <li>
                <a href="{{ route('login') }}" class="nav-login-btn" data-turbo="false">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                    </svg>
                    Login
                </a>
            </li>
        </ul>

        <button class="nav-hamburger" id="navHamburger" aria-label="Open menu">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </nav>

    
    <div class="mobile-nav-overlay" id="mobileOverlay"></div>
    <div class="mobile-nav-panel" id="mobileNav">
        <div class="mobile-nav-header">
            <div class="nav-logo-title" style="color:white; font-family:'Poppins',sans-serif; font-weight:700; font-size:0.95rem;">Menu</div>
            <button class="mobile-nav-close" id="mobileClose">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <ul class="mobile-nav-links">
            <li><a href="#hero" onclick="closeMobileNav()">Beranda</a></li>
            <li><a href="#about" onclick="closeMobileNav()">Tentang Kami</a></li>
            <li><a href="#gallery" onclick="closeMobileNav()">Dokumentasi</a></li>
            <li><a href="#location" onclick="closeMobileNav()">Lokasi</a></li>
            <li><a href="#contact" onclick="closeMobileNav()">Kontak</a></li>
        </ul>
        <a href="{{ route('login') }}" class="mobile-nav-login" data-turbo="false">
            Login ke Dashboard
        </a>
    </div>

    
    <section class="hero" id="hero">
        <div class="hero-bg">
            <img src="{{ asset('images/hero-banner.jpg') }}" alt="Hero Banner Unit Optima" loading="eager">
        </div>
        <div class="hero-overlay"></div>

        
        <div class="hero-particles" id="heroParticles"></div>

        <div class="hero-content">
            <div class="hero-text" data-aos="fade-up">

                <h1 data-aos="fade-up" data-aos-delay="100">Sistem <span>Monitoring</span> Proyek Deployment</h1>

                <p class="hero-desc" data-aos="fade-up" data-aos-delay="200">
                    Selamat Datang Platform terpusat untuk memantau progres deployment jaringan, perencanaan proyek, dan pengelolaan data order secara real-time  Unit Optima Telkom.
                </p>

                
                <div class="hero-actions" data-aos="fade-up" data-aos-delay="300">
                    <a href="{{ route('login') }}" class="btn-hero-primary" data-turbo="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                        </svg>
                        Masuk Dashboard
                    </a>
                    <a href="#about" class="btn-hero-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Tentang Kami
                    </a>
                </div>

            </div>
        </div>
    </section>

    
    <section class="section about" id="about">
        <div class="section-container">
            <div class="about-grid">
                <div class="about-image-wrapper" data-aos="fade-right">
                    <div class="about-image">
                        <img src="{{ asset('images/about-team.jpg') }}" alt="Tim Unit Optima" loading="lazy">
                    </div>
                    <div class="about-image-accent"></div>
                </div>

                <div class="about-content" data-aos="fade-left">
                    <h2>Tentang Unit Optima</h2>

                    <p>
                        Unit Optima merupakan bagian dari PT Telkom Indonesia yang berfokus pada
                        pengelolaan dan monitoring proyek deployment jaringan telekomunikasi di wilayah
                        Cirebon.
                    </p>
                    <p>
                        Kami memastikan setiap eksekusi di lapangan terdata dengan sistematis,
                        perencanaan yang tepat, dan koordinasi yang efisien antara mitra pelaksana
                        dengan manajemen terpusat.
                    </p>

                    <div class="about-features stagger-children">
                        <div class="about-feature-item" data-aos="fade-up">
                            <div class="about-feature-icon red">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="about-feature-label">Akurasi Tinggi</div>
                        </div>
                        <div class="about-feature-item" data-aos="fade-up">
                            <div class="about-feature-icon blue">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="about-feature-label">Real-time Data</div>
                        </div>
                        <div class="about-feature-item" data-aos="fade-up">
                            <div class="about-feature-icon green">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <div class="about-feature-label">Eksekusi Cepat</div>
                        </div>
                        <div class="about-feature-item" data-aos="fade-up">
                            <div class="about-feature-icon purple">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div class="about-feature-label">Sinergi Mitra</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    
    <section class="section gallery" id="gallery">
        <div class="section-container">
            <div class="section-header" data-aos="fade-up">
                <h2 class="section-title">Dokumentasi Proyek</h2>
                <p class="section-subtitle">
                    Dokumentasi visual dari berbagai proyek deployment yang telah berhasil
                    diselesaikan oleh Unit Optima.
                </p>
            </div>

            <div class="gallery-grid stagger-children">
                <div class="gallery-card" data-aos="zoom-in">
                    <img src="{{ asset('images/gallery-deployment.jpg') }}" alt="Deployment Lapangan" loading="lazy">

                    <div class="gallery-card-overlay">
                        <div class="gallery-card-title">Instalasi Kabel Optik</div>
                        <div class="gallery-card-desc">STO Kebon Jeruk</div>
                    </div>
                </div>
                <div class="gallery-card" data-aos="zoom-in">
                    <img src="{{ asset('images/gallery-completed.jpg') }}" alt="Penyeleseaian Proyek" loading="lazy">

                    <div class="gallery-card-overlay">
                        <div class="gallery-card-title">Selesai Fisik ODP</div>
                        <div class="gallery-card-desc">Area Cengkareng</div>
                    </div>
                </div>
                <div class="gallery-card" data-aos="zoom-in">
                    <img src="{{ asset('images/gallery-server.jpg') }}" alt="Ruang Server" loading="lazy">

                    <div class="gallery-card-overlay">
                        <div class="gallery-card-title">Integrasi ODC Server</div>
                        <div class="gallery-card-desc">STO Palmerah</div>
                    </div>
                </div>
                <div class="gallery-card" data-aos="zoom-in">
                    <img src="{{ asset('images/gallery-survey.jpg') }}" alt="Survey Lapangan" loading="lazy">

                    <div class="gallery-card-overlay">
                        <div class="gallery-card-title">Survey Pra-Deployment</div>
                        <div class="gallery-card-desc">Titik Kalideres</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    
    <section class="section location" id="location">
        <div class="section-container">
            <div class="location-grid">
                <div class="location-info" data-aos="fade-left">
                    <h3>Lokasi Kantor</h3>
                    <p>
                        Pusat administrasi dan koordinasi tim deployment Unit Optima
                        di area Cirebon. Datang dan kunjungi kami pada jam operasional.
                    </p>

                    <div class="location-detail-card">
                        <div class="location-detail-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.243-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div class="location-detail-text">
                            <h4>Alamat Lengkap</h4>
                            <p>Gedung Witel Cirebon, Jl. Pagongan No.11, Pekalangan, Kec. Pekalipan, Kota Cirebon, Jawa Barat 45118</p>
                        </div>
                    </div>

                    <div class="location-detail-card">
                        <div class="location-detail-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="location-detail-text">
                            <h4>Jam Operasional</h4>
                            <p>Senin - Jumat: 08:00 - 17:00 WIB<br>Sabtu, Minggu & Hari Libur: Tutup</p>
                        </div>
                    </div>
                </div>

                <div class="location-map" data-aos="fade-right">
                    <iframe 
                        src="https://maps.google.com/maps?q=Jl.%20Pagongan%20No.11,%20Pekalangan,%20Kec.%20Pekalipan,%20Kota%20Cirebon,%20Jawa%20Barat%2045118&t=&z=17&ie=UTF8&iwloc=&output=embed" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>
    </section>

    
    <section class="section contact" id="contact">
        <div class="section-container">
            <div class="section-header" data-aos="fade-up">
                <h2 class="section-title">Kontak Kami</h2>
                <p class="section-subtitle">
                    Punya pertanyaan mengenai koordinasi pesanan atau dokumentasi deployment?
                    Hubungi tim administrasi kami melalui saluran di bawah ini.
                </p>
            </div>

            <div class="contact-form-wrapper" data-aos="fade-up">
                <form action="#" method="POST" class="contact-form" onsubmit="handleContactSubmit(event)">
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" class="contact-input" placeholder="Masukkan nama Anda" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Email</label>
                            <input type="email" class="contact-input" placeholder="nama@gmail.com" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Pesan</label>
                        <textarea class="contact-textarea" placeholder="Tuliskan pesan atau pertanyaan Anda di sini..." required></textarea>
                    </div>
                    <button type="submit" class="btn-submit">
                        Kirim Pesan
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </section>

    
    <footer class="footer">

        <p class="footer-desc">
            Platform monitoring proyek deployment Unit Optima — Telkom Cirebon.
        </p>
        <div class="footer-divider"></div>
        <p class="footer-copy">&copy; {{ date('Y') }} PT Telkom Indonesia Tbk. All rights reserved.</p>
    </footer>

    
    <button class="scroll-top-btn" id="scrollTopBtn" aria-label="Scroll to top">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
        </svg>
    </button>

    
    <div id="toastNotification" class="toast-notification">
        <div class="toast-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
            </svg>
        </div>
        <div class="toast-content">
            <h4>Pesan Terkirim</h4>
            <p>Terima kasih! Pesan Anda telah kami terima.</p>
        </div>
        <button class="toast-close" onclick="closeToast()">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    
    <script>
                // ——— SCROLL ANIMATIONS (AOS) & JS INIT ———
        // Track scroll handler so we can remove it on Turbo navigation away
        let _berandaScrollHandler = null;

        function initBeranda() {
            // ——— GUARD: hanya jalankan di halaman beranda ———
            const nav = document.getElementById('berandaNav');
            if (!nav) return;

            AOS.init({
                duration: 800,
                once: true,
                offset: 50,
            });
            setTimeout(() => AOS.refresh(), 100);

            // ——— NAVBAR SCROLL EFFECT ———
            const scrollTopBtn = document.getElementById('scrollTopBtn');

            // Remove previous scroll listener if any (Turbo re-init)
            if (_berandaScrollHandler) {
                window.removeEventListener('scroll', _berandaScrollHandler);
            }

            _berandaScrollHandler = function() {
                if (window.scrollY > 80) {
                    nav.classList.add('scrolled');
                } else {
                    nav.classList.remove('scrolled');
                }

                if (scrollTopBtn) {
                    if (window.scrollY > 500) {
                        scrollTopBtn.classList.add('visible');
                    } else {
                        scrollTopBtn.classList.remove('visible');
                    }
                }

                // Update active nav link
                updateActiveNav();
            };
            window.addEventListener('scroll', _berandaScrollHandler);

            // ——— SMOOTH SCROLL ———
            document.querySelectorAll('a[href^="#"]').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                });
            });

            // ——— SCROLL TO TOP ———
            if (scrollTopBtn) {
                scrollTopBtn.addEventListener('click', function() {
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                });
            }

            // ——— MOBILE NAV ———
            const hamburger = document.getElementById('navHamburger');
            const mobileOverlay = document.getElementById('mobileOverlay');
            const mobileNav = document.getElementById('mobileNav');
            const mobileClose = document.getElementById('mobileClose');

            if (hamburger && mobileOverlay && mobileNav && mobileClose) {
                hamburger.addEventListener('click', function() {
                    mobileOverlay.classList.add('open');
                    mobileNav.classList.add('open');
                    document.body.style.overflow = 'hidden';
                });

                function closeMobileNavFn() {
                    mobileOverlay.classList.remove('open');
                    mobileNav.classList.remove('open');
                    document.body.style.overflow = '';
                }

                mobileClose.addEventListener('click', closeMobileNavFn);
                mobileOverlay.addEventListener('click', closeMobileNavFn);
                window.closeMobileNav = closeMobileNavFn;
            }

            // ——— HERO PARTICLES ———
            const particlesContainer = document.getElementById('heroParticles');
            if (particlesContainer && particlesContainer.children.length === 0) {
                for (let i = 0; i < 20; i++) {
                    const particle = document.createElement('div');
                    particle.classList.add('particle');
                    particle.style.left = Math.random() * 100 + '%';
                    particle.style.animationDelay = Math.random() * 15 + 's';
                    particle.style.animationDuration = (10 + Math.random() * 20) + 's';
                    particle.style.width = (2 + Math.random() * 3) + 'px';
                    particle.style.height = particle.style.width;
                    particlesContainer.appendChild(particle);
                }
            }

            // ——— ACTIVE NAV LINK ———
            function updateActiveNav() {
                const sections = document.querySelectorAll('section[id]');
                const navLinks = document.querySelectorAll('.nav-links a:not(.nav-login-btn)');
                let current = '';

                sections.forEach(section => {
                    const top = section.offsetTop - 100;
                    if (window.scrollY >= top) {
                        current = section.getAttribute('id');
                    }
                });

                navLinks.forEach(link => {
                    link.classList.remove('active');
                    if (link.getAttribute('href') === '#' + current) {
                        link.classList.add('active');
                    }
                });
            }
        } // End of initBeranda

        // Initialize on normal load and Turbo load
        document.addEventListener('DOMContentLoaded', initBeranda);
        document.addEventListener('turbo:load', initBeranda);

        // ——— CONTACT FORM HANDLER ———
        window.handleContactSubmit = function(event) {
            event.preventDefault();
            const form = event.target;
            const btn = form.querySelector('.btn-submit');
            const originalText = btn.innerHTML;
            
            // Loading state
            btn.innerHTML = `<svg style="animation: spin 1s linear infinite" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 2v4m0 12v4M4.93 4.93l2.83 2.83m8.48 8.48l2.83 2.83M2 12h4m12 0h4M4.93 19.07l2.83-2.83m8.48-8.48l2.83-2.83"/></svg> Mengirim...`;
            btn.disabled = true;

            // Simulate network request
            setTimeout(() => {
                form.reset();
                btn.innerHTML = originalText;
                btn.disabled = false;
                
                // Show toast
                const toast = document.getElementById('toastNotification');
                toast.classList.add('show');
                
                // Auto hide
                setTimeout(() => {
                    toast.classList.remove('show');
                }, 4000);
            }, 1000);
        };

        window.closeToast = function() {
            document.getElementById('toastNotification').classList.remove('show');
        };
    </script>

</body>
</html>
