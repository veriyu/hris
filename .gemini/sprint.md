Sprint	Epic	Module	Detail Task	Priority	Estimated Days	Dependency
Sprint 1	Infrastructure Setup	Laravel Setup	Install Laravel 13 project	High	1	-
Sprint 1	Infrastructure Setup	Filament Setup	Install & configure Filament 5 panel	High	1	Laravel setup
Sprint 1	Infrastructure Setup	Authentication	Setup login authentication	High	1	Filament setup
Sprint 1	Infrastructure Setup	RBAC	Install Spatie Permission 7	High	1	Laravel setup
Sprint 1	Infrastructure Setup	Activity Log	Install Spatie Activity Log 5	High	1	Laravel setup
Sprint 1	Infrastructure Setup	Base Architecture	Setup Actions, Services, Enums, Policies folder structure	High	1	Laravel setup
Sprint 1	Infrastructure Setup	Panel Setup	Setup Admin Panel & Employee Panel	High	1	Filament setup
Sprint 1	Infrastructure Setup	Seeder	Create default roles & permissions seeder	High	1	RBAC setup
Sprint 1	Infrastructure Setup	Testing	Setup Pest/PHPUnit configuration	Medium	1	Laravel setup
Sprint 2	Organization Management	Company	Create company migration	High	1	Sprint 1
Sprint 2	Organization Management	Company	Create company model	High	1	Company migration
Sprint 2	Organization Management	Company	Create company service & action	Medium	1	Company model
Sprint 2	Organization Management	Company	Create company policy	Medium	1	RBAC
Sprint 2	Organization Management	Company	Create company Filament resource	High	1	Company model
Sprint 2	Organization Management	Outlet	Create outlet migration	High	1	Sprint 1
Sprint 2	Organization Management	Outlet	Create outlet model	High	1	Outlet migration
Sprint 2	Organization Management	Outlet	Create outlet relation to company	High	1	Outlet model
Sprint 2	Organization Management	Outlet	Create outlet Filament resource	High	1	Outlet model
Sprint 2	Organization Management	Department	Create department migration	High	1	Sprint 1
Sprint 2	Organization Management	Department	Create department model	High	1	Department migration
Sprint 2	Organization Management	Department	Create department Filament resource	High	1	Department model
Sprint 2	Organization Management	Position	Create position migration	High	1	Sprint 1
Sprint 2	Organization Management	Position	Create position model	High	1	Position migration
Sprint 2	Organization Management	Position	Create position Filament resource	High	1	Position model
Sprint 2	Organization Management	Testing	Feature test organization CRUD	Medium	2	All organization modules
Sprint 3	Employee Management	Employee	Create employee migration	High	1	Sprint 2
Sprint 3	Employee Management	Employee	Create employee model & relation	High	1	Employee migration
Sprint 3	Employee Management	Employee	Create employee number generator	High	1	Employee model
Sprint 3	Employee Management	Employee	Create employee enum status	Medium	1	Employee model
Sprint 3	Employee Management	Employee	Create employee service & action	High	2	Employee model
Sprint 3	Employee Management	Employee	Create employee policy	High	1	RBAC
Sprint 3	Employee Management	Employee	Create employee Filament resource	High	2	Employee model
Sprint 3	Employee Management	Employee	Create employee relation manager	Medium	1	Employee resource
Sprint 3	Employee Management	Employee	Create employee profile upload	Medium	1	Employee resource
Sprint 3	Employee Management	Employee Document	Create employee document migration	Medium	1	Employee module
Sprint 3	Employee Management	Employee Document	Create employee document upload	Medium	1	Employee document
Sprint 3	Employee Management	Employee Document	Setup private storage access	Medium	1	Employee document
Sprint 3	Employee Management	Employee Auth	Create employee user auto creation	High	1	Employee model
Sprint 3	Employee Management	Employee Auth	Setup employee login using employee number	High	1	Employee auth
Sprint 3	Employee Management	Employee Panel	Setup employee panel dashboard	Medium	1	Employee auth
Sprint 3	Employee Management	Testing	Feature test employee CRUD	High	2	Employee module
Sprint 3	Employee Management	Testing	Test employee permission scope	Medium	1	Employee policy
Sprint 4	Salary Management	Salary History	Create employee salary history migration	High	1	Sprint 3
Sprint 4	Salary Management	Salary History	Create employee salary history model	High	1	Migration
Sprint 4	Salary Management	Salary History	Create salary history relation	High	1	Model
Sprint 4	Salary Management	Salary History	Create salary update action	High	1	Service
Sprint 4	Salary Management	Salary History	Ensure only 1 active salary	High	1	Salary action
Sprint 4	Salary Management	Salary History	Create salary history Filament relation manager	Medium	1	Salary model
Sprint 4	Salary Management	Salary Structure	Add allowance field	Medium	1	Salary migration
Sprint 4	Salary Management	Salary Structure	Add deduction field	Medium	1	Salary migration
Sprint 4	Salary Management	Audit Log	Log salary changes	High	1	Activity log
Sprint 4	Salary Management	Testing	Feature test salary update	High	1	Salary module
Sprint 4	Salary Management	Testing	Test salary history append-only	High	1	Salary module
Sprint 5	Payroll Management	Payroll Period	Create payroll period migration	High	1	Sprint 4
Sprint 5	Payroll Management	Payroll Period	Create payroll period model	High	1	Migration
Sprint 5	Payroll Management	Payroll	Create payroll migration	High	1	Payroll period
Sprint 5	Payroll Management	Payroll	Create payroll model & relation	High	1	Payroll migration
Sprint 5	Payroll Management	Payroll Item	Create payroll item migration	High	1	Payroll
Sprint 5	Payroll Management	Payroll Item	Create payroll item model	High	1	Migration
Sprint 5	Payroll Management	Payroll	Create payroll service & action	High	2	Payroll model
Sprint 5	Payroll Management	Payroll	Create payroll Filament resource	High	2	Payroll model
Sprint 5	Payroll Management	Payroll	Create payroll employee repeater input	Medium	1	Payroll resource
Sprint 5	Payroll Management	Payroll	Create payroll total calculation	Medium	1	Payroll action
Sprint 5	Payroll Management	Payslip	Generate payslip PDF	High	2	Payroll module
Sprint 5	Payroll Management	Employee Panel	Employee payroll history page	Medium	1	Payroll module
Sprint 5	Payroll Management	Employee Panel	Employee payslip download	Medium	1	Payslip
Sprint 5	Payroll Management	Audit Log	Log payroll update	Medium	1	Activity log
Sprint 5	Payroll Management	Testing	Feature test payroll CRUD	High	2	Payroll module
Sprint 5	Payroll Management	Testing	Test payslip PDF generation	Medium	1	Payslip
Sprint 6	Security & Hardening	Policy	Finalize all policies	High	1	All modules
Sprint 6	Security & Hardening	Audit	Validate audit logging consistency	Medium	1	Activity log
Sprint 6	Security & Hardening	Validation	Improve form validation	Medium	1	All modules
Sprint 6	Security & Hardening	UX	Improve Filament navigation & grouping	Medium	1	All modules
Sprint 6	Security & Hardening	Testing	Final feature testing	High	2	All modules
Sprint 6	Security & Hardening	Testing	Permission access testing	High	1	Policies
Sprint 6	Security & Hardening	Backup	Setup database backup scheduler	Medium	1	Deployment
Sprint 6	Security & Hardening	Deployment	Setup VPS Ubuntu deployment	High	1	Final testing
Sprint 6	Security & Hardening	Deployment	Setup Nginx + PHP-FPM	Medium	1	VPS
Sprint 6	Security & Hardening	Deployment	Setup SSL HTTPS	Medium	1	Nginx
Sprint 6	Security & Hardening	Refactor	Final code cleanup & refactor	Medium	2	All modules
