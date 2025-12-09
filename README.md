# LiftlyFitness - Backend API

![Version](https://img.shields.io/badge/version-2.0.0-blue.svg)
![Laravel](https://img.shields.io/badge/Laravel-11.9-red.svg)
![PHP](https://img.shields.io/badge/PHP-8.2-purple.svg)
![License](https://img.shields.io/badge/license-MIT-green.svg)

## Overview

LiftlyFitness is a comprehensive fitness application backend built with Laravel 11, featuring modular architecture for workout tracking, nutrition management, progress analytics, and social community features.

## Features

### Core Modules

- **User Management**: Authentication, profiles, roles & permissions
- **Workout System**: Exercise library, workout templates, session tracking
- **Nutrition Tracking**: Food database, meal logging, macro calculations
- **Analytics**: Progress tracking, body measurements, performance metrics
- **Social Features**: Activity feed, follow system, workout sharing
- **Push Notifications**: OneSignal integration for reminders and alerts

### Technical Highlights

- RESTful API design with versioning
- Token-based authentication (Laravel Sanctum)
- Social authentication (Google, Facebook, Apple)
- Role-based access control
- Media management for images and videos
- Data export functionality (Excel)
- Real-time notifications

## Tech Stack

- **Framework**: Laravel 11.9
- **PHP Version**: 8.2+
- **Database**: MySQL
- **Cache**: Redis (recommended)
- **Queue**: Redis (recommended)
- **Authentication**: Laravel Sanctum
- **Notifications**: OneSignal

### Key Dependencies

- `nwidart/laravel-modules` - Modular architecture
- `spatie/laravel-permission` - Role & permission management
- `spatie/laravel-medialibrary` - Media file handling
- `laravel/sanctum` - API authentication
- `laravel/socialite` - Social login
- `maatwebsite/excel` - Data export
- `yajra/laravel-datatables` - Data tables

## Installation

### Prerequisites

- PHP >= 8.2
- Composer
- MySQL >= 8.0
- Node.js >= 18.x
- Redis (optional but recommended)

### Setup Steps

1. **Clone the repository**
```bash
git clone https://github.com/tsangkingyiu/LiftlyFitness-Prototype.git
cd LiftlyFitness-Prototype
```

2. **Install dependencies**
```bash
composer install
npm install
```

3. **Environment configuration**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Configure database**
Edit `.env` file with your database credentials:
```
DB_DATABASE=liftly_fitness
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

5. **Run migrations and seeders**
```bash
php artisan migrate --seed
```

6. **Install Sanctum**
```bash
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
```

7. **Build assets**
```bash
npm run dev
```

8. **Start the development server**
```bash
php artisan serve
```

The API will be available at `http://127.0.0.1:8000`

## Configuration

### OneSignal Setup

Add your OneSignal credentials to `.env`:
```
ONESIGNAL_APP_ID=your_app_id
ONESIGNAL_REST_API_KEY=your_rest_api_key
```

### Social Authentication

Configure social login providers in `.env`:
```
GOOGLE_CLIENT_ID=your_google_client_id
GOOGLE_CLIENT_SECRET=your_google_client_secret
GOOGLE_REDIRECT_URI=http://127.0.0.1:8000/auth/google/callback

FACEBOOK_CLIENT_ID=your_facebook_client_id
FACEBOOK_CLIENT_SECRET=your_facebook_client_secret
FACEBOOK_REDIRECT_URI=http://127.0.0.1:8000/auth/facebook/callback
```

### Cache & Queue (Production)

For production, use Redis:
```
CACHE_DRIVER=redis
QUEUE_CONNECTION=redis
SESSION_DRIVER=redis
```

## Project Structure

```
.
├── Modules/                 # Modular application features
│   ├── User/               # User management module
│   ├── Workout/            # Workout tracking module
│   ├── Nutrition/          # Nutrition management module
│   ├── Analytics/          # Progress analytics module
│   └── Social/             # Social features module
├── app/                    # Core application code
├── config/                 # Configuration files
├── database/               # Migrations and seeders
├── public/                 # Public assets
├── resources/              # Views and frontend assets
├── routes/                 # Route definitions
├── storage/                # Application storage
└── tests/                  # Test suite
```

## API Documentation

API documentation will be available at `/api/documentation` once configured.

### API Versioning

All API endpoints are versioned:
```
GET /api/v1/users
POST /api/v1/workouts
```

### Authentication

Include the bearer token in the Authorization header:
```
Authorization: Bearer {your_token}
```

## Development

### Running Tests

```bash
php artisan test
```

### Code Style

The project uses StyleCI for code style enforcement. All code follows PSR-12 standards.

### Creating New Modules

```bash
php artisan module:make ModuleName
```

## Deployment

### Production Checklist

- [ ] Set `APP_ENV=production`
- [ ] Set `APP_DEBUG=false`
- [ ] Configure production database
- [ ] Set up Redis for cache and queues
- [ ] Configure queue workers
- [ ] Set up scheduled tasks (cron)
- [ ] Configure backup system
- [ ] Set up monitoring and logging
- [ ] Enable HTTPS
- [ ] Configure CORS for mobile apps

### Queue Workers

Run queue workers in production:
```bash
php artisan queue:work --tries=3
```

### Scheduled Tasks

Add to crontab:
```
* * * * * cd /path-to-project && php artisan schedule:run >> /dev/null 2>&1
```

## Contributing

Contributions are welcome! Please follow these guidelines:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

### Coding Standards

- Follow PSR-12 coding standards
- Write unit tests for new features
- Update documentation as needed
- Keep commits atomic and descriptive

## Security

If you discover any security vulnerabilities, please email security@liftlyfitness.com instead of using the issue tracker.

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Support

- **Documentation**: [Wiki](https://github.com/tsangkingyiu/LiftlyFitness-Prototype/wiki)
- **Issues**: [GitHub Issues](https://github.com/tsangkingyiu/LiftlyFitness-Prototype/issues)
- **Email**: support@liftlyfitness.com

## Roadmap

### v2.1.0 (Planned)
- [ ] Workout recommendation engine
- [ ] AI-powered meal planning
- [ ] Integration with fitness wearables
- [ ] Video workout streaming

### v2.2.0 (Planned)
- [ ] Trainer marketplace
- [ ] Live workout sessions
- [ ] Advanced analytics dashboard
- [ ] Multi-language support

## Acknowledgments

- Laravel Framework
- Spatie packages ecosystem
- OneSignal for push notifications
- All contributors and supporters

---

**Version**: 2.0.0  
**Last Updated**: December 2025  
**Maintainer**: [@tsangkingyiu](https://github.com/tsangkingyiu)