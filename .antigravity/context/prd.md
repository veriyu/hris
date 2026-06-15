# Product Requirements Document (PRD)

## 1. Product Vision
A unified platform that feels professional, fast, and transparent. The product must empower the HR and Finance/Cooperative teams to manage complex rules through an intuitive interface (Filament 5) while giving employees a simple, accessible portal for their daily needs.

## 2. Target Audience & Roles
- **Superadmin**: Full system access, configures global settings, roles, and permissions.
- **HR Manager**: Accesses Employee, Attendance, Leave, and Payroll modules.
- **Treasurer (Bendahara Koperasi)**: Accesses Memberships, Savings, Loans, and Cooperative Reports.
- **Employee/Member**: Accesses personal dashboard, attendance clock-in, payslip downloads, and loan applications.

## 3. Features & Requirements

### 3.1. Employee Management
- Centralized employee directory.
- Management of personal details, employment contracts, and bank accounts.
- Document vault (ID cards, contracts).

### 3.2. Time & Attendance
- Shift scheduling (fixed and flexible shifts).
- Clock-in/out mechanism (with geolocation tracking if applicable).
- Overtime calculation based on pre-approved requests.
- Leave management with hierarchical approval workflows.

### 3.3. Payroll System
- Configurable salary components (Earnings and Deductions).
- Integration with Attendance module to auto-calculate unpaid leave or late penalties.
- Integration with Cooperative module to auto-deduct loan installments and savings.
- Batch generation of payslips and email distribution.

### 3.4. Cooperative (Koperasi) Module
- **Savings Dashboard**: View balances for Simpanan Pokok, Wajib, and Sukarela.
- **Loan Origination**: Configurable loan products (interest rates, max tenors).
- **Credit Scoring**: Automatic validation of loan requests against the member's current salary (e.g., total deductions cannot exceed 30% of base salary).
- **Payment Schedules**: Auto-generation of amortization schedules (flat or declining balance).
- **Early Settlement**: Capability to process early loan payoffs.

## 4. Non-Functional Requirements
- **Performance**: Admin pages (Filament) must load under 1 second.
- **Security**: Data encryption for sensitive PII and financial records. Strict role-based access control (RBAC).
- **Usability**: Filament 5 UI must be highly responsive and mobile-friendly for employees accessing the system via phones.
- **Reliability**: Queue systems (e.g., for batch payroll processing) must have automatic retries and failure notifications.
