🎓 Üniversite Online Ödeme Sistemi - Teknik Dokümantasyon
Bu depo, README'de belirtilen ozelliklere sahip Laravel tabanli online odeme sisteminin iskelet kodlarini icerir.
🧩 Teknoloji Yığını
Backend Framework: Laravel 10.x

Frontend Template Engine: Blade

Veritabanı: MySQL 8+

Authentication: Laravel Breeze / Jetstream

Ödeme Entegrasyonu: Iyzico / Stripe / PayTR (test modunda başlanabilir)

Frontend Kütüphaneler: Bootstrap 5, FontAwesome, Alpine.js

Admin Panel: Custom Blade
Tüm arayüzler Bootstrap CDN üzerinden modern bir görünümle sunulur. Yönetim paneline `/admin` adresinden erişebilirsiniz.

🎯 Amaç
Öğrencilerin dönemlik harç, sınav, yurt, yemek veya diğer hizmet ücretlerini online olarak görüntüleyip ödemelerini sağlayan bir sistem oluşturmak.

📂 Modüller
1. 🔐 Kimlik Doğrulama Sistemi
Öğrenci ve yönetici için oturum açma / kayıt olma

Öğrenci e-posta doğrulama

Şifre sıfırlama

2FA opsiyonel

2. 👤 Kullanıcı Rolleri
Admin: Tüm kontrol ve raporlama

Birim Yetkilisi: Kendi departman ödemelerini yönetir

Öğrenci: Kendi borç ve ödeme geçmişini görür

3. 💳 Ödeme İşlemleri
Genel Özellikler:
Laravel Cashier veya manuel ödeme gateway API kullanımı

Borç seçme → ödeme → sonuç ekranı (3D Secure destekli)

Başarılı ödeme sonrası makbuz oluşturulması (PDF)

Taksit desteği (opsiyonel)

Ödeme Tipleri:
Dönemlik Harç Ücreti

Yurt / Konaklama Ücreti

Sınav Ücreti

Öğrenci Belgesi / Transkript Ücretleri

4. 📜 Fatura & Makbuz Yönetimi
PDF olarak indirilebilen resmi ödeme makbuzu

Fatura numarası, ödeme ID, tarih bilgileri

Laravel SnappyPDF veya DomPDF kullanılabilir

5. 🧾 Borç Tanımlama ve Takip
Admin panelinden dönemsel borç tanımı

Belirli öğrenciye / gruba borç ekleme

Son ödeme tarihi, gecikme faizi (opsiyonel)

Otomatik borçlandırma (dönem başında tetiklenebilir)

6. 📈 Raporlama Paneli (Yönetici)
Günlük / aylık / yıllık gelir raporu

Borçlu öğrenciler listesi

Ödeme başarı / başarısızlık istatistikleri

Excel / CSV dışa aktarma desteği

7. 📬 Bildirim Sistemi
Ödeme başarı e-postası (öğrenciye)

Borç hatırlatma bildirimi (e-posta / SMS)

Yöneticiye yüksek tutarlı ödeme bildirimi

8. 📱 Mobil Uyumlu Arayüz (Responsive)
Blade + Bootstrap ile tüm ekran boyutlarına uyumlu

Mobil ödeme kolaylığı

🔧 Veritabanı Tasarımı (Özet)
sql
Kopyala
Düzenle
users
- id
- name
- email
- role (admin, staff, student)
- password

students
- id
- user_id (FK)
- student_number
- department
- class
- phone

debts
- id
- student_id (FK)
- type (harç, sınav vs)
- amount
- due_date
- is_paid
- created_at

payments
- id
- student_id (FK)
- debt_id (FK)
- amount_paid
- transaction_id
- payment_gateway (iyzico, stripe)
- status (success, failed)
- paid_at

invoices
- id
- payment_id (FK)
- invoice_no
- pdf_path
⚙️ Ek Özellikler (Opsiyonel)
LDAP ile üniversite öğrenci bilgi sistemi entegrasyonu

Kampüs içi kiosk terminal desteği

QR kodla ödeme (mobil banka entegrasyonu)

Webhook ile anlık ödeme geri dönüşü (Iyzico/Stripe)

📌 Güvenlik & Yedekleme
CSRF & XSS koruması (Laravel default)

Günlük yedekleme (DB & Storage)

3D Secure ödeme zorunluluğu

Yönetici paneline IP kısıtlaması (opsiyonel)

🚀 Geliştirme Aşamaları
Kimlik Doğrulama Sistemi

Öğrenci ve Yönetici Rolleri

Borç Tanımlama Paneli

Ödeme Gateway Entegrasyonu

Makbuz & Fatura Sistemi

Raporlama & Loglama

Bildirimler

Test & Deployment

🧪 Test Senaryoları
Başarılı ödeme -> borç kapatma -> makbuz oluşturulması

Geçersiz kart -> hata mesajı

Geç kalan ödeme -> uyarı sistemi

Admin borç silme işlemi -> loglanması

## Kurulum
1. Depoyu klonlayin ve `composer install` komutunu calistirin.
2. `.env` dosyasini olusturmak icin `.env.example` kopyalayin.
3. `php artisan key:generate` komutunu calistirin.
4. Veritabani bilgilerini .env dosyasina girin ve `php artisan migrate` komutu ile tablolari olusturun.
5. Gelistirme sunucusunu baslatmak icin `php artisan serve` komutunu kullanin.

Bu proje ornek ve iskelet niteligindedir. Tum ozelliklerin gercek ortam icin gelistirilmesi gerekmektedir.
Production icin `.env` dosyanizda `APP_ENV=production` ve `APP_DEBUG=false` degerlerini kullanin. `storage` klasorunun yazilabilir oldugundan emin olun ve `php artisan storage:link` komutunu calistirin.

Odeme altyapisi icin `PAYMENT_GATEWAY` degiskenini `stripe` ya da `dummy` olarak ayarlayin. Stripe kullanacaksaniz `STRIPE_SECRET` ve `STRIPE_KEY` degerlerini tanimlayin. Faturalar DomPDF ile `storage/invoices` klasorune PDF olarak olusur.

Active Directory baglantisi icin `.env` dosyaniza `AD_HOST`, `AD_BASE_DN`, `AD_USERNAME` ve `AD_PASSWORD` degiskenlerini ekleyin. Sistem, kullanici bilgilerini otomatik olarak Active Directory'den cekebilir.

Logo muhasebe entegrasyonu icin `LOGO_API_URL`, `LOGO_CLIENT_ID` ve `LOGO_CLIENT_SECRET` ayarlarinin doldurulmasi gerekir. Basarili odemeler sonrasinda olusan makbuz bilgileri bu API'ye otomatik gonderilir.

