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
        Schema::create('excel_column_data', function (Blueprint $table) {
            $table->id();
            $table->string('column_name');   // Custom label entered by user
            $table->string('excel_column');  // Original Excel header
            $table->text('data');            // Comma-separated values e.g. a@b.com,c@d.com
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('excel_column_data');
    }
};
