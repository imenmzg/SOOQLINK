---
layout: default
title: SOOQLINK Documentation
---

# SOOQLINK - B2B Marketplace Platform

Welcome to SOOQLINK documentation!

## About

SOOQLINK is a modern B2B marketplace connecting businesses with verified suppliers in Algeria.

## Features

- 🏢 Multi-Panel System (Admin, Supplier, Client)
- ✅ Supplier Verification Workflow
- 📦 Product Management
- 📝 RFQ (Request for Quotation) System
- 💬 Real-time Messaging
- ⭐ Review & Rating System

## Quick Start

```bash
# Clone the repository
git clone https://github.com/imenmzg/SOOQLINK.git
cd SOOQLINK

# Install dependencies
composer install

# Setup environment
cp .env.example .env
php artisan key:generate

# Run migrations
php artisan migrate --seed

# Start server
php artisan serve
```

## Access Points

- **Admin Panel**: `/admin` - admin@sooqlink.com / password
- **Supplier Panel**: `/supplier`
- **Client Panel**: `/client`
- **Public Site**: `/`

## Tech Stack

- Laravel 11
- Filament 3
- PHP 8.2+
- Tailwind CSS
- Spatie Packages

## Documentation

- [Installation Guide](./installation.html)
- [User Guide](./user-guide.html)
- [API Documentation](./api.html)

## Support

For issues and questions, please open an issue on [GitHub](https://github.com/imenmzg/SOOQLINK/issues).

---

© 2025 SOOQLINK. All rights reserved.

