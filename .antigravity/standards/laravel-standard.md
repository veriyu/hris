# Laravel Standard

## Preferred Workflow

Use only required layers.

Possible layers:

- Migration
- Enum
- Model
- Service
- Action
- Policy
- API
- Filament Resource
- Test

Do not create unnecessary layers.

## Layer Responsibility

Service

- Coordinate business processes.
- Call multiple actions.
- Manage transactions.

Action

- Execute a single business operation.
- Reusable business logic unit.

Example:

VoidApprovalService
    -> ApproveVoidAction
    