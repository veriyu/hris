# Architecture Document

## 1. Core Architecture Pattern
The system follows a **Modular Monolith** architecture. While built entirely within a single Laravel application, domain logic is strictly separated into namespaces/modules to prevent tight coupling between HR and Cooperative functionalities.

## 2. Domain Layers
We enforce a strict separation of concerns using the following layers:
1. **Controllers / Livewire (Filament)**: Handles HTTP requests, form validation, and UI state. Should not contain business logic.
2. **Actions**: Single-responsibility classes that execute specific business use cases (e.g., `ApproveLoanAction`, `CalculatePayrollAction`). Actions can be called from Web, API, or Console commands.
3. **Services**: Classes that handle complex domain operations or coordinate multiple models (e.g., `PayrollService`, `LoanService`).
4. **Models**: Data access layer. Handles relationships, scopes, and simple data mutations. No complex business logic should reside here.
5. **Policies**: Handles all authorization checks.

## 3. Background Processing
To ensure the UI remains fast, any operation that takes more than 500ms or interacts with external services must be offloaded to a Queue.
- **Queued Actions**: Payroll generation, Bulk Email sending, PDF Report Generation.
- **Schedulers (Cron)**: Daily attendance sync, End-of-month savings accrual, Daily loan interest accrual (if applicable).

## 4. Admin Panel (Filament 5)
Filament 5 is the primary interface for all backend operations.
- **Resources**: Map directly to Eloquent models. We use Filament's Table and Form builders extensively.
- **Pages**: Custom dashboards for complex reporting (e.g., Cooperative Cash Flow Dashboard, Payroll Summary).
- **Widgets**: Real-time stats on the dashboard (e.g., Today's Absences, Total Pending Loans).

## 5. Deployment Architecture
- **Web Server**: Nginx or Apache (via Laravel Octane if performance requires it).
- **PHP**: PHP 8.3+.
- **Database**: MySQL 8.0+.
- **Queue/Cache**: Redis.
- **Containerization**: Docker for local development and CI/CD consistency.
