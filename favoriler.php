<?php
if (session_status() == PHP_SESSION_NONE) session_start();
require 'baglanti.php'; 
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Favorilerim — Vildan Babaer</title>
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
            min-height: 100vh;
        }

        /* Theme Toggle */
        .theme-toggle {
            position: fixed; top: 90px; left: 30px; width: 50px; height: 50px;
            border-radius: 50%; background: linear-gradient(135deg, var(--soft-pink), var(--lavender));
            border: none; cursor: pointer; z-index: 900; display: flex;
            align-items: center; justify-content: center; font-size: 1.5rem;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1); transition: all 0.4s ease;
            color: var(--charcoal);
        }
        .theme-toggle:hover { transform: scale(1.1) rotate(15deg); box-shadow: 0 8px 30px rgba(232, 165, 184, 0.4); }

        /* Back to Top */
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

        /* =====================
           NAVBAR — BOŞLUKSUZ YAPI (YENİ DÜZEN)
           ===================== */
        nav {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            padding: 1.2rem 6%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 1000;
            background: rgba(255, 252, 248, 0.85);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-bottom: 1px solid transparent;
            transition: all 0.4s ease;
        }
        nav.scrolled {
            border-bottom-color: var(--soft-pink);
            padding: 0.8rem 6%;
            background: rgba(255, 252, 248, 0.95);
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        }
        [data-theme="dark"] nav { background: rgba(26, 26, 46, 0.9); }
        [data-theme="dark"] nav.scrolled { background: rgba(26, 26, 46, 0.95); border-bottom-color: var(--light-gray); }

        .logo {
            font-family: 'Cormorant Garamond', serif; font-size: 1.8rem; font-weight: 400;
            letter-spacing: 2px; color: var(--charcoal); text-decoration: none;
            position: relative; z-index: 1002; flex-shrink: 0;
        }

        /* Tüm sağ/orta alanı boşluksuz saran ana yapı */
        .nav-right-cluster {
            display: flex;
            align-items: center;
            gap: 0; /* Aradaki yapısal boşluklar tamamen kaldırıldı */
        }

        .nav-links { 
            display: flex; 
            gap: 0; /* Boşluk kaldırıldı */
            list-style: none; 
            align-items: center; 
            margin: 0; 
            padding: 0; 
        }
        
        .nav-links.mobile-only { display: none; }
        
        /* Hoş geldin mesajı */
        .welcome-msg {
            font-family: 'Cormorant Garamond', serif; font-style: italic;
            color: var(--dusty-rose); font-size: 1.1rem; letter-spacing: 0.5px;
            white-space: nowrap;
            padding: 0.5rem 1rem; /* Sadece metinlerin yapışmaması için hafif iç boşluk */
        }

        .nav-links a {
            color: var(--warm-gray); text-decoration: none; font-size: 0.85rem;
            letter-spacing: 1.5px; text-transform: uppercase; position: relative;
            padding: 0.5rem 1rem; /* Yapısal boşluk yerine kendi paddingleri var */
            transition: all 0.3s ease; white-space: nowrap; font-weight: 500;
        }
        .nav-links a::before {
            content: ''; position: absolute; bottom: 0; left: 0; width: 0; height: 2px;
            background: linear-gradient(90deg, var(--dusty-rose), var(--lavender-deep)); transition: width 0.4s ease;
        }
        .nav-links a:hover { color: var(--rose-deep); }
        .nav-links a:hover::before { width: 100%; }
        .nav-links a.active { color: var(--rose-deep); }
        .nav-links a.active::before { width: 100%; }

        /* Sağ ikon ve buton alanı (Boşluksuz) */
        .nav-actions {
            display: flex;
            align-items: center;
            gap: 0; /* Boşluk kaldırıldı */
            flex-shrink: 0;
            z-index: 1002;
        }

        .nav-icon-link {
            display: flex; align-items: center; justify-content: center;
            font-size: 1.2rem; position: relative; width: 40px; height: 40px;
            border-radius: 12px; background: transparent;
            color: var(--warm-gray); transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none; margin: 0 0.2rem;
        }
        .nav-icon-link svg { width: 22px; height: 22px; stroke-width: 1.5; fill: none; stroke: currentColor; }
        .nav-icon-link:hover {
            background: var(--soft-pink); color: var(--rose-deep);
            transform: translateY(-3px); box-shadow: 0 5px 15px rgba(232, 165, 184, 0.2);
        }

        [data-theme="dark"] .nav-icon-link { color: var(--light-gray); }
        [data-theme="dark"] .nav-icon-link:hover { background: var(--lavender-deep); color: white; }

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
        .btn-signup { background: linear-gradient(135deg, var(--dusty-rose), var(--lavender-deep)); color: white; border: none; }
        .btn-signup:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(232, 165, 184, 0.4); }

        /* Mobil Hamburger */
        #menu-toggle { display: none; }
        .hamburger {
            display: none; flex-direction: column; justify-content: space-between;
            width: 30px; height: 22px; cursor: pointer; z-index: 1003; position: relative; margin-left: 1rem;
        }
        .hamburger span { display: block; width: 100%; height: 2px; background: var(--charcoal); border-radius: 2px; transition: all 0.3s ease; transform-origin: center; }
        .menu-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.4); backdrop-filter: blur(5px);
            opacity: 0; visibility: hidden; transition: all 0.4s ease; z-index: 1000;
        }
        #menu-toggle:checked ~ .menu-overlay { opacity: 1; visibility: visible; }

        /* RESPONSIVE */
        @media (max-width: 1150px) {
            nav { padding: 1.2rem 5%; }
            .nav-right-cluster { display: none; /* Mobilde bu yapıyı gizle */ }
            .hamburger { display: flex; z-index: 1001; margin-left: auto; }
            .nav-links.mobile-only {
                position: fixed; top: 0; right: -100%; width: 80%; max-width: 320px; height: 100vh;
                background: var(--cream); flex-direction: column; justify-content: flex-start;
                align-items: center; gap: 0.5rem; padding: 5rem 1.5rem 2rem; transition: right 0.4s ease;
                box-shadow: -10px 0 30px rgba(0,0,0,0.1); z-index: 1001; display: flex;
                overflow-y: auto;
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
        }

        /* Sayfa İçeriği */
        .page-hero {
            min-height: 40vh; display: flex; align-items: center; justify-content: center;
            padding: 10rem 10% 3rem; text-align: center;
        }
        .page-greeting {
            font-family: 'Cormorant Garamond', serif; font-size: 1.3rem; font-style: italic;
            background: linear-gradient(135deg, var(--dusty-rose), var(--lavender-deep));
            background-clip: text; -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            margin-bottom: 1rem; display: block; letter-spacing: 2px;
        }
        .page-title {
            font-family: 'Cormorant Garamond', serif; font-size: 3.5rem;
            font-weight: 300; color: var(--charcoal); margin-bottom: 1rem;
        }
        .page-title span {
            font-style: italic;
            background: linear-gradient(135deg, var(--dusty-rose), var(--peach-deep), var(--lavender-deep));
            background-clip: text; -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }
        .page-subtitle {
            font-size: 1.05rem; color: var(--warm-gray); max-width: 600px;
            margin: 0 auto; line-height: 2;
        }

        .favoriler-section { padding: 2rem 10% 6rem; max-width: 1400px; margin: 0 auto; }
        .urunler-grid {
            display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 2.5rem;
        }

        .urun-kart {
            background: white; border-radius: 25px; overflow: hidden;
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex; flex-direction: column;
            animation: fadeInUp 0.6s ease forwards; opacity: 0;
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .urun-kart:hover { transform: translateY(-12px) scale(1.02); box-shadow: 0 30px 60px rgba(0,0,0,0.15); }
        [data-theme="dark"] .urun-kart { background: rgba(40, 40, 60, 0.9); border: 1px solid var(--light-gray); }

        .urun-resim { position: relative; width: 100%; aspect-ratio: 4/3; overflow: hidden; }
        .urun-resim img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.6s ease; }
        .urun-kart:hover .urun-resim img { transform: scale(1.08); }
        .urun-overlay {
            position: absolute; top: 1rem; right: 1rem;
            opacity: 0; transform: translateY(-10px); transition: all 0.4s ease;
        }
        .urun-kart:hover .urun-overlay { opacity: 1; transform: translateY(0); }
        .btn-favori {
            width: 45px; height: 45px; border-radius: 50%;
            background: rgba(255,255,255,0.95); border: none; cursor: pointer;
            font-size: 1.4rem; display: flex; align-items: center; justify-content: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.15); transition: all 0.3s ease; color: var(--warm-gray);
        }
        .btn-favori:hover { transform: scale(1.15); background: var(--soft-pink); }
        .btn-favori.favori-aktif { background: linear-gradient(135deg, var(--dusty-rose), var(--lavender-deep)); color: white; }

        .urun-bilgi { padding: 1.8rem; flex: 1; display: flex; flex-direction: column; }
        .urun-kategori {
            display: inline-block; padding: 0.3rem 1rem;
            background: linear-gradient(135deg, var(--soft-pink), var(--lavender));
            border-radius: 50px; font-size: 0.7rem; letter-spacing: 1px;
            text-transform: uppercase; color: var(--charcoal); margin-bottom: 0.8rem; align-self: flex-start;
        }
        .urun-ad { font-family: 'Cormorant Garamond', serif; font-size: 1.5rem; font-weight: 400; color: var(--charcoal); margin-bottom: 0.5rem; }
        .urun-aciklama { color: var(--warm-gray); font-size: 0.9rem; line-height: 1.7; margin-bottom: 1rem; flex: 1; }
        .urun-etiketler { display: flex; flex-wrap: wrap; gap: 0.4rem; margin-bottom: 1.2rem; }
        .etiket {
            padding: 0.25rem 0.7rem; background: var(--cream);
            border: 1px solid var(--light-gray); border-radius: 15px;
            font-size: 0.7rem; color: var(--warm-gray); transition: all 0.3s ease;
        }
        .urun-kart:hover .etiket { border-color: var(--dusty-rose); color: var(--dusty-rose); }
        .urun-fiyat-row {
            display: flex; justify-content: space-between; align-items: center;
            padding-top: 1rem; border-top: 1px solid var(--light-gray);
        }
        .urun-fiyat { font-family: 'Montserrat', sans-serif; font-weight: 500; color: var(--charcoal); font-size: 1.1rem; }
        .btn-sepet {
            padding: 0.6rem 1.2rem; background: linear-gradient(135deg, var(--dusty-rose), var(--lavender-deep));
            color: white; border: none; border-radius: 50px; cursor: pointer;
            font-family: 'Montserrat', sans-serif; font-size: 0.8rem;
            letter-spacing: 1px; transition: all 0.4s ease;
            box-shadow: 0 5px 15px rgba(232, 165, 184, 0.3);
        }
        .btn-sepet:hover { transform: translateY(-3px); box-shadow: 0 10px 25px rgba(232, 165, 184, 0.5); }

        .bos-durum { text-align: center; padding: 5rem 2rem; grid-column: 1 / -1; }
        .bos-durum h3 { font-family: 'Cormorant Garamond', serif; font-size: 2rem; color: var(--charcoal); margin-bottom: 1rem; }
        .bos-durum p { color: var(--warm-gray); font-size: 1.05rem; }
        .bos-durum a {
            color: var(--dusty-rose); text-decoration: none; font-weight: 500;
            border-bottom: 2px solid var(--dusty-rose); padding-bottom: 2px; transition: all 0.3s ease;
        }
        .bos-durum a:hover { color: var(--lavender-deep); border-color: var(--lavender-deep); }

        .favori-bilgi {
            text-align: center; margin-bottom: 3rem;
            padding: 1.5rem; background: white; border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.06);
            max-width: 600px; margin-left: auto; margin-right: auto;
        }
        [data-theme="dark"] .favori-bilgi { background: rgba(40, 40, 60, 0.9); border: 1px solid var(--light-gray); }
        .favori-bilgi p { color: var(--warm-gray); font-size: 0.95rem; }
        .favori-bilgi strong {
            background: linear-gradient(135deg, var(--dusty-rose), var(--lavender-deep));
            background-clip: text; -webkit-background-clip: text; -webkit-text-fill-color: transparent;
        }

        footer {
            text-align: center; padding: 4rem 2rem;
            background: linear-gradient(180deg, transparent, rgba(255, 228, 236, 0.5));
            color: var(--warm-gray); font-size: 0.85rem; letter-spacing: 1px;
        }
        [data-theme="dark"] footer { background: linear-gradient(180deg, transparent, rgba(0,0,0,0.2)); }
        .footer-quote {
            font-family: 'Cormorant Garamond', serif; font-size: 1.5rem; font-style: italic;
            background: linear-gradient(135deg, var(--dusty-rose), var(--lavender-deep));
            background-clip: text; -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            margin-bottom: 1rem;
        }
        @keyframes heartbeat { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.1); } }

        @media (max-width: 968px) {
            .theme-toggle { top: 75px; left: 15px; width: 40px; height: 40px; font-size: 1.2rem; }
        }
        @media (max-width: 768px) {
            .page-title { font-size: 2.5rem; }
            .urunler-grid { grid-template-columns: 1fr; gap: 2rem; }
        }
        @media (max-width: 480px) {
            .logo { font-size: 1.4rem; }
        }
        .logo { 
            display: flex; 
            align-items: center; 
            text-decoration: none; 
            position: relative; 
            z-index: 1002; 
            flex-shrink: 0; 
        }
    </style>
    <base target="_blank">
</head>
<body>

    <button class="theme-toggle" id="themeToggle" title="Tema Değiştir">☀</button>
    <button class="back-to-top" id="backToTop" title="Yukarı Çık">↑</button>

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
                    <a href="mesajlar.php" class="nav-icon-link" title="Mesajlar" target="_self">
                        <svg viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        <span class="nav-badge" id="mesajBadge">0</span>
                    </a>
                    <a href="iletisim.php" class="nav-icon-link" title="İletişim" target="_self">
                     <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                      <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
                     </svg>
                    </a>

                    <a href="favoriler.php" class="nav-icon-link active" title="Favoriler" target="_self">
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
                        <a href="mesajlar.php" target="_self" title="Mesajlar" style="display:flex;flex-direction:column;align-items:center;justify-content:center;gap:0.3rem;padding:0.8rem;background:var(--soft-pink);border-radius:16px;text-decoration:none;color:var(--warm-gray);font-size:0.65rem;letter-spacing:1px;transition:all 0.3s;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                            Mesajlar
                        </a>
                        <a href="iletisim.php" target="_self" title="İletişim" style="display:flex;flex-direction:column;align-items:center;justify-content:center;gap:0.3rem;padding:0.8rem;background:var(--soft-pink);border-radius:16px;text-decoration:none;color:var(--warm-gray);font-size:0.65rem;letter-spacing:1px;transition:all 0.3s;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                            İletişim
                        </a>
                        <a href="favoriler.php" target="_self" title="Favoriler" style="display:flex;flex-direction:column;align-items:center;justify-content:center;gap:0.3rem;padding:0.8rem;background:var(--soft-pink);border-radius:16px;text-decoration:none;color:var(--warm-gray);font-size:0.65rem;letter-spacing:1px;transition:all 0.3s;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                            Favoriler
                        </a>
                        <a href="sepet.php" target="_self" title="Sepet" style="display:flex;flex-direction:column;align-items:center;justify-content:center;gap:0.3rem;padding:0.8rem;background:var(--soft-pink);border-radius:16px;text-decoration:none;color:var(--warm-gray);font-size:0.65rem;letter-spacing:1px;transition:all 0.3s;">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                            Sepet
                        </a>
                    </div>
                    <a href="cikis.php" target="_self" style="display:flex;align-items:center;gap:0.5rem;padding:0.6rem 1.8rem;border-radius:50px;border:1.5px solid var(--dusty-rose);color:var(--rose-deep);text-decoration:none;font-size:0.75rem;letter-spacing:1.5px;text-transform:uppercase;font-weight:500;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                        Çıkış Yap
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>

    <section class="page-hero">
        <div>
            <span class="page-greeting">Koleksiyonunuz</span>
            <h1 class="page-title">Favori <span>Ürünlerim</span></h1>
            <p class="page-subtitle">
                Beğendiğiniz ürünleri burada bulabilirsiniz. İstediğiniz zaman sepete ekleyebilir veya favorilerden çıkarabilirsiniz.
            </p>
        </div>
    </section>

    <section class="favoriler-section">
        <div class="favori-bilgi">
            <p>Toplam <strong id="favoriSayi">0</strong> favori ürününüz var.
               Sepetinizde <strong id="sepetSayi">0</strong> ürün bulunuyor.</p>
        </div>
        <div class="urunler-grid" id="favorilerGrid">
            <!-- Favori kartları JavaScript ile buraya gelecek -->
        </div>
    </section>

    <footer>
        <div class="footer-quote">"Yaratmak, ruhun nefes almasıdır"</div>
        <p>&copy; 2024 vildanbabaer. Tüm hakları saklıdır.</p>
        <p style="margin-top:1rem;font-size:1.2rem;animation:heartbeat 1.5s infinite">✦ ✧ ✦</p>
    </footer>

    <script src="urunler.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', async () => {
            try {
                if (typeof UrunlerApp !== 'undefined') {
                    UrunlerApp.temaYukle();
                    await UrunlerApp.urunleriYukle();
                    const grid = document.getElementById('favorilerGrid');
                    if (grid) UrunlerApp.favorilerRender(grid);
                    const favoriSayi = document.getElementById('favoriSayi');
                    const sepetSayi = document.getElementById('sepetSayi');
                    if (favoriSayi) favoriSayi.textContent = UrunlerApp.favorileriGetir().length;
                    if (sepetSayi) sepetSayi.textContent = UrunlerApp.sepetToplamAdet();
                    UrunlerApp.badgeYukle();
                }

                // Theme toggle
                const themeToggle = document.getElementById('themeToggle');
                if (themeToggle) {
                    themeToggle.addEventListener('click', () => {
                        if (typeof UrunlerApp !== 'undefined') UrunlerApp.temaToggle();
                    });
                }

                // Navbar scroll
                const navbar = document.getElementById('navbar');
                window.addEventListener('scroll', () => {
                    window.scrollY > 50 ? navbar.classList.add('scrolled') : navbar.classList.remove('scrolled');
                });

                // Back to top
                const backToTop = document.getElementById('backToTop');
                window.addEventListener('scroll', () => {
                    window.scrollY > 500 ? backToTop.classList.add('visible') : backToTop.classList.remove('visible');
                });
                backToTop.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));

                // Mobil menü
                const menuToggle = document.getElementById('menu-toggle');
                menuToggle.addEventListener('change', function() {
                    document.body.style.overflow = this.checked ? 'hidden' : '';
                });
                document.querySelectorAll('.nav-links.mobile-only a, .menu-overlay').forEach(link => {
                    link.addEventListener('click', () => {
                        menuToggle.checked = false;
                        document.body.style.overflow = '';
                    });
                });

            } catch (hata) {
                console.error('Sayfa yüklenirken hata:', hata);
            }
        });
    </script>
</body>
</html>
