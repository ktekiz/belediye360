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
    Schema::table('tasks', function (Blueprint $table) {
        $table->foreignId('category_id')->nullable()->after('department_id')->constrained('task_categories')->nullOnDelete();
        $table->string('source')->default('internal')->after('status');
        $table->string('reporter_name')->nullable()->after('source');
        $table->string('reporter_tc', 11)->nullable()->after('reporter_name');
        $table->string('reporter_phone')->nullable()->after('reporter_tc');
        $table->string('tracking_code')->nullable()->unique()->after('reporter_phone');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
{
    Schema::table('tasks', function (Blueprint $table) {
        $table->dropConstrainedForeignId('category_id');
        $table->dropColumn(['source', 'reporter_name', 'reporter_tc', 'reporter_phone', 'tracking_code']);
    });
}
};
