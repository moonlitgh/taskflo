<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

# TaskFlo - Deployment Guide

## Prerequisites
- PHP >= 8.1
- MySQL >= 5.7
- Composer
- Node.js & NPM (for asset compilation)

## Deployment Steps

1. **Upload Files**
   - Upload semua file ke server hosting
   - Pastikan struktur direktori tetap sama

2. **Setup Environment**
   - Rename `.env.example` to `.env`
   - Update `.env` file with your production settings:
     ```
     APP_NAME=TaskFlo
     APP_ENV=production
     APP_DEBUG=false
     APP_URL=https://taskflo.sokasix.online/
     
     DB_CONNECTION=mysql
     DB_HOST=localhost
     DB_PORT=3306
     DB_DATABASE=u413837067_taskflo
     DB_USERNAME=u413837067_vania
     DB_PASSWORD=your_password
     ```

3. **Run Deployment Script**
   - Access `deploy.php` through your browser:
     ```
     https://taskflo.sokasix.online/deploy.php
     ```
   - This will:
     - Clear all caches
     - Create storage link
     - Set correct permissions
     - Generate application key if needed

4. **Database Setup**
   - Import your database using phpMyAdmin
   - Make sure all tables are created
   - Verify database connection in `.env`

5. **Verify Installation**
   - Visit your website
   - Check if all features are working
   - Verify file uploads work
   - Check if sessions are working

## Troubleshooting

1. **Permission Issues**
   - Run `check-permissions.php` to fix permissions
   - Make sure storage and bootstrap/cache are writable

2. **Database Connection Issues**
   - Verify database credentials in `.env`
   - Check if database exists and is accessible
   - Verify database user has correct permissions

3. **Session Issues**
   - Make sure sessions table exists
   - Check if storage directory is writable
   - Verify session configuration in `.env`

## Support
For any issues during deployment, please contact:
- Email: support@sokasix.online
- Phone: [Your Support Number]
