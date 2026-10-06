<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
    
            $table->foreignId('department_id')->constrained()->cascadeOnDelete();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
    
            $table->string('priority')->default('medium');
            $table->string('status')->default('pending');
    
            $table->string('address')->nullable();
            $table->string('neighborhood')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
    
            $table->dateTime('due_date')->nullable();
            $table->string('cancel_reason')->nullable();
    
            $table->timestamps();
            $table->softDeletes();
        });
    }

    
    public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropConstrainedForeignId('department_id');
        $table->dropColumn(['role', 'is_active', 'deleted_at']);
    });
}
};
