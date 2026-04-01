// Scroll animasyonları
const observerOptions = {
    threshold: 0.1,
    rootMargin: "0px 0px -50px 0px"
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('active');
        }
    });
}, observerOptions);

document.querySelectorAll('.reveal').forEach((el) => observer.observe(el));

// Navbar scroll efekti
const navbar = document.getElementById('navbar');
window.addEventListener('scroll', () => {
    if (window.scrollY > 50) {
        navbar.classList.add('scrolled');
    } else {
        navbar.classList.remove('scrolled');
    }
});

// Organik blob hareketi mouse ile
document.addEventListener('mousemove', (e) => {
    const blobs = document.querySelectorAll('.blob');
    const x = e.clientX / window.innerWidth;
    const y = e.clientY / window.innerHeight;
    
    blobs.forEach((blob, index) => {
        const speed = (index + 1) * 15;
        blob.style.transform = `translate(${x * speed}px, ${y * speed}px)`;
    });
});

// Parallax efekti çiçekler için
document.addEventListener('mousemove', (e) => {
    const flowers = document.querySelectorAll('.flower-decor');
    const x = (e.clientX / window.innerWidth - 0.5) * 20;
    const y = (e.clientY / window.innerHeight - 0.5) * 20;
    
    flowers.forEach((flower, index) => {
        const speed = (index + 1) * 0.5;
        flower.style.transform = `translate(${x * speed}px, ${y * speed}px)`;
    });
});

// Smooth scroll navigasyon linkleri için
document.querySelectorAll('.nav-links a').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        e.preventDefault();
        const targetId = this.getAttribute('href');
        const targetSection = document.querySelector(targetId);
        if (targetSection) {
            targetSection.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Hero CTA butonu smooth scroll
document.querySelector('.hero-cta').addEventListener('click', function(e) {
    e.preventDefault();
    const targetSection = document.querySelector('#work');
    if (targetSection) {
        targetSection.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    }
});

// Form gönderim animasyonu
document.querySelector('.contact-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const submitBtn = this.querySelector('.submit-btn');
    const originalText = submitBtn.textContent;
    
    // Buton animasyonu
    submitBtn.textContent = 'Gönderiliyor...';
    submitBtn.style.opacity = '0.8';
    
    setTimeout(() => {
        alert('Mesajınız alındı! En kısa sürede dönüş yapacağım.');
        submitBtn.textContent = originalText;
        submitBtn.style.opacity = '1';
        this.reset();
    }, 1000);
});

// Proje kartları tıklama efekti
document.querySelectorAll('.project-card').forEach(card => {
    card.addEventListener('click', function() {
        const title = this.querySelector('.project-title').textContent;
        console.log(`${title} projesine tıklandı`);
        // Burada proje detay sayfasına yönlendirme yapılabilir
    });
});

// Skill bar animasyonu - bölüme girildiğinde
document.querySelectorAll('.skill-bar-fill').forEach(bar => {
    const barObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.animation = 'none';
                entry.target.offsetHeight; // Trigger reflow
                entry.target.style.animation = 'fill-bar 2s ease-out forwards';
            }
        });
    }, { threshold: 0.5 });
    
    barObserver.observe(bar);
});

// Floating tag'ler için rastgele hareket
function animateFloatingTags() {
    const tags = document.querySelectorAll('.floating-tag');
    
    tags.forEach((tag, index) => {
        setInterval(() => {
            const randomX = (Math.random() - 0.5) * 10;
            const randomY = (Math.random() - 0.5) * 10;
            tag.style.transform = `translate(${randomX}px, ${randomY}px)`;
        }, 3000 + index * 500);
    });
}

// Sayfa yüklendiğinde animasyonları başlat
document.addEventListener('DOMContentLoaded', () => {
    animateFloatingTags();
    
    // Logo hover efekti
    const logo = document.querySelector('.logo');
    logo.addEventListener('mouseenter', () => {
        logo.style.letterSpacing = '4px';
    });
    logo.addEventListener('mouseleave', () => {
        logo.style.letterSpacing = '2px';
    });
});

// Sparkle efektleri için rastgele pozisyon
document.querySelectorAll('.sparkle').forEach((sparkle, index) => {
    sparkle.style.left = `${15 + index * 15 + Math.random() * 10}%`;
    sparkle.style.top = `${20 + Math.random() * 60}%`;
});

// Yetenek kartları hover efekti
document.querySelectorAll('.skill-category').forEach(category => {
    category.addEventListener('mouseenter', function() {
        this.style.transform = 'translateY(-10px) scale(1.02)';
    });
    
    category.addEventListener('mouseleave', function() {
        this.style.transform = 'translateY(0) scale(1)';
    });
});

// Değer kartları için pulse animasyonu
document.querySelectorAll('.value-item').forEach((item, index) => {
    item.addEventListener('mouseenter', function() {
        const icon = this.querySelector('.value-icon');
        icon.style.animation = 'pulse 0.5s infinite';
    });
    
    item.addEventListener('mouseleave', function() {
        const icon = this.querySelector('.value-icon');
        icon.style.animation = 'pulse 2s infinite';
    });
});

// Sosyal linkler için tooltip
document.querySelectorAll('.social-link').forEach(link => {
    const title = link.getAttribute('title');
    
    link.addEventListener('mouseenter', function(e) {
        const tooltip = document.createElement('div');
        tooltip.className = 'social-tooltip';
        tooltip.textContent = title;
        tooltip.style.cssText = `
            position: absolute;
            bottom: -35px;
            left: 50%;
            transform: translateX(-50%);
            background: var(--charcoal);
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 0.7rem;
            white-space: nowrap;
            opacity: 0;
            transition: opacity 0.3s ease;
            pointer-events: none;
        `;
        this.style.position = 'relative';
        this.appendChild(tooltip);
        
        setTimeout(() => tooltip.style.opacity = '1', 10);
    });
    
    link.addEventListener('mouseleave', function() {
        const tooltip = this.querySelector('.social-tooltip');
        if (tooltip) {
            tooltip.style.opacity = '0';
            setTimeout(() => tooltip.remove(), 300);
        }
    });
});

// Mobil menü toggle (isteğe bağlı)
function createMobileMenu() {
    const nav = document.getElementById('navbar');
    const menuToggle = document.createElement('button');
    menuToggle.className = 'mobile-menu-toggle';
    menuToggle.innerHTML = '☰';
    menuToggle.style.cssText = `
        display: none;
        background: none;
        border: none;
        font-size: 1.5rem;
        cursor: pointer;
        color: var(--charcoal);
    `;
    
    nav.appendChild(menuToggle);
    
    // Mobil görünümde menü toggle'ı göster
    const mediaQuery = window.matchMedia('(max-width: 968px)');
    
    function handleMediaChange(e) {
        if (e.matches) {
            menuToggle.style.display = 'block';
        } else {
            menuToggle.style.display = 'none';
        }
    }
    
    mediaQuery.addListener(handleMediaChange);
    handleMediaChange(mediaQuery);
    
    // Menü toggle fonksiyonu
    menuToggle.addEventListener('click', () => {
        const navLinks = document.querySelector('.nav-links');
        navLinks.style.display = navLinks.style.display === 'flex' ? 'none' : 'flex';
    });
}

// Mobil menüyü oluştur
createMobileMenu();

// Sayfa performansı için throttle fonksiyonu
function throttle(func, limit) {
    let inThrottle;
    return function(...args) {
        if (!inThrottle) {
            func.apply(this, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    };
}

// Scroll event'ini throttle ile optimize et
window.addEventListener('scroll', throttle(() => {
    // Scroll ile ilgili işlemler burada
}, 16)); // ~60fps

// Intersection Observer için performans optimizasyonu
const revealElements = document.querySelectorAll('.reveal');
const revealObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('active');
            revealObserver.unobserve(entry.target); // Bir kez çalışsın
        }
    });
}, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });

revealElements.forEach(el => revealObserver.observe(el));

console.log('✨ Portföy sitesi başarıyla yüklendi!');
