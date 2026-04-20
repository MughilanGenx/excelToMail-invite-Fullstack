<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mail_logs', function (Blueprint $table) {
            $table->id();
            $table->string('subject');
            $table->string('from_name');
            $table->foreignId('record_id')->nullable()->constrained('excel_column_data')->nullOnDelete();
            $table->integer('total')->default(0);
            $table->integer('sent')->default(0);
            $table->integer('failed')->default(0);
            $table->timestamps();
        });

        Schema::create('mail_log_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('log_id')->constrained('mail_logs')->cascadeOnDelete();
            $table->string('email');
            $table->string('recipient_name')->nullable();
            $table->enum('status', ['sent', 'failed']);
            $table->text('error')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mail_log_details');
        Schema::dropIfExists('mail_logs');
    }
};
