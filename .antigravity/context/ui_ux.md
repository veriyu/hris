# UI/UX Standard Document

## 1. Philosophy
The UI must prioritize **Data Density**, **Clarity**, and **Speed**. Operational users (HR, Treasurer) look at these screens for 8 hours a day. They do not need massive whitespace or unnecessary animations; they need to see as much relevant data as possible without feeling overwhelmed.

## 2. Filament 5 Implementation Guidelines
- **Theme**: Use a refined color palette. Avoid default primary colors; use professional, muted tones (e.g., Slate or Zinc for neutral backgrounds, specific branding colors for primary actions).
- **Dark Mode**: Must be fully supported. High-contrast text is required for readability.
- **Navigation**: Group navigation logically:
    - `Employee Management` (Employees, Departments)
    - `Time & Attendance` (Attendances, Leave Requests)
    - `Payroll` (Processing, Reports)
    - `Cooperative` (Members, Savings, Loans)
- **Forms**: 
    - Use Tabs, Sections, and Fieldsets to organize complex forms (e.g., Employee creation).
    - Use native Filament form validation (live validation where appropriate).
- **Tables**:
    - Always include search and filters for critical tables (e.g., filter Loans by Status).
    - Summarize financial columns at the bottom of the table (e.g., Total Loan Amount on the current page).
    - Use badges for Enums (e.g., Green for Paid, Red for Unpaid, Yellow for Pending).

## 3. Mobile Responsiveness
- Employees will mostly access the portal via mobile to view payslips or clock in.
- The Employee Dashboard must be "Mobile-First". Tables should collapse gracefully or be replaced by list views on small screens.
