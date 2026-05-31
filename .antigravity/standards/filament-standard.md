# Filament Standard

## Resource Structure

Resource
├── Pages
├── Relation Managers
├── Forms
└── Tables

## Form Rules

- Use Sections.
- Use Fieldsets for grouping.
- Use helper text when needed.
- Validate on save.

## Table Rules

- Searchable columns.
- Sortable columns.
- Filters where necessary.

## Permissions

Every resource must support:

- view
- viewAny
- create
- update
- delete

via Policy.

## Performance

Use eager loading.

Avoid:

TextColumn::make('member.branch.region.name')

without eager loading.