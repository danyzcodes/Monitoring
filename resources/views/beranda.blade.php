<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda — Unit Optima · PT Telkom Indonesia</title>
    <meta name="description" content="Halaman resmi Unit Optima PT Telkom Indonesia. Monitoring proyek deployment, perencanaan jaringan, dan pengelolaan data terpusat.">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Google Fonts: Inter + Poppins --}}
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

        /* ========================================
           NAVBAR
        ======================================== */
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

        /* ========================================
           HERO SECTION
        ======================================== */
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
            padding: 8rem 2rem 4rem;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
        }

        .hero-text {
            max-width: 620px;
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
            max-width: 500px;
        }

        .hero-actions {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
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

        /* ========================================
           SCROLL ANIMATIONS
        ======================================== */
        .animate-on-scroll {
            opacity: 0;
            transform: translateY(40px);
            transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .animate-on-scroll.slide-left {
            transform: translateX(-60px);
        }

        .animate-on-scroll.slide-right {
            transform: translateX(60px);
        }

        .animate-on-scroll.zoom-in {
            transform: scale(0.85);
        }

        .animate-on-scroll.visible {
            opacity: 1;
            transform: translateY(0) translateX(0) scale(1);
        }

        /* Stagger children */
        .stagger-children .animate-on-scroll:nth-child(1) { transition-delay: 0s; }
        .stagger-children .animate-on-scroll:nth-child(2) { transition-delay: 0.1s; }
        .stagger-children .animate-on-scroll:nth-child(3) { transition-delay: 0.2s; }
        .stagger-children .animate-on-scroll:nth-child(4) { transition-delay: 0.3s; }
        .stagger-children .animate-on-scroll:nth-child(5) { transition-delay: 0.4s; }
        .stagger-children .animate-on-scroll:nth-child(6) { transition-delay: 0.5s; }

        /* ========================================
           SECTION COMMON
        ======================================== */
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

        /* ========================================
           ABOUT SECTION
        ======================================== */
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
            padding: 0.6rem 0;
            color: #475569;
            font-size: 0.9rem;
        }

        .about-feature-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            background: rgba(220, 38, 38, 0.06);
            color: #DC2626;
        }

        .about-feature-icon.red,
        .about-feature-icon.blue,
        .about-feature-icon.green,
        .about-feature-icon.purple { background: rgba(220, 38, 38, 0.06); color: #DC2626; }

        .about-feature-label {
            font-size: 0.8rem;
            font-weight: 600;
            color: #334155;
        }

        /* ========================================
           GALLERY / DOKUMENTASI
        ======================================== */
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
            group: true;
        }

        .gallery-card img {
            width: 100%;
            aspect-ratio: 4/3;
            object-fit: cover;
            transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .gallery-card:hover img {
            transform: scale(1.08);
        }

        .gallery-card-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top,
                rgba(15, 23, 42, 0.9) 0%,
                rgba(15, 23, 42, 0.3) 40%,
                transparent 70%
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
            font-size: 1rem;
            margin-bottom: 0.25rem;
        }

        .gallery-card-desc {
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.78rem;
        }

        .gallery-card-icon {
            position: absolute;
            top: 1rem;
            right: 1rem;
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transform: translateY(-10px);
            transition: all 0.3s ease 0.1s;
        }

        .gallery-card:hover .gallery-card-icon {
            opacity: 1;
            transform: translateY(0);
        }

        /* ========================================
           LOCATION
        ======================================== */
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

        /* ========================================
           CONTACT SECTION
        ======================================== */
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

        .contact-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
        }

        .contact-card {
            background: rgba(255, 255, 255, 0.04);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 20px;
            padding: 2rem;
            text-align: center;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }

        .contact-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: #DC2626;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .contact-card:hover {
            background: rgba(255, 255, 255, 0.07);
            transform: translateY(-4px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
            border-color: rgba(255, 255, 255, 0.12);
        }

        .contact-card:hover::before {
            opacity: 1;
        }

        .contact-avatar {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: #DC2626;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 1.1rem;
            font-weight: 700;
            color: white;
        }

        .contact-name {
            font-family: 'Poppins', sans-serif;
            font-size: 1.1rem;
            font-weight: 700;
            color: white;
            margin-bottom: 0.25rem;
        }

        .contact-role {
            font-size: 0.78rem;
            color: var(--clr-text-muted);
            margin-bottom: 1.5rem;
        }

        .contact-links {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .contact-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.7rem 1rem;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 12px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .contact-link:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.15);
        }

        .contact-link-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .contact-link-icon.whatsapp { background: rgba(37, 211, 102, 0.12); color: #25D366; }
        .contact-link-icon.email { background: rgba(59, 130, 246, 0.12); color: #3B82F6; }
        .contact-link-icon.phone { background: rgba(168, 85, 247, 0.12); color: #A855F7; }

        .contact-link-text {
            font-size: 0.82rem;
            color: rgba(255, 255, 255, 0.7);
            text-align: left;
        }

        /* ========================================
           FOOTER
        ======================================== */
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

        /* ========================================
           SCROLL TO TOP
        ======================================== */
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

        /* ========================================
           MOBILE NAV OVERLAY
        ======================================== */
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

        /* ========================================
           RESPONSIVE
        ======================================== */
        @media (max-width: 1024px) {
            .hero-content {
                grid-template-columns: 1fr;
                text-align: center;
                padding-top: 7rem;
            }

            .hero-text { max-width: 100%; }
            .hero-desc { margin: 0 auto 2.5rem; }
            .hero-actions { justify-content: center; }
            .hero-stats { justify-content: center; }
            .hero-visual { display: none; }
            .about-grid { grid-template-columns: 1fr; gap: 2.5rem; }
            .location-grid { grid-template-columns: 1fr; }
            .nav-links { display: none; }
            .nav-hamburger { display: flex; }
        }

        @media (max-width: 768px) {
            .section { padding: 4rem 1.25rem; }
            .hero-stats { gap: 1.5rem; flex-wrap: wrap; justify-content: center; }
            .about-features { grid-template-columns: 1fr; }
            .gallery-grid { grid-template-columns: 1fr 1fr; }
            .contact-cards { grid-template-columns: 1fr; }
        }

        @media (max-width: 480px) {
            .gallery-grid { grid-template-columns: 1fr; }
            .hero-actions { flex-direction: column; align-items: center; }
            .beranda-nav { padding: 0.75rem 1rem; }
        }
    </style>
</head>

<body>
    <!-- ============ NAVBAR ============ -->
    <nav class="beranda-nav" id="berandaNav">
        <a href="#hero" class="nav-logo">
            <div class="nav-logo-icon">
                <img src="https://www.telkom.co.id/minio/show/data/image_upload/page/1594112895830_compress_PNG%20Icon%20Telkom.png" alt="Telkom" style="width: 85%; height: auto;">
            </div>
            <div class="nav-logo-text">
                <div class="nav-logo-title">Monitoring Proyek</div>
                
            </div>
        </a>

        <ul class="nav-links">
            <li><a href="#hero" class="active">Beranda</a></li>
            <li><a href="#about">Tentang</a></li>
            <li><a href="#gallery">Dokumentasi</a></li>
            <li><a href="#location">Lokasi</a></li>
            <li><a href="#contact">Kontak</a></li>
            <li>
                <a href="{{ route('login') }}" class="nav-login-btn">
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

    <!-- ============ MOBILE NAV ============ -->
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
        <a href="{{ route('login') }}" class="mobile-nav-login">
            Login ke Dashboard
        </a>
    </div>

    <!-- ============ HERO SECTION ============ -->
    <section class="hero" id="hero">
        <div class="hero-bg">
            <img src="{{ asset('images/hero-banner.png') }}" alt="Hero Banner Unit Optima" loading="eager">
        </div>
        <div class="hero-overlay"></div>

        {{-- Animated Particles --}}
        <div class="hero-particles" id="heroParticles"></div>

        <div class="hero-content">
            <div class="hero-text">
                

                <h1>Sistem <span>Monitoring</span> Proyek Deployment</h1>

                <p class="hero-desc">
                    Platform terpusat untuk memantau progres deployment jaringan, perencanaan proyek, dan pengelolaan data order secara real-time bagi Unit Optima Telkom Witel Jakarta Barat.
                </p>

                <div class="hero-actions">
                    <a href="{{ route('login') }}" class="btn-hero-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                        </svg>
                        Masuk ke Dashboard
                    </a>
                    <a href="#about" class="btn-hero-secondary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                        </svg>
                        Pelajari Lebih Lanjut
                    </a>
                </div>

                <div class="hero-stats">
                    <div class="hero-stat-item">
                        <div class="hero-stat-value">Real-time</div>
                        <div class="hero-stat-label">Monitoring Data</div>
                    </div>
                    <div class="hero-stat-item">
                        <div class="hero-stat-value">Terpusat</div>
                        <div class="hero-stat-label">Integrasi Sistem</div>
                    </div>
                    <div class="hero-stat-item">
                        <div class="hero-stat-value">Otomatis</div>
                        <div class="hero-stat-label">Pelaporan Harian</div>
                    </div>
                </div>
            </div>

            
        </div>
    </section>

    <!-- ============ ABOUT SECTION ============ -->
    <section class="section about" id="about">
        <div class="section-container">
            <div class="about-grid">
                <div class="about-image-wrapper animate-on-scroll slide-left">
                    <div class="about-image">
                        <img src="{{ asset('images/about-team.png') }}" alt="Tim Unit Optima" loading="lazy">
                    </div>
                    <div class="about-image-accent"></div>
                </div>

                <div class="about-content animate-on-scroll slide-right">
                    <h2>Tentang Unit Optima</h2>

                    <p>
                        Unit Optima merupakan bagian dari PT Telkom Indonesia yang berfokus pada
                        pengelolaan dan monitoring proyek deployment jaringan telekomunikasi di wilayah
                        Jakarta Barat.
                    </p>
                    <p>
                        Kami memastikan setiap eksekusi di lapangan terdata dengan sistematis,
                        perencanaan yang tepat, dan koordinasi yang efisien antara mitra pelaksana
                        dengan manajemen terpusat.
                    </p>

                    <div class="about-features stagger-children">
                        <div class="about-feature-item animate-on-scroll slide-up">
                            <div class="about-feature-icon red">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="about-feature-label">Akurasi Tinggi</div>
                        </div>
                        <div class="about-feature-item animate-on-scroll slide-up">
                            <div class="about-feature-icon blue">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="about-feature-label">Real-time Data</div>
                        </div>
                        <div class="about-feature-item animate-on-scroll slide-up">
                            <div class="about-feature-icon green">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <div class="about-feature-label">Eksekusi Cepat</div>
                        </div>
                        <div class="about-feature-item animate-on-scroll slide-up">
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

    <!-- ============ GALLERY SECTION ============ -->
    <section class="section gallery" id="gallery">
        <div class="section-container">
            <div class="section-header animate-on-scroll slide-up">
                <h2 class="section-title">Dokumentasi Proyek</h2>
                <p class="section-subtitle">
                    Dokumentasi visual dari berbagai proyek deployment yang telah berhasil
                    diselesaikan oleh Unit Optima.
                </p>
            </div>

            <div class="gallery-grid stagger-children">
                <div class="gallery-card animate-on-scroll zoom-in">
                    <img src="{{ asset('images/gallery-deployment.png') }}" alt="Deployment Lapangan" loading="lazy">
                    <div class="gallery-card-overlay">
                        <div class="gallery-card-title">Instalasi Kabel Optik</div>
                        <div class="gallery-card-desc">STO Kebon Jeruk</div>
                    </div>
                </div>
                <div class="gallery-card animate-on-scroll zoom-in">
                    <img src="{{ asset('images/gallery-completed.png') }}" alt="Penyeleseaian Proyek" loading="lazy">
                    <div class="gallery-card-overlay">
                        <div class="gallery-card-title">Selesai Fisik ODP</div>
                        <div class="gallery-card-desc">Area Cengkareng</div>
                    </div>
                </div>
                <div class="gallery-card animate-on-scroll zoom-in">
                    <img src="{{ asset('images/gallery-server.png') }}" alt="Ruang Server" loading="lazy">
                    <div class="gallery-card-overlay">
                        <div class="gallery-card-title">Integrasi ODC Server</div>
                        <div class="gallery-card-desc">STO Palmerah</div>
                    </div>
                </div>
                <div class="gallery-card animate-on-scroll zoom-in">
                    <img src="{{ asset('images/gallery-survey.png') }}" alt="Survey Lapangan" loading="lazy">
                    <div class="gallery-card-overlay">
                        <div class="gallery-card-title">Survey Pra-Deployment</div>
                        <div class="gallery-card-desc">Titik Kalideres</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ LOCATION SECTION ============ -->
    <section class="section location" id="location">
        <div class="section-container">
            <div class="location-grid">
                <div class="location-info animate-on-scroll slide-right">
                    <h3>Lokasi Kantor</h3>
                    <p>
                        Pusat administrasi dan koordinasi tim deployment Unit Optima
                        di area Jakarta Barat. Datang dan kunjungi kami pada jam operasional.
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
                            <p>Gedung Witel Jakarta Barat, Jl. Letjen S. Parman No.8, RT.3/RW.8, Tomang, Grogol petamburan, Jakarta Barat, Jakarta 11440</p>
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

                <div class="location-map animate-on-scroll slide-left">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15866.529340989087!2d106.7828062!3d-6.1804245!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f6f6d0f1bd73%3A0xc85926ec38290fa8!2sTelkom%20Witel%20Jakarta%20Barat!5e0!3m2!1sen!2sid!4v1700000000000!5m2!1sen!2sid" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ CONTACT SECTION ============ -->
    <section class="section contact" id="contact">
        <div class="section-container">
            <div class="section-header animate-on-scroll slide-up">
                <h2 class="section-title">Kontak Kami</h2>
                <p class="section-subtitle">
                    Punya pertanyaan mengenai koordinasi pesanan atau dokumentasi deployment?
                    Hubungi tim administrasi kami melalui saluran di bawah ini.
                </p>
            </div>

            <div class="contact-cards stagger-children">
                <div class="contact-card animate-on-scroll">
                    <div class="contact-avatar">AS</div>
                    <div class="contact-name">Agus Setiawan</div>
                    <div class="contact-role">Manager Unit Optima</div>
                    <div class="contact-links">
                        
                        <a href="mailto:agus.setiawan@telkom.co.id" class="contact-link">
                            <div class="contact-link-icon email">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                                </svg>
                            </div>
                            <span class="contact-link-text">agus.setiawan@telkom.co.id</span>
                        </a>
                    </div>
                </div>

                <div class="contact-card animate-on-scroll">
                    <div class="contact-avatar">RH</div>
                    <div class="contact-name">Rizki Hidayat</div>
                    <div class="contact-role">Koordinator Lapangan</div>
                    <div class="contact-links">
                        
                        <a href="mailto:rizki.hidayat@telkom.co.id" class="contact-link">
                            <div class="contact-link-icon email">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                                </svg>
                            </div>
                            <span class="contact-link-text">rizki.hidayat@telkom.co.id</span>
                        </a>
                    </div>
                </div>

                <div class="contact-card animate-on-scroll">
                    <div class="contact-avatar">DW</div>
                    <div class="contact-name">Dewi Wulandari</div>
                    <div class="contact-role">Admin & Support</div>
                    <div class="contact-links">
                        
                        <a href="mailto:dewi.wulandari@telkom.co.id" class="contact-link">
                            <div class="contact-link-icon email">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                                </svg>
                            </div>
                            <span class="contact-link-text">dewi.wulandari@telkom.co.id</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ FOOTER ============ -->
    <footer class="footer">

        <p class="footer-desc">
            Platform monitoring proyek deployment Unit Optima — Telkom Witel Jakarta Barat.
        </p>
        <div class="footer-divider"></div>
        <p class="footer-copy">&copy; {{ date('Y') }} PT Telkom Indonesia Tbk. All rights reserved.</p>
    </footer>

    <!-- ============ SCROLL TO TOP ============ -->
    <button class="scroll-top-btn" id="scrollTopBtn" aria-label="Scroll to top">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
        </svg>
    </button>

    <!-- ============ SCRIPTS ============ -->
    <script>
        // ——— SCROLL ANIMATIONS (Intersection Observer) ———
        document.addEventListener('DOMContentLoaded', function() {
            const observer = new IntersectionObserver(
                (entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('visible');
                        }
                    });
                },
                { threshold: 0.1, rootMargin: '0px 0px -50px 0px' }
            );

            document.querySelectorAll('.animate-on-scroll').forEach(el => {
                observer.observe(el);
            });

            // ——— NAVBAR SCROLL EFFECT ———
            const nav = document.getElementById('berandaNav');
            const scrollTopBtn = document.getElementById('scrollTopBtn');

            window.addEventListener('scroll', function() {
                if (window.scrollY > 80) {
                    nav.classList.add('scrolled');
                } else {
                    nav.classList.remove('scrolled');
                }

                if (window.scrollY > 500) {
                    scrollTopBtn.classList.add('visible');
                } else {
                    scrollTopBtn.classList.remove('visible');
                }

                // Update active nav link
                updateActiveNav();
            });

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
            scrollTopBtn.addEventListener('click', function() {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });

            // ——— MOBILE NAV ———
            const hamburger = document.getElementById('navHamburger');
            const mobileOverlay = document.getElementById('mobileOverlay');
            const mobileNav = document.getElementById('mobileNav');
            const mobileClose = document.getElementById('mobileClose');

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

            // ——— HERO PARTICLES ———
            const particlesContainer = document.getElementById('heroParticles');
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
        });
    </script>
</body>
</html>
