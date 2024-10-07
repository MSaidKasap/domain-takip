# Domain Süresi Takip Sistemi

Bu proje, domainlerin süresini takip eden ve son 10 güne yaklaştığında otomatik olarak SMS ve e-posta yoluyla bildirim gönderen bir sistemdir. Sistem, domain süresi dolmadan kullanıcıya uyarı göndererek, yenileme işlemlerinin zamanında yapılmasını sağlar.

## Özellikler

- Domain süresini takip etme
- Süresi 10 günden az kalan domainler için otomatik SMS ve e-posta gönderimi
- Esnek uyarı sistemi ile zamana bağlı bildirimler

## Kullanım

1. Domainlerinizi sisteme ekleyin.
2. Sistem, domainlerin süresini otomatik olarak takip eder.
3. Süresi 10 günden az kalan domainler için uyarı SMS ve e-posta gönderilir.
4. İlgili kişilere bildirimler anında iletilir.

## Gereksinimler

- PHP 7.x veya üzeri
- MySQL Veritabanı
- SMS API ve e-posta sunucusu (örn. Twilio veya benzeri bir servis)

## Kurulum

1. Bu projeyi klonlayın:

   ```bash
   git clone https://github.com/MSaidKasap/domain-takip.git
Veritabanı bağlantı ayarlarını güncelleyin:

config.php dosyasındaki veritabanı ve API bilgilerini doldurun.

Cron job ayarlayın:

Domainlerin süresini düzenli aralıklarla kontrol etmek için cron job ayarlayın.
* * * * * /usr/bin/php /functions/auto_sms_mail.php
Sistem çalışmaya başlayacak ve domain süresi dolmak üzere olan domainler için bildirimler gönderecektir.
Katkıda Bulunma
Herhangi bir katkı yapmak isterseniz, lütfen pull request gönderin veya bir issue açın.

## Lisans

Bu proje MIT lisansı altında lisanslanmıştır. Daha fazla bilgi için [LICENSE](./LICENSE) dosyasına göz atabilirsiniz.

