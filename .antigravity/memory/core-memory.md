# Core Memory

## User Persona & Philosophy
The lead engineer and architect of this project is a developer who focuses on business applications and operational systems (Laravel & Filament). They also serve as a volunteer cooperative treasurer (bendahara koperasi).

Key characteristics shaping this project:
- **Practicality over Hype**: Solutions must address real field operations, not just "run technically".
- **Business Logic First**: Deep understanding of financial processes, member transactions, savings, loans, and cash flow.
- **Data Integrity is Paramount**: Financial and HR data must be accurate, traceable, and secure.
- **Maintainable Architecture**: Prefers building scalable, sustainable foundations rather than quick fixes.
- **Workflow Automation**: System must handle repetitive tasks (queues, schedulers) to reduce human error.
- **Reporting System**: Generating accurate, exportable (PDF/Excel) reports is critical for operational transparency.

## Tech Stack Directives
- **Backend**: PHP 8+, Laravel 11/13.
- **Admin Panel**: Filament 5 (Primary UI for operational workflows).
- **Database**: MySQL.
- **Key Concepts**: REST API, Queue & Scheduler, Laravel Testing, PDF & Reporting System.
- **Modern Expansion**: React + Vite, Docker, CI/CD, DevOps workflows.

## Workflow Rules (Strict Implementation Sequence)
1. Database schema
2. Enum
3. Model
4. Service
5. Action
6. Policy
7. API
8. Filament resource
9. UI
10. Test
11. Refactor

*Rule Exception: Never skip implementation details. No pseudo-code. All code must be production-ready and testable.*
