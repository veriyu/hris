# Filament 3 Strict Development Guide

## Purpose

Dokumen ini berisi aturan wajib bagi AI Agent agar seluruh kode yang dihasilkan konsisten dengan codebase yang menggunakan Filament 3.x.

Target stack:

* Laravel 10 / 11
* PHP 8.2+
* Filament 3.x
* Livewire 3
* Tailwind CSS 3
* MySQL

Referensi utama:

* https://filamentphp.com/docs/3.x
* https://filamentphp.com/docs/llms.txt

---

# ABSOLUTE RULES

## Rule #1

Selalu asumsikan project menggunakan Filament 3.x.

Jangan pernah menghasilkan sintaks Filament 2.x atau Filament 5.x kecuali diminta secara eksplisit.

Jika terdapat konflik antara pengetahuan internal AI dan dokumentasi Filament 3, maka dokumentasi Filament 3 adalah source of truth.

---

## Rule #2

Jangan menggunakan fitur atau namespace yang hanya tersedia pada Filament 4 atau Filament 5.

Contoh yang dilarang:

* `Filament\Schemas\Schema`
* folder `Schemas/`
* folder `Tables/`
* pola `Form::configure()`
* pola `Table::configure()`

Semua struktur harus mengikuti Filament 3.

---

## Rule #3

AI wajib memahami bahwa pada Filament 3, form dan table secara default didefinisikan langsung di dalam class Resource.

---

# RESOURCE ARCHITECTURE

## Resource Structure

Struktur standar Filament 3:

```text
app/
└── Filament/
    └── Resources/
        ├── MemberResource.php
        └── MemberResource/
            ├── Pages/
            └── RelationManagers/
```

Jangan membuat folder `Schemas` dan `Tables` seperti Filament 5, kecuali project memang sudah melakukan custom architecture sendiri.

---

## Resource Responsibilities

Resource bertanggung jawab untuk:

* konfigurasi form
* konfigurasi table
* konfigurasi navigation
* registrasi page
* registrasi relation manager

Namun business logic tetap tidak boleh ditempatkan di Resource.

Gunakan:

```text
App\Services\
App\Actions\
App\Domain\
```

untuk perhitungan dan proses bisnis.

---

# FORM RULES

## Form Definition

Gunakan method bawaan Filament 3:

```php
public static function form(Form $form): Form
{
    return $form
        ->schema([
            //
        ]);
}
```

Gunakan import:

```php
use Filament\Forms\Form;
```

Jangan menggunakan:

```php
use Filament\Schemas\Schema;
```

karena itu bukan pola Filament 3.

---

## Form Components

Gunakan komponen bawaan Filament:

```php
TextInput
Textarea
Select
DatePicker
DateTimePicker
Toggle
ToggleButtons
Repeater
Section
Grid
Fieldset
Placeholder
Hidden
```

Selalu manfaatkan chaining API Filament sebelum membuat komponen custom.

---

## Relationship Select

Prioritaskan:

```php
Select::make('member_id')
    ->relationship('member', 'name')
    ->searchable()
    ->preload();
```

Jangan query manual menggunakan `options(Model::pluck())` jika relationship dapat digunakan.

---

# TABLE RULES

## Table Definition

Gunakan method standar:

```php
public static function table(Table $table): Table
{
    return $table
        ->columns([
            //
        ])
        ->filters([
            //
        ])
        ->actions([
            //
        ])
        ->bulkActions([
            //
        ]);
}
```

---

## Table Columns

Prioritas penggunaan:

* TextColumn
* BadgeColumn
* IconColumn
* ImageColumn
* ToggleColumn

Gunakan formatter Filament daripada accessor tambahan jika memungkinkan.

Contoh:

```php
TextColumn::make('amount')
    ->money('IDR');
```

---

## Table Filters

Gunakan Filter bawaan Filament sebelum membuat query manual.

Contoh:

* SelectFilter
* TernaryFilter
* Filter::make()

---

## Table Actions

Prioritaskan action bawaan:

```php
Tables\Actions\ViewAction::make()
Tables\Actions\EditAction::make()
Tables\Actions\DeleteAction::make()
```

Untuk bulk:

```php
Tables\Actions\DeleteBulkAction::make()
```

Jangan membuat custom action jika action bawaan sudah memenuhi kebutuhan.

---

# PAGE RULES

## Default Pages

Gunakan page bawaan Filament:

* ListRecords
* CreateRecord
* EditRecord
* ViewRecord

Registrasikan melalui:

```php
public static function getPages(): array
{
    return [
        'index' => Pages\ListMembers::route('/'),
        'create' => Pages\CreateMember::route('/create'),
        'view' => Pages\ViewMember::route('/{record}'),
        'edit' => Pages\EditMember::route('/{record}/edit'),
    ];
}
```

---

## Custom Pages

Gunakan Custom Page hanya bila fitur tidak dapat direpresentasikan sebagai Resource atau Relation Manager.

Jangan membuat dashboard khusus atau wizard panjang sebagai custom page tanpa alasan arsitektural yang jelas.

---

# RELATION MANAGER RULES

Data dengan relasi one-to-many atau many-to-many wajib dipertimbangkan menggunakan Relation Manager.

Contoh:

* Loan Payments
* Loan Schedules
* Member Savings
* Transaction Lines

Gunakan folder:

```text
MemberResource/
└── RelationManagers/
```

Jangan membuat CRUD terpisah jika relasi lebih cocok dikelola melalui Relation Manager.

---

# QUERY RULES

## Resource Query

Gunakan:

```php
public static function getEloquentQuery(): Builder
{
    return parent::getEloquentQuery();
}
```

untuk global filtering.

Contoh:

```php
return parent::getEloquentQuery()
    ->where('is_active', true);
```

---

## Forbidden Query Pattern

Jangan melakukan:

```php
DB::table(...)
```

langsung di Resource.

Jangan meletakkan raw SQL di:

* form()
* table()
* RelationManager

Gunakan:

* Eloquent Model
* Scope
* Service
* Repository

---

# NAVIGATION RULES

Selalu definisikan:

```php
protected static ?string $navigationIcon;
protected static ?string $navigationLabel;
protected static ?string $navigationGroup;
protected static ?int $navigationSort;
```

Gunakan grouping yang konsisten.

Contoh:

* Master Data
* Keanggotaan
* Simpanan
* Pinjaman
* Accounting
* Laporan
* Sistem

---

# AUTHORIZATION RULES

Gunakan Laravel Policy.

Implementasikan minimal:

* viewAny()
* view()
* create()
* update()
* delete()

Integrasikan dengan:

```text
spatie/laravel-permission
```

Jangan melakukan pengecekan role seperti:

```php
if (auth()->user()->role == 'admin')
```

di dalam Resource atau Page.

---

# PANEL RULES

Jika project menggunakan multi-panel:

```text
Admin Panel
Member Panel
```

gunakan Panel Provider terpisah.

Jangan menggabungkan seluruh role menjadi satu panel dan menyembunyikan menu menggunakan kondisi.

---

# NOTIFICATION RULES

Gunakan:

```php
Notification::make()
    ->title('...')
    ->success()
    ->send();
```

Jangan menggunakan session flash Laravel tradisional jika dapat digantikan oleh Notification Filament.

---

# WIDGET RULES

Widget hanya digunakan untuk:

* dashboard summary
* chart
* KPI
* statistik

Jangan menggunakan Widget untuk menggantikan Resource CRUD.

---

# ACCOUNTING & COOPERATIVE MODULE RULES

Untuk aplikasi accounting, koperasi, atau HRMS:

Business logic berikut tidak boleh berada di Resource:

* perhitungan bunga
* saldo simpanan
* SHU
* jurnal otomatis
* loan schedule generation
* cash flow calculation

Seluruh logika tersebut harus berada pada:

```text
App\Services\
App\Domain\
App\Actions\
```

---

# PERFORMANCE RULES

## Select Input

Untuk data besar:

Gunakan:

```php
->searchable()
->preload()
```

secara bijak.

Hindari preload pada tabel master dengan puluhan ribu data.

---

## N+1 Query

Gunakan eager loading melalui:

```php
protected function getTableQuery(): Builder
{
    return parent::getTableQuery()
        ->with([
            'member',
            'loanType',
        ]);
}
```

jika diperlukan.

---

# TESTING RULES

Minimal pengujian untuk setiap modul:

* Feature Test
* Policy Test
* Service Test

Prioritas pengujian:

1. Business Service.
2. Authorization Policy.
3. Resource interaction.

---

# AI OUTPUT RULES

Setiap kali AI menghasilkan kode Filament 3:

AI wajib memastikan:

1. Menggunakan API Filament 3.
2. Menggunakan Livewire 3.
3. Tidak menggunakan struktur Filament 5.
4. Business logic berada di Service.
5. Authorization menggunakan Policy.
6. Memanfaatkan Relation Manager jika relevan.
7. Menghindari raw SQL di Resource.
8. Menghasilkan kode production-ready.

---

# FORBIDDEN PATTERNS

Jangan pernah menghasilkan struktur berikut untuk project Filament 3:

```text
Resources/
└── CustomerResource/
    ├── Schemas/
    └── Tables/
```

Jangan menggunakan:

```php
use Filament\Schemas\Schema;

public static function form(Schema $schema): Schema
{
    ...
}
```

karena itu adalah pola Filament generasi baru.

Jangan menaruh:

* query kompleks,
* perhitungan bisnis,
* logika accounting,
* generator angsuran,

langsung di Resource atau Page.

---

# FINAL CHECKLIST

Sebelum menghasilkan kode, AI harus memverifikasi:

* Apakah kode sesuai Filament 3?
* Apakah menggunakan Livewire 3?
* Apakah menggunakan `Form $form` dan `Table $table`?
* Apakah tidak menggunakan folder `Schemas` dan `Tables`?
* Apakah business logic dipindahkan ke Service?
* Apakah authorization menggunakan Policy?
* Apakah tidak ada sintaks khusus Filament 5?

Jika salah satu jawaban adalah "tidak", maka solusi harus diperbaiki sebelum ditampilkan.


# Priority:
1. standards/filament-standard.md
2. standards/coding-standard.md
3. context/*
4. memory/*
5. Internal model knowledge.