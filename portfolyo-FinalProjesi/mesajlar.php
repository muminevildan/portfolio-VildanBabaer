<?php
// 1. Önce oturum başlar
if (session_status() == PHP_SESSION_NONE) session_start();

// 2. Sonra veritabanı bağlantısı gelir
require 'baglanti.php'; 
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gönderilen Mesajlar — Vildan Babaer</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,400&family=Montserrat:wght@200;300;400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --cream: #FFFCF8;
            --soft-pink: #FFE4EC;
            --dusty-rose: #f596b1;
            --rose-deep: #D4849C;
            --sage: #B8D4C0;
            --sage-light: #D4E8D8;
            --charcoal: #2C2C2C;
            --warm-gray: #6B6B6B;
            --light-gray: #E8E8E8;
            --lavender: #e2c6ed;
            --lavender-deep: #c09dd0;
            --peach: #FFD4C4;
            --peach-deep: #F5B8A0;
            --coral: #FFB5A7;
            --coral-soft: #FFD4CC;
            --mint: #C4F0E0;
            --mint-soft: #E0F5EE;
            --champagne: #F5E6D3;
            --gold: #E8D4A8;
            --blush: #F8E0E0;
            --sky-blue: #D4E8F5;
            --butter: #FFF4D4;
            --error: #E57373;
            --error-light: #FFEBEE;
            --success: #81C784;
            --success-light: #E8F5E9;
        }

        [data-theme="dark"] {
            --cream: #1a1a2e;
            --soft-pink: #2d2d44;
            --dusty-rose: #e8a4b8;
            --rose-deep: #f0b8c8;
            --sage: #4a5d5f;
            --sage-light: #3d4f52;
            --charcoal: #f5f0eb;
            --warm-gray: #c8c0b8;
            --light-gray: #4a4a6a;
            --lavender: #d4b8e8;
            --lavender-deep: #c8a8e0;
            --peach: #f0c8b8;
            --peach-deep: #e8b8a0;
            --blush: #2a2a3e;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }

        body {
            font-family: 'Montserrat', sans-serif;
            background: linear-gradient(135deg, var(--cream) 0%, var(--blush) 50%, var(--cream) 100%);
            background-attachment: fixed;
            color: var(--charcoal);
            line-height: 1.8;
            font-weight: 300;
            overflow-x: hidden;
            transition: background 0.5s ease, color 0.5s ease;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        ::selection { background: var(--dusty-rose); color: white; }

        /* ── Organik Arka Plan ─────────────────────────────────────── */
        .organic-bg { position: fixed; width: 100%; height: 100%; top: 0; left: 0; z-index: -1; overflow: hidden; pointer-events: none; }
        .blob { position: absolute; border-radius: 50%; filter: blur(80px); animation: float 15s infinite ease-in-out; will-change: transform; }
        .blob-1 { width: 500px; height: 500px; background: linear-gradient(135deg, var(--soft-pink), var(--lavender)); top: -150px; right: -150px; animation-delay: 0s; }
        .blob-2 { width: 400px; height: 400px; background: linear-gradient(135deg, var(--sage), var(--mint)); bottom: 5%; left: -150px; animation-delay: 3s; }
        .blob-3 { width: 350px; height: 350px; background: linear-gradient(135deg, var(--peach), var(--coral-soft)); top: 35%; right: 5%; animation-delay: 6s; }
        .blob-4 { width: 300px; height: 300px; background: linear-gradient(135deg, var(--champagne), var(--gold)); bottom: 20%; right: 15%; animation-delay: 9s; }
        .blob-5 { width: 250px; height: 250px; background: linear-gradient(135deg, var(--sky-blue), var(--lavender)); top: 60%; left: 10%; animation-delay: 12s; }
        @keyframes float {
            0%, 100% { transform: translate3d(0, 0, 0) scale(1) rotate(0deg); }
            25%  { transform: translate3d(30px, -30px, 0) scale(1.1) rotate(5deg); }
            50%  { transform: translate3d(-20px, 20px, 0) scale(0.95) rotate(-5deg); }
            75%  { transform: translate3d(20px, 10px, 0) scale(1.05) rotate(3deg); }
        }

        .flower-decor { position: fixed; font-size: 2rem; opacity: 0.15; animation: rotate-flower 20s infinite linear; pointer-events: none; z-index: -1; will-change: transform; }
        .flower-1 { top: 15%; left: 5%; animation-delay: 0s; }
        .flower-2 { top: 45%; right: 8%; animation-delay: -5s; font-size: 1.5rem; }
        .flower-3 { bottom: 25%; left: 12%; animation-delay: -10s; font-size: 1.8rem; }
        .flower-4 { top: 70%; right: 3%; animation-delay: -15s; font-size: 1.3rem; }
        .flower-5 { bottom: 10%; right: 20%; animation-delay: -8s; font-size: 2.2rem; }
        @keyframes rotate-flower { 0% { transform: rotate(0deg) translateZ(0); } 100% { transform: rotate(360deg) translateZ(0); } }

        .sparkle { position: fixed; width: 4px; height: 4px; background: var(--gold); border-radius: 50%; opacity: 0; animation: sparkle 4s infinite; pointer-events: none; z-index: -1; will-change: opacity, transform; }
        .sparkle::before, .sparkle::after { content: ''; position: absolute; background: var(--gold); border-radius: 50%; }
        .sparkle::before { width: 12px; height: 2px; top: 1px; left: -4px; }
        .sparkle::after  { width: 2px; height: 12px; top: -4px; left: 1px; }
        .sparkle-1 { top: 20%; left: 15%; animation-delay: 0s; }
        .sparkle-2 { top: 35%; right: 25%; animation-delay: 1s; }
        .sparkle-3 { top: 55%; left: 8%;  animation-delay: 2s; }
        .sparkle-4 { top: 75%; right: 12%; animation-delay: 3s; }
        .sparkle-5 { top: 40%; left: 30%; animation-delay: 0.5s; }
        @keyframes sparkle { 0%, 100% { opacity: 0; transform: scale(0) translateZ(0); } 50% { opacity: 0.8; transform: scale(1) translateZ(0); } }

        /* ── Falling Petals ────────────────────────────────────────── */
        .petal { position: fixed; top: -50px; pointer-events: none; z-index: -1; opacity: 0.6; animation: fall linear infinite; will-change: transform; }
        @keyframes fall { to { transform: translate3d(0, 110vh, 0) rotate(360deg); } }

        /* ── Theme Toggle ──────────────────────────────────────────── */
        .theme-toggle {
            position: fixed; top: 90px; left: 30px; width: 50px; height: 50px;
            border-radius: 50%; background: linear-gradient(135deg, var(--soft-pink), var(--lavender));
            border: none; cursor: pointer; z-index: 900; display: flex;
            align-items: center; justify-content: center; font-size: 1.5rem;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1); transition: all 0.4s ease;
            color: var(--charcoal);
        }
        .theme-toggle:hover { transform: scale(1.1) rotate(15deg); box-shadow: 0 8px 30px rgba(232, 165, 184, 0.4); }

        /* ── Back to Top ───────────────────────────────────────────── */
        .back-to-top {
            position: fixed; bottom: 30px; right: 30px; width: 50px; height: 50px;
            border-radius: 50%; background: linear-gradient(135deg, var(--dusty-rose), var(--lavender-deep));
            border: none; cursor: pointer; z-index: 1000; display: flex;
            align-items: center; justify-content: center; color: white;
            font-size: 1.2rem; opacity: 0; visibility: hidden; transform: translateY(20px);
            transition: all 0.4s ease; box-shadow: 0 5px 20px rgba(232, 165, 184, 0.4);
        }
        .back-to-top.visible { opacity: 1; visibility: visible; transform: translateY(0); }
        .back-to-top:hover { transform: translateY(-5px); box-shadow: 0 10px 30px rgba(232, 165, 184, 0.6); }

        /* ── Visitor Counter ───────────────────────────────────────── */
        .visitor-counter {
            position: fixed; bottom: 30px; left: 30px; background: rgba(255,255,255,0.9);
            padding: 0.8rem 1.2rem; border-radius: 50px; font-size: 0.75rem; letter-spacing: 1px;
            color: var(--warm-gray); backdrop-filter: blur(10px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.1); z-index: 999;
            display: flex; align-items: center; gap: 0.5rem;
        }
        .visitor-counter span {
            background: linear-gradient(135deg, var(--dusty-rose), var(--lavender-deep));
            background-clip: text; -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            font-weight: 500;
        }

        /* ── NAVBAR ────────────────────────────────────────────────── */
        nav {
            position: fixed; top: 0; left: 0; width: 100%;
            padding: 1.2rem 6%; display: flex; justify-content: space-between; align-items: center;
            z-index: 1000; background: rgba(255, 252, 248, 0.85);
            backdrop-filter: blur(15px); -webkit-backdrop-filter: blur(15px);
            border-bottom: 1px solid transparent; transition: all 0.4s ease;
        }
        nav.scrolled {
            border-bottom-color: var(--soft-pink); padding: 0.8rem 6%;
            background: rgba(255, 252, 248, 0.95); box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        }
        [data-theme="dark"] nav { background: rgba(26, 26, 46, 0.9); }
        [data-theme="dark"] nav.scrolled { background: rgba(26, 26, 46, 0.95); border-bottom-color: var(--light-gray); }

        .logo {
            display: flex; align-items: center; text-decoration: none;
            position: relative; z-index: 1002; flex-shrink: 0;
        }

        .nav-right-cluster { display: flex; align-items: center; gap: 0; }
        .nav-links { display: flex; gap: 0; list-style: none; align-items: center; margin: 0; padding: 0; }
        .nav-links.mobile-only { display: none; }

        .welcome-msg {
            font-family: 'Cormorant Garamond', serif; font-style: italic;
            color: var(--dusty-rose); font-size: 1.1rem; letter-spacing: 0.5px;
            white-space: nowrap; padding: 0.5rem 1rem;
        }

        .nav-links a {
            color: var(--warm-gray); text-decoration: none; font-size: 0.85rem;
            letter-spacing: 1.5px; text-transform: uppercase; position: relative;
            padding: 0.5rem 1rem; transition: all 0.3s ease; white-space: nowrap; font-weight: 500;
        }
        .nav-links a::before {
            content: ''; position: absolute; bottom: 0; left: 0; width: 0; height: 2px;
            background: linear-gradient(90deg, var(--dusty-rose), var(--lavender-deep)); transition: width 0.4s ease;
        }
        .nav-links a:hover, .nav-links a.active { color: var(--rose-deep); }
        .nav-links a:hover::before, .nav-links a.active::before { width: 100%; }

        .nav-actions { display: flex; align-items: center; gap: 0; flex-shrink: 0; z-index: 1002; }

        .nav-icon-link {
            display: flex; align-items: center; justify-content: center;
            font-size: 1.2rem; position: relative; width: 40px; height: 40px;
            border-radius: 12px; background: transparent;
            color: var(--warm-gray); transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none; margin: 0 0.2rem;
        }
        .nav-icon-link svg { width: 22px; height: 22px; stroke-width: 1.5; fill: none; stroke: currentColor; }
        .nav-icon-link:hover, .nav-icon-link.active {
            background: var(--soft-pink); color: var(--rose-deep);
            transform: translateY(-3px); box-shadow: 0 5px 15px rgba(232, 165, 184, 0.2);
        }
        [data-theme="dark"] .nav-icon-link { color: var(--light-gray); }
        [data-theme="dark"] .nav-icon-link:hover,
        [data-theme="dark"] .nav-icon-link.active { background: var(--lavender-deep); color: white; }

        .nav-badge {
            position: absolute; top: -5px; right: -5px;
            background: linear-gradient(135deg, var(--dusty-rose), var(--lavender-deep));
            color: white; font-size: 0.65rem; width: 18px; height: 18px; border-radius: 50%;
            display: none; align-items: center; justify-content: center;
            font-weight: 600; box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .nav-auth-btn {
            padding: 0.6rem 1.4rem; border-radius: 50px; font-size: 0.8rem;
            letter-spacing: 1px; text-transform: uppercase; text-decoration: none;
            transition: all 0.3s ease; font-weight: 600; white-space: nowrap; margin-left: 0.5rem;
        }
        .btn-login { color: var(--warm-gray); border: 1px solid var(--light-gray); }
        .btn-login:hover { background: var(--light-gray); color: var(--charcoal); }
        .btn-signup { background: linear-gradient(135deg, var(--dusty-rose), var(--lavender-deep)); color: white; border: none; }
        .btn-signup:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(232, 165, 184, 0.4); }

        /* ── Mobil Hamburger ───────────────────────────────────────── */
        #menu-toggle { display: none; }
        .hamburger {
            display: none; flex-direction: column; justify-content: space-between;
            width: 30px; height: 22px; cursor: pointer; z-index: 1003;
            position: relative; margin-left: 1rem;
        }
        .hamburger span { display: block; width: 100%; height: 2px; background: var(--charcoal); border-radius: 2px; transition: all 0.3s ease; transform-origin: center; }
        .menu-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.4); backdrop-filter: blur(5px);
            opacity: 0; visibility: hidden; transition: all 0.4s ease; z-index: 1000;
        }
        #menu-toggle:checked ~ .menu-overlay { opacity: 1; visibility: visible; }

        /* ── Mesajlar Bölümü ───────────────────────────────────────── */
        section {
            padding: 10rem 10% 6rem; max-width: 1400px; margin: 0 auto;
            position: relative; flex: 1; display: flex;
            flex-direction: column; justify-content: center;
        }
        .section-header { margin-bottom: 4rem; display: flex; align-items: baseline; gap: 2rem; }
        .section-number {
            font-family: 'Cormorant Garamond', serif; font-size: 1rem; font-style: italic;
            background: linear-gradient(135deg, var(--dusty-rose), var(--lavender-deep));
            background-clip: text; -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }
        .section-title {
            font-family: 'Cormorant Garamond', serif; font-size: 3rem;
            font-weight: 300; color: var(--charcoal); position: relative;
        }
        .section-title::after {
            content: ''; position: absolute; bottom: -10px; left: 0; width: 80px; height: 3px;
            background: linear-gradient(90deg, var(--dusty-rose), var(--lavender-deep), var(--peach-deep));
            border-radius: 2px;
        }

        .stats-bar { display: flex; gap: 2rem; margin-bottom: 3rem; flex-wrap: wrap; }
        .stat-item { background: white; padding: 1.5rem 2rem; border-radius: 20px; box-shadow: 0 10px 40px rgba(0,0,0,0.06); display: flex; align-items: center; gap: 1rem; }
        .stat-icon { font-size: 1.5rem; }
        .stat-content { display: flex; flex-direction: column; }
        .stat-number { font-family: 'Cormorant Garamond', serif; font-size: 2rem; font-weight: 600; color: var(--dusty-rose); line-height: 1; }
        .stat-label { font-size: 0.8rem; color: var(--warm-gray); text-transform: uppercase; letter-spacing: 1px; }

        .message-list { display: flex; flex-direction: column; gap: 1.5rem; }
        .message-card { background: white; padding: 2rem; border-radius: 20px; box-shadow: 0 10px 40px rgba(0,0,0,0.06); border-left: 4px solid var(--dusty-rose); transition: all 0.3s ease; animation: slideUp 0.5s ease; }
        .message-card:hover { transform: translateY(-3px); box-shadow: 0 15px 50px rgba(0,0,0,0.1); }
        @keyframes slideUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }

        .message-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; flex-wrap: wrap; gap: 0.5rem; }
        .message-name { font-family: 'Cormorant Garamond', serif; font-size: 1.5rem; font-weight: 600; color: var(--charcoal); }
        .message-date { font-size: 0.75rem; color: var(--warm-gray); background: var(--soft-pink); padding: 0.3rem 1rem; border-radius: 50px; }
        .message-subject { display: inline-block; background: linear-gradient(135deg, var(--lavender), var(--soft-pink)); color: var(--charcoal); padding: 0.4rem 1.2rem; border-radius: 50px; font-size: 0.8rem; font-weight: 500; margin-bottom: 1rem; }
        .message-body { color: var(--warm-gray); line-height: 1.8; font-size: 0.95rem; }
        .message-contact { margin-top: 1rem; padding-top: 1rem; border-top: 1px solid var(--light-gray); font-size: 0.85rem; color: var(--warm-gray); display: flex; gap: 1.5rem; flex-wrap: wrap; }

        .empty-state { text-align: center; padding: 4rem 2rem; color: var(--warm-gray); background: white; border-radius: 20px; box-shadow: 0 10px 40px rgba(0,0,0,0.06); }
        .empty-state-icon { font-size: 3rem; margin-bottom: 1rem; opacity: 0.5; }

        .clear-btn {
            background: linear-gradient(135deg, var(--error), #ef5350); color: white; border: none;
            padding: 0.8rem 1.5rem; font-family: 'Montserrat', sans-serif; font-size: 0.8rem;
            letter-spacing: 1px; text-transform: uppercase; cursor: pointer;
            border-radius: 50px; transition: all 0.4s ease; margin-top: 2rem;
        }
        .clear-btn:hover { transform: translateY(-3px); box-shadow: 0 10px 30px rgba(229,115,115,0.4); }

        /* ── Footer ────────────────────────────────────────────────── */
        footer {
            text-align: center; padding: 2rem;
            background: linear-gradient(180deg, transparent, rgba(255, 228, 236, 0.5));
            color: var(--warm-gray); font-size: 0.85rem; letter-spacing: 1px; margin-top: auto;
        }
        [data-theme="dark"] footer { background: linear-gradient(180deg, transparent, rgba(0,0,0,0.2)); }
        .footer-quote { font-family: 'Cormorant Garamond', serif; font-size: 1.5rem; font-style: italic; background: linear-gradient(135deg, var(--dusty-rose), var(--lavender-deep)); background-clip: text; -webkit-background-clip: text; -webkit-text-fill-color: transparent; margin-bottom: 0.5rem; }
        .footer-hearts { margin-top: 0.5rem; font-size: 1.2rem; animation: heartbeat 1.5s infinite; }
        @keyframes heartbeat { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.1); } }

        [data-theme="dark"] .message-card,
        [data-theme="dark"] .stat-item,
        [data-theme="dark"] .empty-state { background: rgba(40, 40, 60, 0.9); border: 1px solid var(--light-gray); }

        /* ── RESPONSIVE ────────────────────────────────────────────── */
        @media (max-width: 1150px) {
            nav { padding: 1.2rem 5%; }
            .nav-right-cluster { display: none; }
            .hamburger { display: flex; z-index: 1001; margin-left: auto; }

            .nav-links.mobile-only {
                position: fixed; top: 0; right: -100%; width: 80%; max-width: 320px; height: 100vh;
                background: var(--cream); flex-direction: column; justify-content: flex-start;
                align-items: center; gap: 0.5rem; padding: 5rem 1.5rem 2rem;
                transition: right 0.4s ease; box-shadow: -10px 0 30px rgba(0,0,0,0.1);
                z-index: 1001; display: flex; overflow-y: auto;
            }
            #menu-toggle:checked ~ .nav-links.mobile-only { right: 0; }
            [data-theme="dark"] .nav-links.mobile-only { background: #1a1a2e; }

            .close-menu {
                position: absolute; top: 1.5rem; right: 1.5rem; font-size: 1.8rem;
                color: var(--charcoal); cursor: pointer; transition: all 0.3s ease;
                line-height: 1; display: flex; align-items: center; justify-content: center;
                width: 40px; height: 40px; border-radius: 50%;
            }
            .close-menu:hover { color: var(--rose-deep); background: var(--soft-pink); transform: rotate(90deg); }
            [data-theme="dark"] .close-menu { color: var(--warm-gray); }
            [data-theme="dark"] .close-menu:hover { color: white; background: var(--light-gray); }

            #menu-toggle:checked ~ .hamburger span:nth-child(1) { transform: translateY(10px) rotate(45deg); }
            #menu-toggle:checked ~ .hamburger span:nth-child(2) { opacity: 0; }
            #menu-toggle:checked ~ .hamburger span:nth-child(3) { transform: translateY(-10px) rotate(-45deg); }

            .nav-links a { font-size: 1rem; padding: 0.6rem 1rem; }
            .visitor-counter { display: none; }
            .theme-toggle { top: 75px; left: 15px; width: 40px; height: 40px; font-size: 1.2rem; }
        }

        @media (max-width: 968px) {
            section { padding-top: 8rem; padding-bottom: 4rem; }
            .section-title { font-size: 2.5rem; }
            .stats-bar { justify-content: center; }
            .message-header { flex-direction: column; align-items: flex-start; }
        }

        @media (max-width: 480px) {
            .section-title { font-size: 1.8rem; }
            .stat-item { padding: 1rem 1.5rem; }
            .stat-number { font-size: 1.5rem; }
            .message-card { padding: 1.5rem; }
            .message-name { font-size: 1.2rem; }
        }
    </style>
    <base target="_blank">
</head>
<body>

    <!-- Organik Arka Plan -->
    <div class="organic-bg">
        <div class="blob blob-1"></div>
        <div class="blob blob-2"></div>
        <div class="blob blob-3"></div>
        <div class="blob blob-4"></div>
        <div class="blob blob-5"></div>
    </div>

    <div class="flower-decor flower-1">✦</div>
    <div class="flower-decor flower-2">★</div>
    <div class="flower-decor flower-3">★</div>
    <div class="flower-decor flower-4">⋆</div>
    <div class="flower-decor flower-5">✧</div>

    <div class="sparkle sparkle-1"></div>
    <div class="sparkle sparkle-2"></div>
    <div class="sparkle sparkle-3"></div>
    <div class="sparkle sparkle-4"></div>
    <div class="sparkle sparkle-5"></div>

    <button class="theme-toggle" id="themeToggle" title="Tema Değiştir">☀</button>
    <button class="back-to-top" id="backToTop" title="Yukarı Çık">↑</button>

    <div class="visitor-counter">
        <span>✦</span> <span id="visitorCount">0</span> ziyaretçi
    </div>

    <!-- ═══════════════════════════════════════════════════
         NAVBAR — index.php ile birebir aynı yapı
    ════════════════════════════════════════════════════ -->
    <nav id="navbar">
        <a href="index.php" class="logo" target="_self">
            <svg viewBox="0 0 220 70" xmlns="http://www.w3.org/2000/svg" style="height:50px; width:auto;">
                <defs>
                    <linearGradient id="logoGrad" x1="0%" y1="0%" x2="100%" y2="0%">
                        <stop offset="0%" style="stop-color:#2C2C2C"/>
                        <stop offset="100%" style="stop-color:#2C2C2C"/>
                    </linearGradient>
                </defs>
                <text x="8" y="58" font-family="Georgia, 'Times New Roman', serif" font-size="58" font-style="italic" font-weight="300" fill="url(#logoGrad)">MV</text>
                <line x1="84" y1="12" x2="84" y2="62" stroke="#f8b2c7" stroke-width="1.2"/>
                <text x="84" y="36" font-family="sans-serif" font-size="16" fill="#46041e" letter-spacing="3">BABAER</text>
                <text x="96" y="52" font-family="sans-serif" font-size="8.6" fill="#0a0000" letter-spacing="3">PORTFOLYO</text>
            </svg>
        </a>

        <!-- MASAÜSTÜ -->
        <div class="nav-right-cluster">
            <ul class="nav-links">
                <?php if(isset($_SESSION['ad_soyad'])): ?>
                    <li class="welcome-msg">Hoş geldin, <?php echo htmlspecialchars($_SESSION['ad_soyad']); ?></li>
                <?php endif; ?>
                <li><a href="index.php" target="_self">Ana Sayfa</a></li>
                <li><a href="hakkimda.php" target="_self">Hakkımda</a></li>
                <li><a href="projeler.php" target="_self">Projeler</a></li>
                <li><a href="urunler.php" target="_self">Ürünler</a></li>
            </ul>

            <div class="nav-actions">
                <?php if(isset($_SESSION['ad_soyad'])): ?>
                    <a href="mesajlar.php" class="nav-icon-link active" title="Mesajlar" target="_self">
                        <svg viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        <span class="nav-badge" id="mesajBadge">0</span>
                    </a>
                    <a href="iletisim.php" class="nav-icon-link" title="İletişim" target="_self">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                        </svg>
                    </a>
                    <a href="favoriler.php" class="nav-icon-link" title="Favoriler" target="_self">
                        <svg viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                        <span class="nav-badge" id="favoriBadge">0</span>
                    </a>
                    <a href="sepet.php" class="nav-icon-link" title="Sepet" target="_self">
                        <svg viewBox="0 0 24 24"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                        <span class="nav-badge" id="sepetBadge">0</span>
                    </a>
                    <a href="cikis.php" class="nav-icon-link" title="Çıkış" style="color: var(--rose-deep);" target="_self">
                        <svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    </a>
                <?php else: ?>
                    <a href="giris_kayit.php" class="nav-auth-btn btn-signup" target="_self">Giriş / Kayıt</a>
                <?php endif; ?>
            </div>
        </div>

        <!-- MOBİL -->
        <input type="checkbox" id="menu-toggle">
        <label for="menu-toggle" class="hamburger">
            <span></span><span></span><span></span>
        </label>
        <label for="menu-toggle" class="menu-overlay"></label>

        <ul class="nav-links mobile-only">
            <label for="menu-toggle" class="close-menu" title="Menüyü Kapat">✕</label>

            <?php if(isset($_SESSION['ad_soyad'])): ?>
                <li class="welcome-msg" style="margin-bottom: 1rem;">Hoş geldin, <?php echo htmlspecialchars($_SESSION['ad_soyad']); ?></li>
            <?php endif; ?>

            <li><a href="index.php" target="_self">Ana Sayfa</a></li>
            <li><a href="hakkimda.php" target="_self">Hakkımda</a></li>
            <li><a href="projeler.php" target="_self">Projeler</a></li>
            <li><a href="urunler.php" target="_self">Ürünler</a></li>

            <?php if(!isset($_SESSION['ad_soyad'])): ?>
                <li><hr style="width: 50%; border: 0; border-top: 1px solid var(--light-gray); margin: 1rem 0;"></li>
                <li><a href="giris_kayit.php" class="nav-auth-btn btn-signup" target="_self">Giriş / Kayıt</a></li>
            <?php else: ?>
                <li><hr style="width: 50%; border: 0; border-top: 1px solid var(--light-gray); margin: 0.6rem 0;"></li>
                <li style="width:100%; display:flex; flex-direction:column; align-items:center; gap:0.7rem;">
                    <div style="display:grid; grid-template-columns:1fr 1fr; gap:0.7rem; width:220px;">
                        <a href="mesajlar.php" target="_self" title="Mesajlar"
                           style="display:flex;flex-direction:column;align-items:center;justify-content:center;gap:0.3rem;padding:0.8rem;background:linear-gradient(135deg,var(--dusty-rose),var(--lavender-deep));border-radius:16px;text-decoration:none;color:white;font-size:0.65rem;letter-spacing:1px;transition:all 0.3s;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                            Mesajlar
                        </a>
                        <a href="iletisim.php" target="_self" title="İletişim"
                           style="display:flex;flex-direction:column;align-items:center;justify-content:center;gap:0.3rem;padding:0.8rem;background:var(--soft-pink);border-radius:16px;text-decoration:none;color:var(--warm-gray);font-size:0.65rem;letter-spacing:1px;transition:all 0.3s;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                            İletişim
                        </a>
                        <a href="favoriler.php" target="_self" title="Favoriler"
                           style="display:flex;flex-direction:column;align-items:center;justify-content:center;gap:0.3rem;padding:0.8rem;background:var(--soft-pink);border-radius:16px;text-decoration:none;color:var(--warm-gray);font-size:0.65rem;letter-spacing:1px;transition:all 0.3s;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                            Favoriler
                        </a>
                        <a href="sepet.php" target="_self" title="Sepet"
                           style="display:flex;flex-direction:column;align-items:center;justify-content:center;gap:0.3rem;padding:0.8rem;background:var(--soft-pink);border-radius:16px;text-decoration:none;color:var(--warm-gray);font-size:0.65rem;letter-spacing:1px;transition:all 0.3s;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                            Sepet
                        </a>
                    </div>
                    <a href="cikis.php" target="_self"
                       style="display:flex;align-items:center;gap:0.5rem;padding:0.6rem 1.8rem;border-radius:50px;border:1.5px solid var(--dusty-rose);color:var(--rose-deep);text-decoration:none;font-size:0.75rem;letter-spacing:1.5px;text-transform:uppercase;font-weight:500;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                        Çıkış Yap
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
    <!-- ═══════════════════════════════════════════ NAVBAR SONU ═══ -->

    <section id="messages">
        <div class="section-header">
            <span class="section-number">05</span>
            <h1 class="section-title">Gönderilen Mesajlar</h1>
        </div>

        <div class="stats-bar">
            <div class="stat-item">
                <span class="stat-icon">✉</span>
                <div class="stat-content">
                    <span class="stat-number" id="totalCount">0</span>
                    <span class="stat-label">Toplam Mesaj</span>
                </div>
            </div>
            <div class="stat-item">
                <span class="stat-icon">✓</span>
                <div class="stat-content">
                    <span class="stat-number" id="todayCount">0</span>
                    <span class="stat-label">Bugün</span>
                </div>
            </div>
            <div class="stat-item">
                <span class="stat-icon">📅</span>
                <div class="stat-content">
                    <span class="stat-number" id="weekCount">0</span>
                    <span class="stat-label">Bu Hafta</span>
                </div>
            </div>
        </div>

        <div class="message-list" id="messageList"></div>

        <div style="text-align: center;">
            <button class="clear-btn" id="clearBtn" onclick="clearMessages()" style="display: none;">
                Tüm Mesajları Sil
            </button>
        </div>
    </section>

    <footer>
        <p class="footer-quote">"Her mesaj, yeni bir hikayenin başlangıcıdır"</p>
        <p>&copy; 2024 vildanbabaer. Tüm hakları saklıdır.</p>
        <p class="footer-hearts">✦ ✧ ✦</p>
    </footer>

    <script>
        // ── Theme Toggle ────────────────────────────────────────────
        const themeToggle = document.getElementById('themeToggle');
        const html = document.documentElement;
        const savedTheme = localStorage.getItem('theme') || 'light';
        if (savedTheme === 'dark') { html.setAttribute('data-theme', 'dark'); themeToggle.textContent = '☾'; }
        themeToggle.addEventListener('click', () => {
            const newTheme = html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
            html.setAttribute('data-theme', newTheme);
            themeToggle.textContent = newTheme === 'dark' ? '☾' : '☀';
            localStorage.setItem('theme', newTheme);
        });

        // ── Navbar Scroll ───────────────────────────────────────────
        const navbar = document.getElementById('navbar');
        const backToTop = document.getElementById('backToTop');
        window.addEventListener('scroll', () => {
            window.scrollY > 50  ? navbar.classList.add('scrolled')   : navbar.classList.remove('scrolled');
            window.scrollY > 500 ? backToTop.classList.add('visible') : backToTop.classList.remove('visible');
        });
        backToTop.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));

        // ── Mobil Menü ──────────────────────────────────────────────
        const menuToggle = document.getElementById('menu-toggle');
        menuToggle.addEventListener('change', function() {
            document.body.style.overflow = this.checked ? 'hidden' : '';
        });
        document.querySelectorAll('.nav-links.mobile-only a, .menu-overlay').forEach(link => {
            link.addEventListener('click', () => { menuToggle.checked = false; document.body.style.overflow = ''; });
        });

        // ── Visitor Counter ─────────────────────────────────────────
        (function() {
            let count = localStorage.getItem('visitorCount');
            count = count ? parseInt(count) + 1 : Math.floor(Math.random() * 1000) + 500;
            localStorage.setItem('visitorCount', count);
            document.getElementById('visitorCount').textContent = count;
        })();

        // ── Falling Petals ──────────────────────────────────────────
        function createPetal() {
            const petal = document.createElement('div');
            petal.className = 'petal';
            petal.innerHTML = ['✦','✧','⋆','★'][Math.floor(Math.random() * 4)];
            petal.style.left = Math.random() * 100 + 'vw';
            petal.style.fontSize = (Math.random() * 15 + 10) + 'px';
            petal.style.animationDuration = (Math.random() * 5 + 5) + 's';
            petal.style.color = ['var(--dusty-rose)','var(--lavender-deep)','var(--peach-deep)','var(--sage)'][Math.floor(Math.random() * 4)];
            document.body.appendChild(petal);
            setTimeout(() => petal.remove(), 10000);
        }
        setInterval(createPetal, 3000);

        // ── Mesajları Yükle ─────────────────────────────────────────
        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        function loadMessages() {
            const messages = JSON.parse(localStorage.getItem('contactMessages') || '[]');
            const list = document.getElementById('messageList');
            const totalCount = document.getElementById('totalCount');
            const todayCount = document.getElementById('todayCount');
            const weekCount = document.getElementById('weekCount');
            const clearBtn = document.getElementById('clearBtn');

            totalCount.textContent = messages.length;

            const now = new Date();
            const today = new Date(now.getFullYear(), now.getMonth(), now.getDate());
            const weekAgo = new Date(today.getTime() - 7 * 24 * 60 * 60 * 1000);

            let todayNum = 0, weekNum = 0;
            messages.forEach(msg => {
                const msgDate = new Date(msg.id);
                if (msgDate >= today) todayNum++;
                if (msgDate >= weekAgo) weekNum++;
            });
            todayCount.textContent = todayNum;
            weekCount.textContent = weekNum;

            if (messages.length === 0) {
                list.innerHTML = `
                    <div class="empty-state">
                        <div class="empty-state-icon">✉</div>
                        <p>Henüz gönderilmiş mesaj yok.</p>
                        <p style="font-size:0.85rem;margin-top:0.5rem;">İletişim formundan mesaj gönderdiğinizde burada görünecek.</p>
                    </div>`;
                clearBtn.style.display = 'none';
                return;
            }

            clearBtn.style.display = 'inline-block';
            list.innerHTML = messages.map((msg, index) => `
                <div class="message-card" style="animation-delay:${index * 0.1}s">
                    <div class="message-header">
                        <span class="message-name">${escapeHtml(msg.ad_soyad)}</span>
                        <span class="message-date">${msg.tarih}</span>
                    </div>
                    <span class="message-subject">${escapeHtml(msg.konu)}</span>
                    <p class="message-body">${escapeHtml(msg.mesaj)}</p>
                    <div class="message-contact">
                        <span>✉ ${escapeHtml(msg.email)}</span>
                        ${msg.telefon !== 'Belirtilmedi' ? `<span>☎ ${escapeHtml(msg.telefon)}</span>` : ''}
                    </div>
                </div>
            `).join('');
        }

        function clearMessages() {
            if (confirm('Tüm mesajları silmek istediğinize emin misiniz?')) {
                localStorage.removeItem('contactMessages');
                loadMessages();
            }
        }

        loadMessages();
    </script>

    <script src="urunler.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof UrunlerApp !== 'undefined') {
                UrunlerApp.temaYukle();
                UrunlerApp.badgeYukle();
            }
        });
    </script>
</body>
</html>