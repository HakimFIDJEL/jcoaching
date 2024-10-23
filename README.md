# 🏋️‍♂️ JCoaching

## 📝 About the Project

**JCoaching** is a Laravel application that serves both as a showcase website and a management tool for home fitness coaches. It allows the coach to schedule sessions, chat with members, and offers members the ability to purchase individual sessions or subscription packages with an optional nutrition follow-up through secure Stripe payments.

## ✨ Features

### 🔐 Authentication System:
- Secure login, registration, password reset (via token), and yearly password change requirement.

### 🌐 Showcase Website:
- Pages: Home, About, Gallery, Pricing, Contact.
- Legal pages: Terms of Service, Privacy Policy, Legal Notices, General Sales Conditions.

### 🧑‍🤝‍🧑 Member Area:
- Dashboard for members.
- Purchase individual sessions or select subscription plans with or without nutrition options.
- Secure payment via Stripe without storing credit card information.
- Invoice generation and email notifications.
- Calendar to schedule sessions.
- Instant messaging through WebSocket server for direct communication with administrators.

### 🛠️ Admin Area:
- Dashboard for administrators.
- Manage users (members and admins), subscription plans, and contacts from the contact form.
- Manage discounts, FAQs, feedbacks, gallery, pricing, orders, and invoices.
- Calendar for session management (schedule, mark as complete, notify users).
- Soft delete functionality for all data, with options to restore or permanently delete.

## 🚀 Installation

### Prerequisites:
- PHP >= 8.2.0
- MySQL >= 8.0
- Node.js >= 18
- Composer
- Vite
- Optional: Docker

### Steps to Install:

1. Clone the repository:

   git clone https://github.com/yourusername/jcoaching.git
   cd jcoaching

2. Install PHP dependencies:

   composer install

3. Install Node modules:

   npm install

4. Copy the `.env` file:

   cp .env.example .env

5. Set up your environment variables, including:
   - Stripe API key.
   - Laravel Reverb WebSocket and Pusher settings.
   - Mail log settings.

6. Generate the application key:

   php artisan key:generate

7. Run migrations:

   php artisan migrate

8. Seed Database:

   php artisan db:seed

## 🔧 Running the Application

To run the application, follow these steps:

1. In one terminal, start the Laravel server:

   php artisan serve

2. In another terminal, run Vite:

   npm run dev

3. Start the queue worker:

   php artisan queue:work

4. Start the WebSocket server:

   php artisan reverb:start

## 🧪 Running Tests

Unit and feature tests are available for most models and features. To run tests:

   php artisan test

## 🛠️ Technologies Used

- Laravel 11
- MySQL 8.0
- Stripe (for payments)
- CSS and Bootstrap
- Vite for front-end asset bundling
- jQuery and Vanilla JS
- Laravel Reverb for WebSocket communication
- Optional: Docker

## ❗ License

This project is open-source but not open to contributions. No license is specified.
