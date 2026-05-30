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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Employee::class)->constrained()->cascadeOnDelete();
            $table->date('date');
            $table->dateTime('check_in');
            $table->dateTime('check_out')->nullable();
            $table->string('status')->default('Present');
            $table->text('notes')->nullable();
            $table->timestamps();
            
            // Prevent duplicate attendance for same employee on same date
            $table->unique(['employee_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
