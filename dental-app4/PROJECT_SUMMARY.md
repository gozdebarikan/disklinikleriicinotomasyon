# Project Summary

## Architecture
DentalApp follows a strict **Model-View-Controller (MVC)** architectural pattern implemented in pure PHP, ensuring clean separation of concerns and maintainability without the overhead of heavy frameworks.

### Core Components
*   **Controllers (`app/Controllers`):** Handle HTTP requests, input validation, and coordinate services. (e.g., `AppointmentController`).
*   **Services (`app/Services`):** Encapsulate business logic. (e.g., `AppointmentService` handles booking rules, `MailService` handles notifications).
*   **Repositories (`app/Repositories`):** Abstract database access. All SQL operations are confined here. (e.g., `DoctorRepository`, `BaseRepository`).
*   **Middleware (`app/Middleware`):** Handle cross-cutting concerns like Authentication (`AuthMiddleware`) and CSRF protection (`CsrfMiddleware`).

## Key Implementations

### Security
*   **CSRF Protection:** Token-based validation on all POST requests.
*   **XSS Prevention:** Output escaping in views and input sanitization.
*   **SQL Injection Prevention:** 100% usage of PDO prepared statements in Repositories.

### Database
*   **SQLite:** Chosen for portability and ease of setup.
*   **Schema:** Relational design with `users`, `doctors`, and `appointments` tables.

### Email System
*   **Dual Driver:** Supports both `smtp` (production) and `log` (development) modes.
*   **Buffer Protection:** APIs use output buffering (`ob_clean`) to ensure JSON responses are never corrupted by debug output or SMTP warnings.

### Frontend
*   **Custom Framework:** A lightweight CSS framework inspired by Tailwind, utilizing CSS variables for theme management (Dark/Light mode support).
*   **Interactvity:** Vanilla JavaScript for AJAX requests (booking/cancelling) and GSAP for smooth UI transitions.
