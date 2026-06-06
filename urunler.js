// ==========================================
// URUNLER.JS - Ortak Modül
// JSON'dan veri okuma + localStorage yönetimi
// ==========================================

const UrunlerApp = {
    keys: {
        favoriler: 'vildan_favoriler',
        sepet: 'vildan_sepet',
        tema: 'theme'
    },
    urunler: [],
    veriYuklendi: false,

    // ==========================================
    // VERİ YÜKLEME (fetch + inline fallback)
    // ==========================================
    async urunleriYukle() {
        if (this.veriYuklendi && this.urunler.length > 0) {
            return this.urunler;
        }

        try {
            const response = await fetch('urunler.json');
            if (!response.ok) throw new Error('JSON yüklenemedi');
            const data = await response.json();
            this.urunler = data;
            this.veriYuklendi = true;
            console.log('✅ JSON\'dan', this.urunler.length, 'ürün yüklendi');
        } catch (e) {
            console.warn('⚠️ JSON fetch başarısız, inline veri kullanılıyor:', e);
            this.urunler = this.inlineUrunler;
            this.veriYuklendi = true;
        }
        return this.urunler;
    },

    // ==========================================
    // INLINE VERİ (fetch başarısız olursa yedek)
    // ==========================================
    inlineUrunler: [
        {"id":1,"ad":"Web Tasarım Paketi","kategori":"web","aciklama":"Modern, responsive web sitesi tasarımı. 5 sayfa, mobil uyumlu, temel SEO optimizasyonu içerir.","fiyat":2500,"paraBirimi":"₺","resim":"https://images.unsplash.com/photo-1467232004584-a241de8bcf5d?w=400&h=300&fit=crop","etiketler":["HTML5","CSS3","Responsive"],"stok":10},
        {"id":2,"ad":"UI/UX Tasarım Danışmanlığı","kategori":"tasarim","aciklama":"Kullanıcı deneyimi analizi, wireframe oluşturma ve prototip tasarımı. Figma dosyası teslim edilir.","fiyat":1800,"paraBirimi":"₺","resim":"https://images.unsplash.com/photo-1561070791-2526d30994b5?w=400&h=300&fit=crop","etiketler":["Figma","Prototip","UX"],"stok":5},
        {"id":3,"ad":"E-Ticaret Sitesi Geliştirme","kategori":"web","aciklama":"Tam donanımlı e-ticaret platformu. Ödeme entegrasyonu, ürün yönetimi ve admin paneli içerir.","fiyat":5500,"paraBirimi":"₺","resim":"https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=400&h=300&fit=crop","etiketler":["React","Node.js","MongoDB"],"stok":3},
        {"id":4,"ad":"Sosyal Medya Görsel Paketi","kategori":"tasarim","aciklama":"Instagram, Facebook ve Twitter için 30 adet özel tasarım görsel. Marka kimliğinize uygun.","fiyat":900,"paraBirimi":"₺","resim":"https://images.unsplash.com/photo-1611162617213-7d7a39e9b1d7?w=400&h=300&fit=crop","etiketler":["Photoshop","Canva","Sosyal Medya"],"stok":20},
        {"id":5,"ad":"Logo ve Marka Kimliği","kategori":"marka","aciklama":"Profesyonel logo tasarımı, kartvizit, antetli kağıt ve marka rehberi. 3 revizyon hakkı.","fiyat":1200,"paraBirimi":"₺","resim":"https://images.unsplash.com/photo-1626785774573-4b799315345d?w=400&h=300&fit=crop","etiketler":["Illustrator","Marka","Logo"],"stok":8},
        {"id":6,"ad":"JavaScript Eğitim Videosu","kategori":"egitim","aciklama":"Temel JavaScript konseptlerini anlatan 10 bölümlük video serisi. Kaynak kodları dahil.","fiyat":450,"paraBirimi":"₺","resim":"https://images.unsplash.com/photo-1579468118864-1b9ea3c0db4a?w=400&h=300&fit=crop","etiketler":["JavaScript","Eğitim","Video"],"stok":50},
        {"id":7,"ad":"Mobil Uygulama UI Kiti","kategori":"tasarim","aciklama":"iOS ve Android için 50+ ekran tasarımı. Figma'da düzenlenebilir, otomatik layout destekli.","fiyat":750,"paraBirimi":"₺","resim":"https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?w=400&h=300&fit=crop","etiketler":["Figma","Mobile","UI Kit"],"stok":15},
        {"id":8,"ad":"SEO ve Performans Optimizasyonu","kategori":"web","aciklama":"Mevcut sitenizin hız, SEO ve erişilebilirlik analizi. Rapor ve iyileştirme önerileri.","fiyat":1100,"paraBirimi":"₺","resim":"https://images.unsplash.com/photo-1432888498266-38ffec3eaf0a?w=400&h=300&fit=crop","etiketler":["SEO","Analytics","Performans"],"stok":6}
    ],

    // ==========================================
    // localStorage - Favoriler
    // ==========================================
    favorileriGetir() {
        try {
            const veri = localStorage.getItem(this.keys.favoriler);
            return veri ? JSON.parse(veri) : [];
        } catch (e) {
            return [];
        }
    },

    favoriyeEkle(urunId) {
        let favoriler = this.favorileriGetir();
        if (!favoriler.includes(urunId)) {
            favoriler.push(urunId);
            localStorage.setItem(this.keys.favoriler, JSON.stringify(favoriler));
            this.badgeGuncelle('favoriBadge', favoriler.length);
            this.bildirimGoster('♡ Favorilere eklendi!');
            return true;
        }
        return false;
    },

    favoridenCikar(urunId) {
        let favoriler = this.favorileriGetir();
        favoriler = favoriler.filter(id => id !== urunId);
        localStorage.setItem(this.keys.favoriler, JSON.stringify(favoriler));
        this.badgeGuncelle('favoriBadge', favoriler.length);
        this.bildirimGoster('Favorilerden çıkarıldı');
        return favoriler;
    },

    favoriMi(urunId) {
        return this.favorileriGetir().includes(urunId);
    },

    // ==========================================
    // localStorage - Sepet
    // ==========================================
    sepetiGetir() {
        try {
            const veri = localStorage.getItem(this.keys.sepet);
            return veri ? JSON.parse(veri) : [];
        } catch (e) {
            return [];
        }
    },

    sepeteEkle(urunId) {
        let sepet = this.sepetiGetir();
        const mevcut = sepet.find(item => item.id === urunId);
        if (mevcut) {
            mevcut.adet += 1;
        } else {
            sepet.push({ id: urunId, adet: 1 });
        }
        localStorage.setItem(this.keys.sepet, JSON.stringify(sepet));
        this.badgeGuncelle('sepetBadge', this.sepetToplamAdet());
        this.bildirimGoster('🛒 Sepete eklendi!');
        return sepet;
    },

    sepettenCikar(urunId) {
        let sepet = this.sepetiGetir();
        sepet = sepet.filter(item => item.id !== urunId);
        localStorage.setItem(this.keys.sepet, JSON.stringify(sepet));
        this.badgeGuncelle('sepetBadge', this.sepetToplamAdet());
        // Eğer sepet sayfasındaysak arayüzü güncelle
        if (document.getElementById('sepetListesi')) {
            this.sepetSayfasiniGuncelle();
        }
        return sepet;
    },

    sepetAdetGuncelle(urunId, adet) {
        let sepet = this.sepetiGetir();
        const item = sepet.find(i => i.id === urunId);
        if (item) {
            if (adet <= 0) {
                return this.sepettenCikar(urunId);
            }
            item.adet = adet;
            localStorage.setItem(this.keys.sepet, JSON.stringify(sepet));
            this.badgeGuncelle('sepetBadge', this.sepetToplamAdet());
        }
        return sepet;
    },

    sepetToplamAdet() {
        return this.sepetiGetir().reduce((toplam, item) => toplam + item.adet, 0);
    },

    sepetToplamTutar() {
        const sepet = this.sepetiGetir();
        return sepet.reduce((toplam, item) => {
            const urun = this.urunler.find(u => u.id === item.id);
            return toplam + (urun ? urun.fiyat * item.adet : 0);
        }, 0);
    },

    // ==========================================
    // Kart HTML
    // ==========================================
    kartOlustur(urun) {
        const favoriClass = this.favoriMi(urun.id) ? 'favori-aktif' : '';
        const favoriText = this.favoriMi(urun.id) ? '♥' : '♡';
        return `
            <div class="urun-kart" data-id="${urun.id}" data-kategori="${urun.kategori}">
                <div class="urun-resim">
                    <img src="${urun.resim}" alt="${urun.ad}" loading="lazy" onerror="this.src='https://via.placeholder.com/400x300?text=${encodeURIComponent(urun.ad)}'">
                    <div class="urun-overlay">
                        <button class="btn-favori ${favoriClass}" onclick="UrunlerApp.favoriToggle(${urun.id})" title="Favorilere Ekle">
                            ${favoriText}
                        </button>
                    </div>
                </div>
                <div class="urun-bilgi">
                    <span class="urun-kategori">${urun.kategori.toUpperCase()}</span>
                    <h3 class="urun-ad">${urun.ad}</h3>
                    <p class="urun-aciklama">${urun.aciklama}</p>
                    <div class="urun-etiketler">
                        ${urun.etiketler.map(e => `<span class="etiket">${e}</span>`).join('')}
                    </div>
                    <div class="urun-fiyat-row">
                        <span class="urun-fiyat">${urun.fiyat.toLocaleString('tr-TR')} ${urun.paraBirimi}</span>
                        <button class="btn-sepet" onclick="UrunlerApp.sepeteEkle(${urun.id})" title="Sepete Ekle">
                            🛒 Sepete Ekle
                        </button>
                    </div>
                </div>
            </div>
        `;
    },

    favoriToggle(urunId) {
        if (this.favoriMi(urunId)) {
            this.favoridenCikar(urunId);
        } else {
            this.favoriyeEkle(urunId);
        }
        this.kartGuncelle(urunId);
        if (window.location.pathname.includes('favoriler')) {
            setTimeout(() => this.favorilerRender(document.getElementById('favorilerGrid')), 300);
        }
    },

    kartGuncelle(urunId) {
        const kart = document.querySelector(`.urun-kart[data-id="${urunId}"]`);
        if (kart) {
            const btn = kart.querySelector('.btn-favori');
            const isFav = this.favoriMi(urunId);
            btn.classList.toggle('favori-aktif', isFav);
            btn.innerHTML = isFav ? '♥' : '♡';
        }
    },

    // ==========================================
    // Badge
    // ==========================================
    badgeGuncelle(id, sayi) {
        const badge = document.getElementById(id);
        if (badge) {
            badge.textContent = sayi;
            badge.style.display = sayi > 0 ? 'flex' : 'none';
            badge.style.transform = 'scale(1.3)';
            setTimeout(() => badge.style.transform = 'scale(1)', 200);
        }
    },

    badgeYukle() {
        this.badgeGuncelle('favoriBadge', this.favorileriGetir().length);
        this.badgeGuncelle('sepetBadge', this.sepetToplamAdet());
    },

    // ==========================================
    // Toast Bildirim
    // ==========================================
    bildirimGoster(mesaj) {
        let toast = document.getElementById('toastBildirim');
        if (!toast) {
            toast = document.createElement('div');
            toast.id = 'toastBildirim';
            toast.style.cssText = `
                position: fixed;
                bottom: 100px;
                left: 50%;
                transform: translateX(-50%) translateY(100px);
                background: linear-gradient(135deg, #f596b1, #c09dd0);
                color: white;
                padding: 1rem 2rem;
                border-radius: 50px;
                font-size: 0.9rem;
                z-index: 9999;
                box-shadow: 0 10px 30px rgba(232,165,184,0.4);
                transition: all 0.4s ease;
                opacity: 0;
                pointer-events: none;
                font-family: 'Montserrat', sans-serif;
                white-space: nowrap;
            `;
            document.body.appendChild(toast);
        }
        toast.textContent = mesaj;
        toast.style.opacity = '1';
        toast.style.transform = 'translateX(-50%) translateY(0)';
        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateX(-50%) translateY(100px)';
        }, 2500);
    },

    // ==========================================
    // Filtreleme
    // ==========================================
    filtrele(kategori) {
        const kartlar = document.querySelectorAll('.urun-kart');
        kartlar.forEach(kart => {
            const kat = kart.getAttribute('data-kategori');
            if (kategori === 'all' || kat === kategori) {
                kart.style.display = 'flex';
                setTimeout(() => {
                    kart.style.opacity = '1';
                    kart.style.transform = 'translateY(0) scale(1)';
                }, 50);
            } else {
                kart.style.opacity = '0';
                kart.style.transform = 'translateY(20px) scale(0.95)';
                setTimeout(() => kart.style.display = 'none', 400);
            }
        });
    },

    // ==========================================
    // Sepet Sayfası
    // ==========================================
    sepetKartOlustur(urun, adet) {
        const toplam = urun.fiyat * adet;
        return `
            <div class="sepet-item" data-id="${urun.id}">
                <img src="${urun.resim}" alt="${urun.ad}" class="sepet-resim" onerror="this.src='https://via.placeholder.com/100x80?text=Urun'">
                <div class="sepet-detay">
                    <h4>${urun.ad}</h4>
                    <p class="sepet-fiyat">Birim: ${urun.fiyat.toLocaleString('tr-TR')} ${urun.paraBirimi}</p>
                </div>
                <div class="sepet-adet-kontrol">
                    <button class="btn-adet" onclick="UrunlerApp.adetAzalt(${urun.id})">−</button>
                    <span class="adet-sayi">${adet}</span>
                    <button class="btn-adet" onclick="UrunlerApp.adetArtir(${urun.id})">+</button>
                </div>
                <span class="sepet-toplam">${toplam.toLocaleString('tr-TR')} ${urun.paraBirimi}</span>
                <button class="btn-sil" onclick="UrunlerApp.sepettenCikar(${urun.id})" title="Sepetten Çıkar">🗑</button>
            </div>
        `;
    },

    adetArtir(urunId) {
        const sepet = this.sepetiGetir();
        const item = sepet.find(i => i.id === urunId);
        if (item) {
            this.sepetAdetGuncelle(urunId, item.adet + 1);
            this.sepetSayfasiniGuncelle();
        }
    },

    adetAzalt(urunId) {
        const sepet = this.sepetiGetir();
        const item = sepet.find(i => i.id === urunId);
        if (item && item.adet > 1) {
            this.sepetAdetGuncelle(urunId, item.adet - 1);
            this.sepetSayfasiniGuncelle();
        } else {
            this.sepettenCikar(urunId);
            this.sepetSayfasiniGuncelle();
        }
    },

    sepetSayfasiniGuncelle() {
        const container = document.getElementById('sepetListesi');
        const toplamEl = document.getElementById('sepetToplam');
        const araToplamEl = document.getElementById('araToplam');
        const ozet = document.getElementById('sepetOzet');

        if (container) {
            this.sepetRender(container);
        }
        if (toplamEl) {
            toplamEl.textContent = this.sepetToplamTutar().toLocaleString('tr-TR') + ' ₺';
        }
        if (araToplamEl) {
            araToplamEl.textContent = this.sepetToplamTutar().toLocaleString('tr-TR') + ' ₺';
        }
        if (ozet) {
            const sepet = this.sepetiGetir();
            ozet.style.display = sepet.length > 0 ? 'block' : 'none';
        }
        this.badgeYukle();
    },

    sepetRender(container) {
        const sepet = this.sepetiGetir();
        if (sepet.length === 0) {
            container.innerHTML = `
                <div class="bos-durum">
                    <div style="font-size: 4rem; margin-bottom: 1rem;">🛒</div>
                    <h3>Sepetiniz Boş</h3>
                    <p>Ürünleri keşfetmek için <a href="urunler.html" style="color: #f596b1; text-decoration: none; border-bottom: 2px solid #f596b1;">buraya tıklayın</a>.</p>
                </div>
            `;
            return;
        }
        let html = '';
        sepet.forEach(item => {
            const urun = this.urunler.find(u => u.id === item.id);
            if (urun) {
                html += this.sepetKartOlustur(urun, item.adet);
            }
        });
        container.innerHTML = html;
    },

    // ==========================================
    // Favoriler Sayfası
    // ==========================================
   // ==========================================
    // Favoriler Sayfası
    // ==========================================
    favorilerRender(container) {
        const favoriIds = this.favorileriGetir();
        const favoriUrunler = this.urunler.filter(u => favoriIds.includes(u.id));

        if (favoriUrunler.length === 0) {
            container.innerHTML = `
                <div class="bos-durum">
                    <div style="font-size: 4rem; margin-bottom: 1rem;">♡</div>
                    <h3>Henüz Favori Yok</h3>
                    <p>Beğendiğiniz ürünleri favorilere eklemek için <a href="urunler.html" style="color: #f596b1; text-decoration: none; border-bottom: 2px solid #f596b1;">buraya tıklayın</a>.</p>
                </div>
            `;
            return;
        }
        
        // HATA BURADAYDI: Ekstra <div class="urunler-grid"> sarmalayıcısını kaldırdık
        let html = ''; 
        favoriUrunler.forEach(urun => {
            html += this.kartOlustur(urun);
        });
        container.innerHTML = html;

        const sayiEl = document.getElementById('favoriSayi');
        if (sayiEl) sayiEl.textContent = favoriIds.length;
        const sepetSayiEl = document.getElementById('sepetSayi');
        if (sepetSayiEl) sepetSayiEl.textContent = this.sepetToplamAdet();
    },

    // ==========================================
    // Tema
    // ==========================================
    temaYukle() {
        try {
            const savedTheme = localStorage.getItem(this.keys.tema) || 'light';
            document.documentElement.setAttribute('data-theme', savedTheme);
            const toggle = document.getElementById('themeToggle');
            if (toggle) toggle.textContent = savedTheme === 'dark' ? '☾' : '☀';
        } catch (e) {
            console.warn('Tema yüklenirken hata:', e);
        }
    },

    temaToggle() {
        try {
            const html = document.documentElement;
            const current = html.getAttribute('data-theme') || 'light';
            const yeni = current === 'dark' ? 'light' : 'dark';
            html.setAttribute('data-theme', yeni);
            localStorage.setItem(this.keys.tema, yeni);
            const toggle = document.getElementById('themeToggle');
            if (toggle) toggle.textContent = yeni === 'dark' ? '☾' : '☀';
        } catch (e) {
            console.warn('Tema değiştirilirken hata:', e);
        }
    }
};

window.UrunlerApp = UrunlerApp;