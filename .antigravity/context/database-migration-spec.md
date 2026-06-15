# Database Migration & Schema Specification

## 1. Global Conventions
- All primary keys use `ulid` or `uuid` to prevent predictable IDs and facilitate offline synchronization if needed, but for simplicity and performance in a modular monolith, `bigIncrements` (id) is standard unless specified otherwise. We will stick to **`id()` (BigInt)** for standard tables.
- All foreign keys must have explicit constraints and `cascadeOnDelete()` or `restrictOnDelete()` defined.
    - Financial data (Loans, Savings, Payrolls) must use **`restrictOnDelete()`** to prevent accidental deletion of historical records.
- Use `$table->softDeletes()` for all master data (`Employees`, `Memberships`, `Departments`).
- Decimal columns for currency must use `$table->decimal('amount', 15, 2)` to prevent floating-point errors.

## 2. Table Specifications

### Users & Employees
- `users`: standard Laravel table.
- `departments`: `id`, `name`, `parent_id` (nullable FK to self), `timestamps`, `softDeletes`.
- `positions`: `id`, `name`, `level` (int), `timestamps`, `softDeletes`.
- `employees`: `id`, `user_id` (FK, unique), `nik` (string, unique), `department_id` (FK), `position_id` (FK), `first_name`, `last_name`, `base_salary` (decimal), `join_date` (date), `status` (enum: Active, Resigned, Terminated), `timestamps`, `softDeletes`.

### Attendance
- `attendances`: `id`, `employee_id` (FK), `date` (date), `clock_in` (datetime, nullable), `clock_out` (datetime, nullable), `status` (enum), `timestamps`.
  - **Index**: `['employee_id', 'date']` (Unique).

### Payroll
- `payrolls`: `id`, `employee_id` (FK), `period_month` (int), `period_year` (int), `basic_salary` (decimal), `net_salary` (decimal), `status` (enum), `timestamps`.
- `payroll_details`: `id`, `payroll_id` (FK), `type` (enum: Earning, Deduction), `description` (string), `amount` (decimal).

### Cooperative (Koperasi)
- `memberships`: `id`, `employee_id` (FK, unique), `member_no` (string, unique), `status` (enum), `timestamps`.
- `savings`: `id`, `membership_id` (FK), `type` (enum: Pokok, Wajib, Sukarela), `amount` (decimal), `transaction_date` (date), `timestamps`.
- `loans`: `id`, `membership_id` (FK), `principal_amount` (decimal), `interest_rate` (decimal, percentage), `tenor` (int), `status` (enum: Pending, Active, Paid), `timestamps`.
- `loan_installments`: `id`, `loan_id` (FK), `installment_number` (int), `due_date` (date), `principal` (decimal), `interest` (decimal), `total` (decimal), `status` (enum: Unpaid, Paid), `paid_at` (datetime, nullable), `payroll_id` (FK, nullable), `timestamps`.

## 3. Seeders
- `RoleAndPermissionSeeder`: Seed Superadmin, HR, Treasurer roles.
- `DepartmentSeeder`: Seed basic org structure.
- `DummyDataSeeder`: (Local only) Generate 50 employees, 20 members, active loans, and past payrolls for UI testing.
