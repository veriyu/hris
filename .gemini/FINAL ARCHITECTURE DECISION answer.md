Section	Category	Question	Hint / Contoh Jawaban	Answer
Database	ID Strategy	Gunakan bigint increment atau UUID?	bigint increment	bigint increment
Database	Audit	Apakah created_by dan updated_by diperlukan?	Ya	ya
Database	Soft Delete	Table apa saja yang perlu soft delete?	employee, payroll	employee, payroll
Database	Timestamp	Apakah seluruh table wajib timestamps?	Ya	ya
Employee	Employee Table	Apakah employee_number unique?	Ya	ya
Employee	Employee Table	Apakah NIK wajib unique?	Ya	ya
Employee	Employee Table	Apakah email wajib unique?	Tidak	ya
Employee	Employee Table	Apakah employee punya direct supervisor?	Ya	Ya
Employee	Employee Table	Apakah employee punya outlet utama?	Ya	Ya
Employee	Employee Table	Apakah employee punya department utama?	Ya	Ya
Employee	Employee Table	Apakah employee punya position utama?	Ya	Ya
Employee	Employment	Apakah resign employee menjadi read-only?	Ya	Ya
Employee	Document	Apakah dokumen disimpan per employee?	Ya	Ya
Employee	Document	Apakah file upload menggunakan private storage?	Ya	Ya
Salary	Salary Structure	Apakah salary disimpan sebagai history table?	Ya	Ya
Salary	Salary Structure	Apakah hanya 1 active salary per employee?	Ya	Ya
Salary	Salary Structure	Apakah allowance dipisah dari basic salary?	Ya	Ya
Salary	Salary Structure	Apakah deduction dipisah dari salary?	Ya	Ya
Salary	Payroll	Apakah payroll dapat diedit setelah dibuat?	Ya	Ya
Salary	Payroll	Apakah payroll finalized diperlukan?	Tidak dulu	Tidak dulu
Salary	Payroll	Apakah payroll period unique?	Ya	Ya
Salary	Payroll	Apakah payroll item disimpan per employee?	Ya	Ya
Salary	Payroll	Apakah payslip PDF disimpan permanen?	Ya	Ya
RBAC	Role	Apakah employee role otomatis dibuat saat employee dibuat?	Ya	Ya
RBAC	Policy	Apakah employee hanya melihat data sendiri?	Ya	Ya
RBAC	Policy	Apakah outlet manager hanya melihat outlet sendiri?	Ya	Ya
RBAC	Policy	Apakah salary hanya bisa dilihat HR?	Ya	Ya
Audit	Activity Log	Action apa saja yang wajib audit log?	employee update, salary update	employee update, salary update
Audit	Activity Log	Apakah payroll update wajib audit log?	Ya	Ya
System	Notification	Apakah notification system diperlukan di V1?	Tidak	Tidak
System	Queue	Apakah PDF generation menggunakan queue?	Tidak dulu	Tidak dulu
System	Backup	Apakah backup database otomatis diperlukan?	Ya	Ya
Deployment	Infrastructure	Apakah deployment menggunakan VPS Ubuntu?	Ya	Ya
Deployment	Infrastructure	Apakah menggunakan Redis?	Tidak	Tidak
Deployment	Infrastructure	Apakah menggunakan Supervisor?	Tidak dulu	Tidak dulu
