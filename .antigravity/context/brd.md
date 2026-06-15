# Business Requirements Document (BRD)

## 1. Executive Summary
The Veriyu HRIS & Cooperative system aims to digitalize and unify human resource management and cooperative (Koperasi) financial operations. By eliminating manual data entry and bridging the gap between HR payroll and cooperative loans/savings, the organization will reduce administrative overhead, eliminate calculation errors, and build trust among employees.

## 2. Business Objectives
- **Reduce Administrative Time**: Decrease time spent on payroll calculation and cooperative ledger reconciliation by 80%.
- **Zero-Error Payroll Deductions**: Guarantee that cooperative loan installments and mandatory savings are automatically and accurately deducted from monthly payrolls.
- **Transparency**: Provide employees/members with 24/7 access to their attendance, payslips, savings balances, and loan status.
- **Financial Integrity**: Ensure standard accounting practices are applied to cooperative funds, enabling the treasurer to produce accurate cash flow and income statements.

## 3. Stakeholders
- **Management / Board**: Requires high-level reporting on workforce productivity and cooperative financial health.
- **HR Department**: Manages employee lifecycles, monitors attendance, calculates payroll, and enforces HR policies.
- **Cooperative Treasurer (Bendahara)**: Manages member funds, approves loans, tracks repayments, and maintains the cooperative's cash flow.
- **Employees / Members**: End-users who clock in/out, request leave, view payslips, apply for loans, and monitor their cooperative savings.

## 4. Key Business Processes
### 4.1. HR Workflow
- **Attendance**: Clock-in/out mapped to shifts. System automatically flags lateness, early outs, and absences.
- **Leave Management**: Employees submit requests -> Supervisor approves -> HR validates -> Attendance balance is adjusted.
- **Payroll**: System aggregates base salary, attendance penalties, overtime, allowances, tax, and **cooperative deductions** to generate the final net pay.

### 4.2. Cooperative Workflow
- **Membership**: Employees opt-in to become cooperative members. Registration triggers initial mandatory savings (Simpanan Pokok).
- **Savings (Simpanan)**: Routine deductions from payroll for mandatory savings (Simpanan Wajib). Optional voluntary savings can be deposited manually or via payroll.
- **Loans (Pinjaman)**: Member applies for a loan -> Treasurer reviews member's capacity to pay (based on salary and existing deductions) -> Approval -> Funds disbursed -> Automated monthly payroll deduction begins until the loan is settled.

## 5. Success Metrics
- 100% automated synchronization between active loans and payroll deductions.
- Generation of monthly payroll and cooperative financial reports within 1 business day of month-end.
- Zero manual spreadsheet reconciliation required for cooperative ledgers.
