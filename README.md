<p align="center"><a href="https://residenthalls.just.edu.bd" target="_blank"><img src="https://residenthalls.just.edu.bd/img/just.jpg" width="400" alt="JustHallAutomation Logo"></a></p>

<p align="center">
<a href="https://github.com/JustHallAutomation/framework/actions"><img src="https://github.com/JustHallAutomation/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/JustHallAutomation/framework"><img src="https://img.shields.io/packagist/dt/JustHallAutomation/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/JustHallAutomation/framework"><img src="https://img.shields.io/packagist/v/JustHallAutomation/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/JustHallAutomation/framework"><img src="https://img.shields.io/packagist/l/JustHallAutomation/framework" alt="License"></a>
</p>

## Run the migration Command

php artisan migrate:refresh --seed

## Storage Link Command

php artisan storage:link

## Schedule Command

php artisan send:sms

## Larvel and PHP version

Laravel 10.x and PHP 8.2^

## About Just Hall Automation

The traditional manual processes in halls can be time-consuming, prone to errors and often result in poor coordination and management. The System is a solution that aims to streamline and automate various hall management processes, resulting in improved efficiency, reduced workload, and better overall experience for hall residents. It will aid in the management of student records, staff records, meal management and the generation of student report, among other things.

## Project phase Just Hall Automation

    1.  Multi Auth Complete
    Admin , Staff & User
    Larvel Breeze
    Email Verification Enabled for user
    Login Work for all
    Registration Only For Users
    Admin CRUD for Students and Staff

    2.1
    RoomBooking Added in Admin
    2.2
    Room Booking Request Added in Student Panel
    Admin Can se requests accept or reject it
    Support system add - Admin can view, Staff Can reply and View & Student can create and view and delete until replied
    2.3
    Balance system added in student
    Staff can add , accept and reject payments
    If staff accept or reject an email will be sent to the student
    If staff accepts payment -> Student balance will be added!
    2.4 Added Food Item and Time
    2.5 Food Order on next day and deducing balance -> Student Panel
    2.5.1 2.5;s view and controller functions refined
    2.5.2 Total orders on next day and order details in dashboard -> Staff Panel
    2.5.3 View orders from staff panel all, and by date with foodtime
    2.6 Meal token generated by user
    2.6.1 Meal token generated by order placed and marked as not used (2.6 changed with minimum set off order)
    2.6.2 Meal token checked is valid or not and checked for current date also
    2.7 In Console/Kernel Schedule Function is called (need to check is it working or not)
    2.8 Cron Job added per minute to deduct balance from fixed cost and mail the user
    2.9 Added Deduct Balance per month
    2.9.1 Add Settings option for fixed cost and name change in seeder also
    2.9.2 Add Deduct Balance per month from Database in SendSMS - Kernel
    2.9.3 Order change if selected less than 50 - (Not Ethical! Notice Would Be Better)

    3.1 Printer and printing Mechanism Added
    3.2 QR code added on Meal Tokens
    3.2 Live QR code scanner added for Meal Tokens to validate

## Time Scheduler using dot Bat File

1.  cd /d "directroy"
    php artisan app:deduct-balance-hall

2.  cd /d "directroy"
    php artisan app:process-daily-order

## dotEnv

SSLCommerz
SSLCZ_STORE_ID=
SSLCZ_STORE_PASSWORD=
SSLCZ_TESTMODE=true # set false when using live store id
IS_LOCALHOST=true

## SMTP

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=test@gmail.com
MAIL_PASSWORD=AppPassword
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="test@gmail.com"
MAIL_FROM_NAME="${APP_NAME}"

## JustHallAutomation Sponsors

CSE,Jashore University of Science And Technology

### Mentor / Supervisor

-   [Dr. Syed Md. Galib - Professor](https://just.edu.bd/t/smg) - ** Supervisor **
-   [Mostafijur Rahman Akhond - Assistant Professor](https://just.edu.bd/t/mra) - ** Co-Supervisor **
-   [Abu Rafe Md Jamil - Lecturer](https://just.edu.bd/t/armj) - ** Co-Supervisor **

## License

The JustHallAutomation framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
