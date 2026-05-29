# HRMS MVP V1 — Project Overview

## Project Summary

This project is an Indonesia-focused HRMS (Human Resource Management System) MVP designed for small companies with approximately 100–200 employees and multiple outlets.

The purpose of this MVP is to:
- manage employee master data
- manage employee salary history
- manage simple payroll
- provide basic employee self-service

This is intentionally NOT an enterprise HRMS.

The architecture prioritizes:
- simplicity
- maintainability
- fast delivery
- scalability for future V2 expansion

---

# Tech Stack

## Backend
- Laravel 13
- PHP 8.4
- MySQL

## Admin Panel
- Filament 5

## Authorization
- Spatie Permission 7

## Audit Logging
- Spatie Activity Log 5

## Infrastructure
- VPS Ubuntu
- Nginx
- PHP-FPM

---

# Development Philosophy

## MVP First

This project intentionally avoids overengineering.

The system should:
- work quickly
- be easy to maintain
- support gradual feature expansion

Do NOT introduce:
- microservices
- CQRS
- event sourcing
- complex workflow engines
- enterprise payroll engines

unless explicitly requested.

---

# Business Scope

## Included in V1

### Organization
- Company
- Outlet
- Department
- Position

### Employee
- Employee master data
- Employee document upload
- Employee authentication
- Employee profile management

### Salary
- Salary history
- Allowance
- Deduction

### Payroll
- Manual payroll input
- Payroll period
- Payroll item
- Payslip PDF generation

### Access Control
- Role & permission
- Employee panel

### Audit
- Salary change log
- Employee update log

---

# Excluded from V1

The following are intentionally postponed to V2:

- attendance system
- leave management
- overtime
- approval engine
- BPJS automation
- PPh21 automation
- payroll auto-calculation
- queue system
- Redis
- websocket
- notification engine

---

# Company Structure

Single company structure:

Company
├── Outlets
    ├── Departments
        ├── Employees

---

# Employee Rules

## Employee Number

Format:

EMP-YYYY-00001

Example:

EMP-2026-00001

Employee number must be:
- unique
- auto generated

---

# Authentication

## Login Identifier

Use:
- employee_number

NOT email.

---

# Salary Rules

## Salary Structure

Salary contains:
- basic salary
- allowance
- deduction

## Salary History

Salary history is append-only.

Do NOT overwrite old salary data.

Only one active salary record per employee.

---

# Payroll Rules

## Payroll Type

Payroll is still manual in V1.

No automatic payroll engine yet.

## Payroll Features

- payroll period
- payroll employee item
- manual total salary input
- payslip PDF generation

## Payroll State

Payroll is editable.

No finalized/posting workflow yet.

---

# Employee Self Service (ESS)

Employee can:
- login
- view own profile
- view payroll history
- download payslip

Employee cannot:
- edit salary
- access other employees

---

# Access Control

## Roles

Recommended roles:

- Super Admin
- HR
- Outlet Manager
- Employee

## Permissions

### HR
- manage all employees
- manage payroll
- manage salary

### Outlet Manager
- view employees within own outlet

### Employee
- view own data only

---

# Audit Rules

Audit log is mandatory for:
- employee update
- salary update
- payroll update

Use:
- Spatie Activity Log

---

# Database Strategy

## ID Strategy

Use:
- bigint increment

NOT UUID.

## Timestamps

All tables must have:
- created_at
- updated_at

## Soft Delete

Use soft delete for:
- employees
- payrolls

---

# File Upload Rules

## Employee Documents

Store:
- KTP
- KK
- NPWP
- employment contract

Use:
- private storage

---

# Recommended Folder Structure

app/
├── Actions/
├── Data/
├── Enums/
├── Filament/
├── Models/
├── Policies/
├── Services/

---

# Architecture Rules

## Important

DO NOT:
- put business logic in Filament Resource
- put heavy business logic in Model

Use:
- Service layer
- Action layer

---

# Development Workflow

Every feature implementation MUST follow this order:

1. Database schema
2. Enum
3. Model
4. Service
5. Action
6. Policy
7. Filament resource
8. UI
9. Test
10. Refactor

Do NOT skip steps.

Do NOT write pseudo code.

All code must be:
- production ready
- testable
- maintainable

---

# Sprint Overview

## Sprint 1
Infrastructure & Foundation

## Sprint 2
Organization Module

## Sprint 3
Employee Module

## Sprint 4
Salary Module

## Sprint 5
Payroll Module

## Sprint 6
Hardening & Deployment

---

# Coding Standards

## Laravel Standards

- use Form Request or Data object validation
- use Policy authorization
- use eager loading properly
- avoid N+1 query
- use typed properties
- use PHP enums when appropriate

## Database Standards

- use foreign key constraints
- use proper indexing
- use nullable only when necessary

---

# Testing Strategy

Minimum required tests:
- feature test
- policy authorization test
- salary history test
- payroll CRUD test

---

# Future V2 Roadmap

Planned future modules:

- attendance import
- attendance recap
- leave management
- overtime
- approval workflow
- BPJS
- PPh21
- payroll automation
- notification system
- queue system

---

# Important Notes for AI Agents

This project is:
- modular
- MVP-oriented
- intentionally simplified

Do not introduce enterprise complexity unless explicitly requested.

Prioritize:
- readability
- maintainability
- speed of development
- operational stability

This system will evolve incrementally.