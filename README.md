<div align="center">

# 🚀 SOOQLINK

**B2B Marketplace Platform for Algeria**

[![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?style=flat-square&logo=laravel)](https://laravel.com)
[![Filament](https://img.shields.io/badge/Filament-3.x-F59E0B?style=flat-square)](https://filamentphp.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat-square&logo=php)](https://php.net)
[![License](https://img.shields.io/badge/License-MIT-green.svg?style=flat-square)](LICENSE)

منصة احترافية لربط الشركات بالموردين الموثوقين في الجزائر

</div>

---

## 📋 About

SOOQLINK is a modern B2B marketplace connecting businesses with verified suppliers in Algeria. Features include supplier verification, product management, RFQ system, messaging, and reviews.

## ✨ Key Features

- 🏢 **Multi-Panel System** - Separate dashboards for Admin, Suppliers, and Clients
- ✅ **Supplier Verification** - Document upload and approval workflow
- 📦 **Product Management** - Full CRUD with images and categories
- 📝 **RFQ System** - Request and manage quotations
- 💬 **Messaging** - Direct chat between clients and suppliers
- ⭐ **Reviews & Ratings** - Build trust with verified reviews
- 🔍 **Advanced Search** - Filter by category, location, price

## 🛠️ Tech Stack

- **Backend**: Laravel 11, PHP 8.2+
- **Admin Panel**: Filament 3
- **Database**: SQLite/MySQL
- **Auth**: Laravel Sanctum, Spatie Permissions
- **Media**: Spatie Media Library
- **Frontend**: Tailwind CSS, Alpine.js, Livewire

## 🚀 Installation

```bash
# Install dependencies
composer install

# Setup environment
cp .env.example .env
php artisan key:generate

# Run migrations and seeders
php artisan migrate --seed

# Create storage link
php artisan storage:link

# Start server
php artisan serve
```

Visit: `http://localhost:8000`

## 🔑 Default Access

- **Admin**: `/admin` - admin@sooqlink.com / password
- **Supplier**: `/supplier` - Register via `/supplier/register`
- **Client**: `/client` - Register via `/client/register`

## 🎨 Brand Colors

- Primary Blue: `#32A7E2`
- Secondary Green: `#6FC242`

## 📚 Documentation

- [QUICK_START.md](./QUICK_START.md) - Detailed setup guide
- [DEPLOYMENT.md](./DEPLOYMENT.md) - Production deployment
- [FEATURE_CHECKLIST.md](./FEATURE_CHECKLIST.md) - Feature status

## 📄 License

MIT License - see [LICENSE](LICENSE) file for details.

## 📞 Support

- 📧 Email: info@sooqlink.com
- 🐛 Issues: [GitHub Issues](https://github.com/yourusername/sooqlink/issues)

---

<div align="center">

**Made with ❤️ for the Algerian Business Community**

</div>
