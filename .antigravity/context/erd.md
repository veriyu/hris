# Entity Relationship Diagram (ERD) Specification

*Note: This is a text-based representation of the core ERD.*

## Core HR Entities
- **Users**: Authentication details (email, password), polymorphic relationship to `Employee`.
- **Employees**: Master data (NIK, name, DOB, address, join date, base salary).
    - BelongsTo: `Department`, `Position`.
- **Departments**: Org structure (name, parent_id).
- **Positions**: Job titles (name, level).

## Attendance & Leave
- **Shifts**: Work schedules (name, start_time, end_time).
- **Attendances**: Daily records.
    - BelongsTo: `Employee`, `Shift`.
    - Fields: date, clock_in, clock_out, late_minutes, status (Present, Absent, Leave).
- **LeaveRequests**: Leave applications.
    - BelongsTo: `Employee`.
    - Fields: type (Annual, Sick, Unpaid), start_date, end_date, status.

## Payroll Entities
- **PayrollPeriods**: The month/year being processed.
- **Payrolls**: The generated payslip record.
    - BelongsTo: `Employee`, `PayrollPeriod`.
    - Fields: basic_salary, total_allowances, total_deductions, net_salary, status (Draft, Finalized, Paid).
- **PayrollDetails**: Line items for a specific payroll.
    - BelongsTo: `Payroll`.
    - Fields: type (Earnings, Deductions), name (e.g., "Overtime", "Loan Installment"), amount.

## Cooperative Entities
- **Memberships**: Cooperative member profile.
    - BelongsTo: `Employee`.
    - Fields: member_number, join_date, status (Active, Inactive).
- **SavingTypes**: Types of savings.
    - Fields: name (Pokok, Wajib, Sukarela), default_amount.
- **Savings**: Ledger entries for savings.
    - BelongsTo: `Membership`, `SavingType`, `Payroll` (nullable, if deducted via payroll).
    - Fields: date, amount, type (Debit/Credit), balance_after.
- **Loans**: Loan application master.
    - BelongsTo: `Membership`.
    - Fields: principal_amount, interest_rate, tenor_months, status (Pending, Approved, Active, Closed).
- **LoanInstallments**: Amortization schedule.
    - BelongsTo: `Loan`, `Payroll` (nullable).
    - Fields: due_date, principal, interest, total, status (Unpaid, Paid).
