# Personal Portfolio Website

A personal portfolio website built with Laravel 10.

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## About This Project

This is a personal portfolio website that showcases skills, experience, education, and certifications. It includes:

- Modern UI with dark mode support
- Admin panel for content management
- Contact form with AJAX submission
- Responsive design for all devices

## Technologies Used

- Laravel 10
- MySQL
- Bootstrap
- AlpineJS
- Tailwind CSS

## Installation

1. Clone the repository
```bash
git clone https://github.com/zhyarcr7/PersonalPortfolioWebsite.git
```

2. Install dependencies
```bash
composer install
npm install
```

3. Configure environment
```bash
cp .env.example .env
php artisan key:generate
```

4. Set up the database in .env file and run migrations
```bash
php artisan migrate --seed
```

5. Start the development server
```bash
php artisan serve
```

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
