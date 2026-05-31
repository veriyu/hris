# Laravel Standard

## Required Workflow

1. Migration
2. Enum
3. Model
4. Service
5. Action
6. Policy
7. API
8. Filament Resource
9. Test

## Validation

Use FormRequest whenever possible.

## Business Logic

Do not place business logic inside:

- Controller
- Filament Resource
- Model

Place business logic inside:

- Service
- Action

## Authorization

Always use:

- Policy
- Spatie Permission

Never hardcode role checks.

Bad:

if ($user->role === 'admin')

Good:

$user->can('approve loan')

## Database

Always:

- Foreign keys
- Indexes
- Soft delete when needed

## Transactions

Use DB transaction for critical processes.

Examples:

- Payroll generation
- Loan disbursement
- Savings withdrawal