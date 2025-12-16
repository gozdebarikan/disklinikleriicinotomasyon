# DentalApp - Clinic Management System

A modern, secure, and efficient Dental Clinic Management System built with PHP (Vanilla + MVC Architecture). Designed for speed, security, and ease of use in local environments (XAMPP).

## 🚀 Features

*   **Appointment Management:** Interactive calendar, booking, rescheduling, and cancellation with email notifications.
*   **User Management:** Patient registration/login, profile management, and role-based access (future-proof).
*   **Doctor Availability:** Real-time slot management based on doctor functionality.
*   **Email Notifications:** SMTP support (Gmail) and local file logging for development.
*   **Modern UI:** Responsive design using Tailwind-like custom CSS utility classes.
*   **Security:** CSRF protection, comprehensive input validation, password hashing, and secure session management.
*   **Performance:** Optimized SQL queries and output buffering for reliable API responses.

## 🛠 Tech Stack

*   **Backend:** PHP 8+ (No Framework - Pure MVC)
*   **Database:** SQLite (Embedded, zero-config)
*   **Frontend:** HTML5, CSS3 (Custom Design System), JavaScript (ES6+), GSAP (Animations)
*   **Dependencies:** PHPMailer (for SMTP)

## 📦 Installation

This project is optimized for XAMPP or any standard PHP environment.

1.  **Clone the Repository**
    ```bash
    git clone https://github.com/FrostSue/Dental-App-Project.git
    cd Dental-App-Project
    ```

2.  **Setup Dependencies**
    *   Download [PHPMailer](https://github.com/PHPMailer/PHPMailer) and place it in the `vendor/phpmailer` directory.
    *   Structure: `vendor/phpmailer/src/PHPMailer.php` etc.

3.  **Database Setup**
    *   Run `setup.php` in your browser (e.g., `http://localhost/dental-app/setup.php`) or terminal:
        ```bash
        php setup.php
        ```
    *   This will create the `database/dental.sqlite` file and seed initial data.

4.  **Configuration**
    *   Review `config/database.php` and `config/mail.php`.
    *   For email, switch to `'default' => 'smtp'` in `config/mail.php` and provide Gmail App Password if needed. Default is `log` mode (saves emails to `storage/logs/mails`).

## 🔑 Default Accounts

*   **Patient:** `test@example.com` / `123456`
*   **Admin:** `admin@example.com` / `123456`

## 📜 License

This project is licensed under the GNU General Public License v3.0 - see the [LICENSE](LICENSE) file for details.
