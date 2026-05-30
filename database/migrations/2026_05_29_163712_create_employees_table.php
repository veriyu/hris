<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class)->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(\App\Models\Company::class)->constrained();
            $table->foreignIdFor(\App\Models\Outlet::class)->constrained();
            $table->foreignIdFor(\App\Models\Department::class)->constrained();
            $table->foreignIdFor(\App\Models\Position::class)->constrained();
            $table->foreignIdFor(\App\Models\Employee::class, 'supervisor_id')->nullable()->constrained('employees');
            
            $table->string('employee_number')->unique();
            $table->string('nik')->unique();
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('gender');
            $table->date('dob');
            $table->date('join_date');
            $table->string('status')->default('Active');
            
            $table->foreignIdFor(\App\Models\User::class, 'created_by')->nullable()->constrained('users');
            $table->foreignIdFor(\App\Models\User::class, 'updated_by')->nullable()->constrained('users');
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
