# Vildan Babaer — Kişisel Portfolyo Projesi

Bu proje, web geliştirme teknolojileri kullanılarak oluşturulmuş, kullanıcı etkileşimli ve dinamik bir kişisel portfolyo sitesidir. Proje kapsamında veritabanı yönetimi, dinamik veri çekme (JSON) ve kullanıcı deneyimini iyileştiren modern arayüz tasarımı üzerine çalışmalar yapılmıştır.

## 🚀 Proje Hakkında
Bu site, projelerimi sergilemek, gelen mesajları yönetmek ve ziyaretçilerle etkileşim kurmak amacıyla geliştirilmiştir. Modern tasarımı, kullanıcı dostu arayüzü ve arkadaki güçlü PHP/MySQL yapısıyla dinamik bir deneyim sunar.

## 🛠 Kullanılan Teknolojiler
- **Backend:** PHP, MySQL (PDO)
- **Frontend:** HTML5, CSS3 (Modern Flexbox/Grid yapısı), JavaScript (Vanilla JS)
- **Veri Yönetimi:** JSON (Proje listeleri için), MySQL (Kullanıcı kayıt/giriş için)

## 📋 Özellikler
- **Kullanıcı Sistemi:** Güvenli şifreleme (`password_hash`) ile kullanıcı kayıt ve giriş işlemleri.
- **Dinamik İçerik:** Projeler, JSON dosyasından çekilerek kart yapısında listelenir.
- **UX Özellikleri:** Kategori tabanlı filtreleme, sayfa içi animasyonlar ve modern bir kullanıcı arayüzü.
- **Mesaj Yönetimi:** `localStorage` kullanılarak kullanıcı mesajlarının anlık görüntülenmesi ve yönetilmesi.
- **Responsive Tasarım:** Mobil cihazlarla %100 uyumlu modern görünüm.

## 📂 Proje Yapısı
- `baglanti.php`: Veritabanı bağlantı yönetimi.
- `index.php`: Ana sayfa ve genel arayüz.
- `giris_kayit.php`: Kullanıcı kimlik doğrulama işlemleri.
- `projeler.php`: Projelerin dinamik olarak listelendiği sayfa.
- `js/urunler.js`: Proje filtreleme ve veri çekme mantığı.

## ⚙️ Kurulum
1. Bu projeyi bilgisayarınıza indirin veya klonlayın.
2. `XAMPP` veya benzeri bir yerel sunucu ortamını başlatın.
3. `portfolyo` adında bir veritabanı oluşturun ve ilgili tabloları içe aktarın.
4. `baglanti.php` dosyasındaki veritabanı bilgilerinizi (kullanıcı adı/şifre) kendi sisteminize göre güncelleyin.
5. Projeyi tarayıcınızda çalıştırın.

---
*Geliştirici: Mümüne Vildan Babaer*
