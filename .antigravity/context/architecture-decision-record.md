# Architecture Decision Record (ADR)

## ADR 001: Choice of Admin Panel Framework
- **Context**: We need a fast, reliable, and maintainable interface for complex CRUD operations and dashboards for HR and Finance teams.
- **Decision**: Use **Filament v5**.
- **Rationale**: Filament integrates perfectly with the TALL stack (Tailwind, Alpine, Laravel, Livewire). It provides rapid development capabilities for complex forms, tables, and relational data management without the overhead of building a custom SPA (React/Vue). This aligns with the "maintainable architecture" and "practicality" core rules.

## ADR 002: Modular Monolith vs Microservices
- **Context**: The system handles both HR/Payroll and Cooperative Finance. Should they be separate services?
- **Decision**: **Modular Monolith**.
- **Rationale**: The data is highly interconnected (e.g., payroll must know about loan installments). Managing distributed transactions between an HR service and a Finance service introduces unnecessary complexity and risks data integrity. A modular monolith allows logical separation while keeping data ACID compliant within a single MySQL database.

## ADR 003: Action Classes for Business Logic
- **Context**: Where should business logic reside? Fat models, fat controllers, or services?
- **Decision**: **Action Classes** combined with Services.
- **Rationale**: Following the "Single Responsibility Principle", Action classes (e.g., `ProcessLeaveRequestAction`) make the codebase highly testable and allow the same logic to be reused across Filament Controllers, API endpoints, and Console Commands.

## ADR 004: Soft Deletes
- **Context**: Financial and HR data must be auditable. Hard deleting a department or an employee might break historical payroll records.
- **Decision**: **Enable Soft Deletes** globally on critical entities.
- **Rationale**: Preserves data integrity and history.

## ADR 005: Enums for Statuses
- **Context**: Tables often have statuses (e.g., Loan Status: Pending, Approved, Rejected, Paid).
- **Decision**: **Use PHP 8.1 Native Backed Enums**.
- **Rationale**: Provides type safety, auto-completion, and integrates seamlessly with Filament and Laravel's Eloquent casting.
