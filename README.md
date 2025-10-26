# WPVision Addons - مجموعه ویجت های حرفه ای Elementor

[![WordPress](https://img.shields.io/badge/WordPress-5.0%2B-blue)](https://wordpress.org/)
[![PHP](https://img.shields.io/badge/PHP-7.4%2B-purple)](https://php.net/)
[![Elementor](https://img.shields.io/badge/Elementor-3.0%2B-pink)](https://elementor.com/)
[![License](https://img.shields.io/badge/License-GPLv2-green)](LICENSE)
[![Version](https://img.shields.io/badge/Version-1.0.0-orange)](../../releases)

مجموعه ای از ویجت های حرفه ای و کاربردی برای Elementor شامل نقشه ایران تعاملی، جدول المنتور و اسلایدر تصویر.

![WPVision Addons Banner](https://via.placeholder.com/1200x300/FF6B35/FFFFFF?text=WPVision+Addons)

---

## 🎯 ویژگی‌های اصلی

### 🗺️ نقشه ایران تعاملی
- نقشه SVG با کیفیت بالا و تعاملی
- سفارشی‌سازی کامل رنگ‌ها و استایل‌ها
- تولتیپ اطلاعاتی برای هر استان
- لینک مستقیم به صفحات استان‌ها
- کاملاً Responsive و Mobile-friendly
- جابجایی دلخواه نام استان‌ها روی نقشه

### 📊 جدول المنتور
- طراحی مدرن و حرفه‌ای
- ستون‌های نامحدود
- Responsive Table با قابلیت Scroll
- استایل‌دهی کامل (رنگ‌ها، فونت‌ها، فاصله‌ها)
- Hover Effects زیبا
- ردیف‌های فرد و زوج با رنگ‌بندی متفاوت

### 🎬 اسلایدر تصویر
- انیمیشن‌های چرخشی و نرم
- نمایش اسلایدهای قبل و بعد
- Autoplay با سرعت قابل تنظیم
- Navigation Arrows و Pagination Dots
- سفارشی‌سازی کامل محتوا و دکمه‌ها
- چندین نوع انیمیشن (Slide, Fade, Rotate)

---

## 📦 نصب

### روش 1: نصب از طریق فایل ZIP

1. فایل `wpvision-addons-v1.0.0-with-autoupdate.zip` را دانلود کنید
2. وارد پنل مدیریت وردپرس شوید
3. به **افزونه‌ها > افزودن > بارگذاری افزونه** بروید
4. فایل ZIP را آپلود و نصب کنید
5. افزونه را فعال کنید

### روش 2: نصب دستی

1. فایل ZIP را Extract کنید
2. پوشه `wpvision-addons` را به `wp-content/plugins/` آپلود کنید
3. از پنل مدیریت افزونه را فعال کنید

---

## ⚙️ تنظیمات

### فعال/غیرفعال کردن ویجت‌ها

1. از منوی کناری به **WPVision Addons** بروید
2. ویجت‌های مورد نظر را فعال/غیرفعال کنید
3. روی **ذخیره تنظیمات** کلیک کنید

### تنظیم بروزرسانی خودکار

برای فعال‌سازی بروزرسانی خودکار از GitHub:

1. در صفحه تنظیمات، به بخش **تنظیمات بروزرسانی خودکار GitHub** بروید
2. آدرس Repository خود را وارد کنید:
   ```
   https://github.com/YOUR-USERNAME/wpvision-addons/
   ```
3. نام Branch را مشخص کنید (پیش‌فرض: `main`)
4. در صورت Private بودن Repository، Access Token وارد کنید
5. تنظیمات را ذخیره کنید

📖 **راهنمای کامل**: [GITHUB-AUTO-UPDATE-GUIDE.md](GITHUB-AUTO-UPDATE-GUIDE.md)

---

## 🚀 استفاده

### در Elementor

1. وارد صفحه مورد نظر شوید
2. روی **ویرایش با Elementor** کلیک کنید
3. از پنل سمت چپ، ویجت‌های WPVision را پیدا کنید:
   - **نقشه ایران**
   - **جدول المنتور**
   - **اسلایدر تصویر**
4. ویجت را drag & drop کنید
5. از پنل تنظیمات، محتوا و استایل را سفارشی کنید

---

## 📋 پیش‌نیازها

- WordPress 5.0 یا بالاتر
- PHP 7.4 یا بالاتر
- Elementor (نسخه رایگان کافی است)
- حافظه PHP: حداقل 64MB

---

## 📁 ساختار فایل‌ها

```
wpvision-addons/
│
├── wpvision.php              # فایل اصلی افزونه
├── readme.txt                # مستندات استاندارد وردپرس
├── README.md                 # این فایل
│
├── assets/                   # منابع استاتیک
│   ├── css/                  # فایل‌های استایل
│   ├── js/                   # فایل‌های جاوااسکریپت
│   └── svg/                  # فایل‌های SVG
│
├── widgets/                  # ویجت‌های Elementor
│   ├── iran-map-widget.php
│   ├── vasil-table-widget.php
│   └── slider-widget.php
│
└── includes/                 # فایل‌های کمکی
    ├── admin-settings.php
    └── plugin-update-checker/ # کتابخانه بروزرسانی
```

---

## 🔄 بروزرسانی

### بروزرسانی خودکار (پس از تنظیم GitHub)

کاربران به صورت خودکار در پنل **بروزرسانی‌ها** اعلان دریافت می‌کنند و می‌توانند با یک کلیک بروزرسانی کنند.

### بروزرسانی دستی

1. نسخه جدید را از [Releases](../../releases) دانلود کنید
2. افزونه قبلی را غیرفعال و حذف کنید
3. نسخه جدید را نصب و فعال کنید

---

## 🐛 گزارش باگ

اگر باگی پیدا کردید، لطفاً:

1. از بخش [Issues](../../issues) یک Issue جدید بسازید
2. عنوان واضح انتخاب کنید
3. توضیحات کامل با مراحل تکرار باگ بنویسید
4. اطلاعات محیط را ذکر کنید:
   - نسخه وردپرس
   - نسخه PHP
   - نسخه Elementor
   - نسخه افزونه

---

## 💡 درخواست ویژگی

ایده‌ای برای بهبود افزونه دارید؟

1. از بخش [Issues](../../issues) یک Feature Request بسازید
2. ویژگی مورد نظر را به طور کامل شرح دهید
3. در صورت امکان، مثال یا تصویری ارائه دهید

---

## 📝 تغییرات

برای مشاهده لیست کامل تغییرات هر نسخه، به [CHANGELOG.md](CHANGELOG.md) مراجعه کنید.

---

## 🤝 مشارکت

مشارکت شما استقبال می‌شود! برای مشارکت:

1. این Repository را Fork کنید
2. یک Branch جدید بسازید: `git checkout -b feature/amazing-feature`
3. تغییرات خود را Commit کنید: `git commit -m 'Add amazing feature'`
4. به Branch خود Push کنید: `git push origin feature/amazing-feature`
5. یک Pull Request بسازید

---

## 📄 لایسنس

این افزونه تحت لایسنس **GPLv2 or later** منتشر شده است.

مشاهده فایل کامل لایسنس: [LICENSE](LICENSE)

---

## 👥 نویسندگان

- **WPVision Team** - توسعه اولیه

---

## 🙏 تشکر

از تمامی کسانی که در توسعه این افزونه مشارکت داشته‌اند، تشکر می‌کنیم!

---

## 📞 پشتیبانی

- 🌐 وبسایت: [wpvision.com](https://wpvision.com)
- 📧 ایمیل: support@wpvision.com
- 💬 GitHub Issues: [اینجا](../../issues)

---

## 🌟 حمایت از ما

اگر این افزونه برای شما مفید بود:

- ⭐ یک Star به Repository بدهید
- 🐦 در شبکه‌های اجتماعی به اشتراک بگذارید
- 💬 نظرات خود را با ما در میان بگذارید

---

**ساخته شده با ❤️ توسط WPVision Team**

![Made with Love](https://img.shields.io/badge/Made%20with-%E2%9D%A4-red)
![Iran](https://img.shields.io/badge/Made%20in-Iran-green)
