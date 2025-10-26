# Changelog

تمام تغییرات مهم این پروژه در این فایل مستند می‌شود.

فرمت بر اساس [Keep a Changelog](https://keepachangelog.com/fa/1.0.0/) است
و این پروژه از [Semantic Versioning](https://semver.org/lang/fa/) پیروی می‌کند.

---

## [1.0.0] - 2025-10-26

### 🎉 نسخه اولیه

این اولین نسخه رسمی افزونه WPVision Addons است.

### ✨ Added (اضافه شده)

#### ویجت‌ها
- **نقشه ایران تعاملی**
  - نقشه SVG تعاملی با 31 استان
  - سفارشی‌سازی کامل رنگ‌ها (پیش‌فرض، هاور، حاشیه)
  - تولتیپ اطلاعاتی با امکان نمایش نام و شماره تماس
  - جابجایی دلخواه نام استان‌ها با کنترل X و Y
  - Responsive و Mobile-friendly
  - سفارشی‌سازی تایپوگرافی نام استان‌ها و تولتیپ

- **جدول المنتور**
  - جدول با ستون‌های نامحدود
  - ردیف‌های نامحدود با پشتیبانی از جداکننده `|`
  - رنگ‌بندی خودکار ردیف‌های فرد و زوج
  - Hover Effect روی ردیف‌ها
  - سفارشی‌سازی کامل هدر و محتوا (رنگ، فونت، فاصله‌ها)
  - Box Shadow و Border Radius
  - کاملاً Responsive

- **اسلایدر تصویر**
  - اسلایدر با انیمیشن چرخشی 3D
  - نمایش اسلایدهای قبل و بعد
  - 3 نوع انیمیشن: Slide, Fade, Rotate
  - Autoplay با سرعت قابل تنظیم
  - Navigation Arrows (اختیاری)
  - Pagination Dots (اختیاری)
  - تنظیم فاصله و اندازه اسلایدهای کناری
  - سفارشی‌سازی محتوا (عنوان، زیرعنوان، توضیحات، دکمه)
  - سفارشی‌سازی کامل استایل (رنگ‌ها، فونت‌ها، Overlay)

#### پنل مدیریت
- صفحه تنظیمات زیبا با Material Design
- فعال/غیرفعال کردن ویجت‌ها به صورت جداگانه
- Toggle های انیمیشن‌دار
- کارت‌های توضیحات برای هر ویجت
- بخش راهنمای کاربر

#### سیستم بروزرسانی
- **GitHub Auto-Update** با Plugin Update Checker
- پنل تنظیمات GitHub در بخش مدیریت
- پشتیبانی از Public و Private Repositories
- نمایش وضعیت فعال/غیرفعال
- پشتیبانی از GitHub Releases
- امکان تنظیم Branch دلخواه

#### امنیت
- فایل‌های `index.php` در تمام پوشه‌ها
- بررسی `ABSPATH` در تمام فایل‌ها
- Sanitize و Escape تمام ورودی‌ها
- نامگذاری منحصر به فرد کلاس‌ها

### 🔧 Technical (فنی)

- **Version**: 1.0.0
- **Requires WordPress**: 5.0+
- **Requires PHP**: 7.4+
- **Tested up to WordPress**: 6.4
- **Tested with Elementor**: 3.20.0
- **Text Domain**: wpvision
- **Domain Path**: /languages

### 📁 ساختار فایل‌ها

```
wpvision-addons/
├── wpvision.php (6.7 KB)
├── readme.txt
├── README.md
├── CHANGELOG.md
├── assets/ (162 KB total)
│   ├── css/ (16 KB)
│   ├── js/ (15 KB)
│   └── svg/ (144 KB)
├── widgets/ (61 KB total)
│   ├── iran-map-widget.php (17 KB)
│   ├── vasil-table-widget.php (16 KB)
│   └── slider-widget.php (27 KB)
└── includes/
    ├── admin-settings.php (12 KB)
    └── plugin-update-checker/ (کتابخانه)
```

### 🎨 Assets

#### CSS (16 KB)
- `admin-style.css` - استایل پنل مدیریت
- `iranmap.css` - استایل نقشه ایران
- `slider.css` - استایل اسلایدر
- `vasil-table.css` - استایل جدول

#### JavaScript (15 KB)
- `iranmap.js` - منطق نقشه تعاملی
- `slider.js` - منطق اسلایدر با انیمیشن

#### SVG (144 KB)
- `iran-map.svg` - نقشه کامل ایران با 31 استان

### 📝 مستندات

- راهنمای نصب و استفاده
- راهنمای راه‌اندازی GitHub Auto-Update
- مستندات ویجت‌ها
- مثال‌های استفاده

### ⚙️ سازگاری

- ✅ WordPress 5.0 تا 6.4
- ✅ PHP 7.4 تا 8.2
- ✅ Elementor 3.0+
- ✅ تمام تم‌های وردپرس
- ✅ RTL Support
- ✅ Multisite Compatible

---

## [Unreleased]

### پلن آینده

#### در نظر گرفته شده برای v1.1.0
- [ ] افزودن ویجت آکاردئون پیشرفته
- [ ] افزودن ویجت Timeline
- [ ] بهبود عملکرد اسلایدر
- [ ] افزودن Lazy Loading برای تصاویر
- [ ] پشتیبانی از چندزبانه (WPML و Polylang)

#### پیشنهادات کاربران
- [ ] افزودن نقشه شهرها
- [ ] پشتیبانی از Google Maps API
- [ ] افزودن قالب‌های آماده برای ویجت‌ها
- [ ] Export/Import تنظیمات

---

## نحوه استفاده از این فایل

### برای توسعه‌دهندگان

هنگام ایجاد هر نسخه جدید:

1. **تاریخ و نسخه را اضافه کنید**
   ```markdown
   ## [1.1.0] - 2025-11-15
   ```

2. **تغییرات را دسته‌بندی کنید**:
   - `Added` - ویژگی‌های جدید
   - `Changed` - تغییرات در ویژگی‌های موجود
   - `Deprecated` - ویژگی‌هایی که به زودی حذف می‌شوند
   - `Removed` - ویژگی‌های حذف شده
   - `Fixed` - رفع باگ‌ها
   - `Security` - در صورت وجود آسیب‌پذیری امنیتی

3. **توضیحات واضح بنویسید**

4. **لینک مقایسه اضافه کنید** (در انتها)

### مثال برای نسخه آینده

```markdown
## [1.1.0] - 2025-11-15

### Added
- ویجت Timeline با 3 لایوت مختلف
- پشتیبانی از WPML

### Changed
- بهبود عملکرد اسلایدر (30% سریع‌تر)
- به‌روزرسانی کتابخانه Plugin Update Checker

### Fixed
- رفع مشکل نمایش نقشه در Safari
- رفع باگ Responsive جدول در موبایل

### Security
- بهبود امنیت فرم‌ها با افزودن Nonce
```

---

## لینک‌های مقایسه

این بخش به صورت خودکار توسط GitHub پر می‌شود.

[Unreleased]: https://github.com/YOUR-USERNAME/wpvision-addons/compare/v1.0.0...HEAD
[1.0.0]: https://github.com/YOUR-USERNAME/wpvision-addons/releases/tag/v1.0.0
