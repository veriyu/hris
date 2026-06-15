# Initial Sprint Backlog

## Sprint 1: Foundation & Core HR
**Goal**: Establish the base architecture, authentication, and employee master data.
- [ ] Initialize Filament 5 & Shield (Roles/Permissions).
- [ ] Create `Department` and `Position` Schema, Models, and Filament Resources.
- [ ] Create `Employee` Schema, Models, and Filament Resource.
- [ ] Implement Soft Deletes globally.
- [ ] Write Unit Tests for Employee creation and relationships.

## Sprint 2: Attendance & Leave
**Goal**: Track employee presence and manage time off.
- [ ] Create `Shift`, `Attendance`, and `LeaveRequest` Schemas & Models.
- [ ] Develop API endpoint for Clock-In/Clock-Out.
- [ ] Create Filament Resource for Attendance monitoring.
- [ ] Implement Leave Approval Workflow (Actions & Policies).
- [ ] Write Feature Tests for Attendance constraints (no double clock-ins).

## Sprint 3: Cooperative Foundation (Members & Savings)
**Goal**: Register members and track their savings.
- [ ] Create `Membership`, `SavingType`, and `Saving` Schemas & Models.
- [ ] Create Action class to register an Employee as a Cooperative Member.
- [ ] Implement Filament interfaces for the Treasurer to view Member profiles and record manual Savings deposits.

## Sprint 4: Cooperative Loans
**Goal**: Manage the loan lifecycle and amortization.
- [ ] Create `Loan` and `LoanInstallment` Schemas & Models.
- [ ] Implement `CalculateAmortizationAction` (Flat Rate vs Declining Balance).
- [ ] Create Loan Approval Workflow.
- [ ] Develop Filament interfaces for Loan applications and payment tracking.

## Sprint 5: Payroll Integration
**Goal**: Tie HR attendance and Cooperative deductions together.
- [ ] Create `Payroll` and `PayrollDetail` Schemas & Models.
- [ ] Develop `GeneratePayrollAction` (fetches Base Salary, calculates Attendance penalties, fetches due `LoanInstallments` and mandatory `Savings`).
- [ ] Implement Queue Job for batch processing.
- [ ] Develop PDF Generator for Payslips.
- [ ] End-to-end integration testing.
