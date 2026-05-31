# Coding Standard

## General Principles

- Follow SOLID principles.
- Follow DRY principle.
- Follow KISS principle.
- Prefer readability over clever code.
- Avoid premature optimization.

## Naming Convention

### Classes

Good:

UserService
GeneratePayrollAction
LoanApprovalPolicy

Bad:

userService
usrSvc

### Methods

Good:

calculateInterest()
generateSchedule()
approveLoan()

Bad:

calc()
process()

### Variables

Good:

$memberLoan
$approvedAmount

Bad:

$ml
$tmp

## Comments

Avoid obvious comments.

Bad:

// increment counter
$counter++;

Good:

// Recalculate interest because loan amount changed
$this->recalculateInterest();

## Code Quality

- No dead code.
- No commented code.
- No TODO left in production code.
- No duplicated business logic.

## Performance

- Avoid N+1 query.
- Use eager loading.
- Use database indexes.
- Paginate large datasets.

## Security

- Always authorize actions.
- Always validate requests.
- Never trust client input.