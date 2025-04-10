# Personal Portfolio Website

This is a personal portfolio website built with Laravel, featuring a real-time chat system using Socket.io.

## Features

- Portfolio showcase with works/projects
- Admin dashboard for content management
- Blog system
- CV/Resume section
- Real-time chat messaging system
- Testimonials

## Setup

1. Clone the repository
2. Run `composer install` to install PHP dependencies
3. Run `npm install` to install Node.js dependencies
4. Copy `.env.example` to `.env` and configure your environment
5. Run `php artisan key:generate` to generate an application key
6. Configure your database in the `.env` file
7. Run `php artisan migrate` to create the database tables
8. Run `php artisan db:seed` to seed the database with initial data (optional)

## Running the Application

### Laravel Server

```bash
php artisan serve
```

### Socket.io Server

The chat system uses Socket.io for real-time messaging. To start the Socket.io server:

```bash
node socket-server.js
```

Make sure to keep this server running alongside your Laravel application for the chat functionality to work properly.

## Chat System

The real-time chat system allows communication between users and administrators. It features:

- Real-time messaging with Socket.io
- Read receipts
- Message history
- Email notifications for new messages

## Frontend Assets

To compile the frontend assets:

```bash
npm run dev
```

For production:

```bash
npm run build
```

## License

[MIT License](LICENSE.md)
