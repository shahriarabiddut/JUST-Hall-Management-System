# Just Hall Automation

## Introduction
The **Just Hall Automation** system is designed to streamline and automate various hall management processes, reducing manual workload and improving efficiency. It facilitates the management of student and staff records, meal plans, room bookings, balance tracking, and report generation. By implementing a structured and automated approach, this system enhances the overall experience for hall residents.

## Table of Contents
- [Features](#features)
- [Installation](#installation)
- [Usage](#usage)
- [Project Phases](#project-phases)
- [Sponsors](#sponsors)
- [Mentors & Supervisors](#mentors--supervisors)
- [License](#license)

## Features
- Multi-authentication system (Admin, Staff, Student) using Laravel Breeze
- Email verification for users
- Student & staff management (Admin CRUD operations)
- Room booking system with approval workflow
- Support system (Admin, Staff, and Student roles)
- Balance system with payment approval/rejection
- Meal ordering system with balance deduction
- Meal token generation with QR code validation
- Automated scheduled tasks using Cron Jobs
- Printing mechanism for meal tokens

## Installation
### Prerequisites
Ensure you have the following installed:
- PHP (>= 8.0)
- Laravel (latest version recommended)
- Composer
- MySQL or PostgreSQL
- Node.js & npm

### Steps
1. Clone the repository:
   ```bash
   git clone https://github.com/shahriarabiddut/JUST-Hall-Management-System.git
   cd just-hall-automation
   ```

2. Install dependencies:
   ```bash
   composer install
   npm install && npm run dev
   ```

3. Configure environment:
   - Copy `.env.example` to `.env`
   - Update database credentials

4. Run migrations and seed database:
   ```bash
   php artisan migrate --seed
   ```

5. Generate application key:
   ```bash
   php artisan key:generate
   ```

6. Start development server:
   ```bash
   php artisan serve
   ```

## Usage
- **Admin Panel**: Manage students, staff, room bookings, and financial transactions.
- **Staff Panel**: Handle meal orders, approve/reject payments, and manage support queries.
- **Student Panel**: Request room bookings, order meals, generate meal tokens, and track balance.

## Project Phases
### Phase 1: User Authentication & Management
- Multi-auth system (Admin, Staff, Student)
- Laravel Breeze setup with email verification
- Admin CRUD for students and staff

### Phase 2: Core Functionalities
- Room Booking System (Admin approval required)
- Support System (Tickets managed by Staff & Admin)
- Balance System (Staff manages payments, email notifications on status updates)
- **Meal Management:**
  - Order meals for the next day
  - Balance deduction upon ordering
  - Staff dashboard for meal order summaries
  - Meal token generation & validation via QR code
  - Scheduled tasks for automatic balance deductions

### Phase 3: Enhancements & Automation
- Printing system for meal tokens
- Live QR code scanner for validation
- Cron jobs for scheduled tasks like balance deduction and notifications

## Sponsors
**CSE, Jashore University of Science and Technology (JUST)**

## Mentors & Supervisors
- **Dr. Syed Md. Galib** - Professor (Supervisor)
- **Mostafijur Rahman Akhond** - Assistant Professor (Co-Supervisor)

## License
This project is open-source and licensed under the **MIT License**.
