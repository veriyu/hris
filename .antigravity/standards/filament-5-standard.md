# Filament 5 Strict Development Guide

## Purpose

Dokumen ini digunakan sebagai aturan wajib bagi AI Agent agar seluruh kode yang dihasilkan selalu mengikuti arsitektur dan dokumentasi resmi Filament 5.

Target utama:

* Laravel 13+
* PHP 8.4+
* Filament 5.x
* Livewire 3
* Tailwind CSS 4
* MySQL

Referensi utama:

* [Filament 5 Documentation](https://filamentphp.com/docs/5.x?utm_source=chatgpt.com)
* [Filament LLM Index](https://filamentphp.com/docs/llms.txt?utm_source=chatgpt.com)

---

# ABSOLUTE RULES

## Rule #1

JANGAN PERNAH menggunakan sintaks Filament 2, Filament 3, atau Filament 4.

Seluruh implementasi harus sesuai Filament 5.

Jika terdapat konflik antara pengetahuan lama dan dokumentasi Filament 5 maka:

FILAMENT 5 SELALU MENANG.

---

## Rule #2

AI wajib menganggap dokumentasi Filament 5 sebagai source of truth.

Jangan menggunakan:

* tutorial Youtube
* artikel Medium
* blog pribadi
* StackOverflow lama

jika bertentangan dengan dokumentasi resmi Filament.

---

## Rule #3

Selalu gunakan namespace terbaru yang tersedia pada Filament 5.

Jika terdapat perubahan namespace antara versi lama dan Filament 5:

gunakan namespace Filament 5.

---

# RESOURCE ARCHITECTURE

## Resource Structure

AI harus menghasilkan struktur seperti berikut:

```text
app/
└── Filament/
    └── Resources/
        └── MemberResource/
            ├── MemberResource.php
            ├── Pages/
            ├── Schemas/
            └── Tables/
```

Jangan membuat seluruh schema langsung di Resource apabila dapat dipisahkan.

---

## Resource Responsibilities

Resource hanya bertugas:

* konfigurasi resource
* registrasi page
* registrasi schema
* registrasi table
* authorization

Jangan menaruh:

* business logic
* query kompleks
* accounting calculation
* loan calculation

langsung di Resource.

Pindahkan ke:

```text
App\Services\
App\Actions\
App\Domain\
```

---

# SCHEMA RULES

## Form Schema

Gunakan:

```php
use Filament\Schemas\Schema;
```

bukan pola lama.

Contoh:

```php
public static function form(Schema $schema): Schema
{
    return MemberForm::configure($schema);
}
```

---

## Infolist Schema

Gunakan file terpisah:

```text
Schemas/
    MemberForm.php
    MemberInfolist.php
```

Jangan mencampur form dan infolist.

---

## Validation

Gunakan validasi Laravel native.

Contoh:

```php
->required()
->maxLength(255)
->unique()
```

Hindari custom validation yang tidak diperlukan.

---

# TABLE RULES

## Table Definition

Pisahkan ke:

```text
Tables/
    MembersTable.php
```

Contoh:

```php
public static function table(Table $table): Table
{
    return MembersTable::configure($table);
}
```

---

## Table Columns

Prioritas:

```php
TextColumn
IconColumn
BadgeColumn
ImageColumn
```

Gunakan format state yang jelas.

Contoh:

```php
BadgeColumn::make('status')
```

---

## Table Actions

Gunakan action bawaan Filament terlebih dahulu:

```php
ViewAction
EditAction
DeleteAction
```

Buat custom action hanya jika benar-benar diperlukan.

---

# PAGE RULES

## Default Pages

Gunakan:

```php
ListRecords
CreateRecord
EditRecord
ViewRecord
```

sesuai kebutuhan.

---

## Page Logic

Page hanya menangani:

* UI
* interaction
* notification

Business logic harus dipindahkan ke Service atau Action.

---

# RELATION MANAGER RULES

Gunakan Relation Manager untuk:

* Loan Schedules
* Loan Payments
* Savings Transactions
* Share Transactions

Jika data memiliki relasi one-to-many:

gunakan Relation Manager.

Jangan membuat halaman custom tanpa alasan kuat.

---

# QUERY RULES

## Resource Query

Gunakan:

```php
public static function getEloquentQuery(): Builder
```

untuk filter global.

Contoh:

```php
return parent::getEloquentQuery()
    ->where('is_active', true);
```

---

## Forbidden

Jangan melakukan:

```php
DB::table(...)
```

langsung di Resource.

Jangan membuat raw query di Table.

Gunakan:

```php
Model Query
Scope
Repository
Service
```

---

# NAVIGATION RULES

Selalu definisikan:

```php
protected static ?string $navigationLabel;

protected static ?string $navigationGroup;

protected static ?int $navigationSort;
```

agar sidebar konsisten.

---

# AUTHORIZATION RULES

Selalu gunakan Policy Laravel.

Contoh:

```php
viewAny
view
create
update
delete
```

Jangan membuat pengecekan role manual di setiap page.

Gunakan:

```php
spatie/laravel-permission
```

dan Policy.

---

# FORM PERFORMANCE RULES

## Select Component

Jika data besar:

gunakan

```php
->searchable()
```

dan

```php
->preload(false)
```

atau async search.

---

## Relationship

Gunakan:

```php
->relationship()
```

jika memungkinkan.

Jangan query manual untuk dropdown.

---

# FILAMENT PANEL RULES

## Multi Panel

Jika memiliki:

```text
Admin Panel
Member Panel
```

gunakan Panel terpisah.

Contoh:

```php
AdminPanelProvider
MemberPanelProvider
```

Jangan mencampur permission dalam satu panel besar.

---

# NOTIFICATION RULES

Gunakan:

```php
Notification::make()
```

untuk feedback user.

Jangan menggunakan session flash tradisional jika Filament sudah menyediakan notification.

---

# WIDGET RULES

Widget hanya digunakan untuk:

* dashboard summary
* analytics
* KPI

Jangan gunakan widget sebagai pengganti CRUD.

---

# ACTION RULES

Prioritas:

```php
Action
BulkAction
HeaderAction
```

Gunakan action bawaan sebelum membuat custom action.

---

# ACCOUNTING MODULE RULES

Untuk aplikasi accounting atau koperasi:

JANGAN menghitung:

* saldo
* bunga
* SHU
* amortisasi
* aging

langsung di Resource.

Gunakan:

```text
App\Services\Accounting\
App\Services\Loan\
App\Services\Savings\
```

---

# LOAN MODULE RULES

Perhitungan:

* pokok
* bunga
* denda
* outstanding

harus berada pada:

```text
LoanCalculationService
LoanScheduleGenerator
```

bukan di Page atau Resource.

---

# TESTING RULES

Minimal:

```text
Feature Test
Policy Test
Service Test
```

untuk setiap modul utama.

Prioritas pengujian:

1. Service
2. Policy
3. Resource

---

# AI OUTPUT RULES

Saat menghasilkan kode Filament:

AI wajib:

1. Menggunakan Filament 5 API.
2. Menggunakan struktur folder Filament 5.
3. Memisahkan Schema dan Table.
4. Memisahkan business logic ke Service.
5. Menggunakan Policy.
6. Menggunakan Livewire 3.
7. Menggunakan PHP 8.4 syntax jika memungkinkan.
8. Menghindari deprecated API.
9. Menghindari solusi Filament 3.
10. Menghasilkan kode production-ready.

---

# FORBIDDEN PATTERNS

Jangan pernah menghasilkan:

```php
Forms\Components\
```

atau sintaks lama tanpa verifikasi dokumentasi Filament 5 terbaru.

Jangan:

* menaruh query kompleks di Resource
* menaruh perhitungan bisnis di Page
* membuat helper global untuk logic bisnis
* membuat raw SQL tanpa alasan jelas

---

# FINAL CHECKLIST

Sebelum menghasilkan kode, AI wajib memeriksa:

* Apakah kode kompatibel dengan Filament 5?
* Apakah menggunakan Livewire 3?
* Apakah mengikuti struktur Resource terbaru?
* Apakah business logic berada di Service?
* Apakah authorization menggunakan Policy?
* Apakah tidak ada referensi Filament 3?
* Apakah tidak ada referensi deprecated API?

Jika salah satu jawaban "tidak", regenerasi solusi hingga sesuai standar.


# Priority:
1. standards/filament-standard.md
2. standards/coding-standard.md
3. context/*
4. memory/*
5. Internal model knowledge.