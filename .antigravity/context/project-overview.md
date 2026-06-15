# Project Overview

**Project Name**: Veriyu HRIS
**Domain**: Human Resource Management System & Cooperative System (HRMS + Koperasi)
**Primary Interface**: Filament 5 Admin Panel
**Core Framework**: Laravel (PHP 8+)

## High-Level Summary
Veriyu HRIS is a comprehensive business application designed to manage organizational human resources alongside a fully functional employee cooperative (Koperasi) module. The system handles the entire employee lifecycle—from onboarding and daily attendance to complex payroll calculations—while simultaneously managing their cooperative memberships, savings (Simpanan), and loans (Pinjaman).

## Key Modules

### 1. Core HR (Employee Management)
- Employee master data, organization structure (departments, roles, positions).
- Contract management and document storage.

### 2. Time & Attendance
- Clock-in/out tracking, shift management, overtime calculations.
- Leave (Cuti) and permission request workflows with multi-tier approvals.

### 3. Payroll Processing
- Automated salary calculation based on attendance, allowances, and deductions.
- Direct integration with the Cooperative module for automatic loan deductions via payroll.
- Payslip generation (PDF).

### 4. Cooperative (Koperasi) Management
- Member registration and status tracking.
- **Simpanan (Savings)**: Mandatory, principal, and voluntary savings tracking.
- **Pinjaman (Loans)**: Loan applications, approval workflows, interest calculation (flat/declining), and installment tracking.
- Cash flow and treasury management.

## Technical Foundations
- **Architecture**: Modular monolith with strict separation of concerns (Models, Services, Actions).
- **Background Processing**: Heavy use of Queues and Schedulers for payroll generation, loan interest accruals, and report generation.
- **Quality Assurance**: Comprehensive Laravel Testing (Unit & Feature).
- **Infrastructure Ready**: Designed with Docker, CI/CD, and scalable distributed system concepts in mind.
