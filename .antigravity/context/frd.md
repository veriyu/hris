# Functional Requirements Document (FRD)

## 1. System Architecture & Tech Stack
- **Framework**: Laravel (PHP 8+).
- **Admin Panel**: Filament v5.
- **Database**: MySQL.
- **Background Jobs**: Laravel Queue (Database/Redis driver) for heavy processing.
- **Task Scheduling**: Laravel Scheduler (cron).

## 2. Detailed Functional Specifications

### 2.1. Authentication & Authorization
- **FR1.1**: The system shall use Laravel Sanctum or standard session-based auth for web interfaces.
- **FR1.2**: Filament Shield (or Spatie Permission) shall be used for granular Role-Based Access Control (RBAC).

### 2.2. Attendance
- **FR2.1**: The system shall expose an API endpoint for clock-in/out, accepting timestamp, user ID, and GPS coordinates.
- **FR2.2**: A scheduled job shall run daily at 23:59 to flag absent employees who did not clock in or submit a leave request.

### 2.3. Payroll Processing
- **FR3.1**: The HR Manager shall be able to trigger a "Generate Payroll" action for a specific period.
- **FR3.2**: The system shall dispatch a Queue Job to calculate payroll per employee to prevent HTTP timeouts.
- **FR3.3**: The calculation engine must query the Cooperative `Loan` module to fetch active installments due for the current month.
- **FR3.4**: Once payroll is finalized, the system shall generate PDF payslips and store them in the filesystem/S3.

### 2.4. Cooperative Loans
- **FR4.1**: When a loan is approved, the system shall generate an `Amortization Schedule` containing N rows corresponding to the loan tenor.
- **FR4.2**: During payroll finalization, the system shall mark the corresponding `Amortization Schedule` row as "Paid" and create a `Transaction` ledger entry.
- **FR4.3**: The Treasurer shall be able to manually input a payment for a loan installment (e.g., if paid via cash/transfer outside of payroll).

### 2.5. Cooperative Savings
- **FR5.1**: Mandatory savings (Simpanan Wajib) shall be automatically billed monthly.
- **FR5.2**: The system shall provide a statement of account (Buku Tabungan) for each member, detailing all credits and debits.

## 3. Integrations & APIs
- **Email**: Integration with SMTP/Mailgun for sending payslips and approval notifications.
- **File Storage**: Local or AWS S3 for storing uploaded documents and generated PDFs.

## 4. Reporting (PDF/Excel)
- **FR6.1**: The system shall generate a Monthly Attendance Summary (Excel).
- **FR6.2**: The system shall generate a Bank Transfer Format for payroll disbursement (Excel/CSV).
- **FR6.3**: The system shall generate a Cooperative Cash Flow Statement and Member Balance Report (PDF/Excel).
