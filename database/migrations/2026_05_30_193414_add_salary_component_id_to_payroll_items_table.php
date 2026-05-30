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
        Schema::table('payroll_items', function (Blueprint $table) {
            $table->foreignId('salary_component_id')->nullable()->after('payroll_id')->constrained()->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('payroll_items', function (Blueprint $table) {
            $table->dropForeign(['salary_component_id']);
            $table->dropColumn('salary_component_id');
        });
    }
};
