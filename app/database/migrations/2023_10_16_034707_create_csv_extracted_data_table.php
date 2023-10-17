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
        Schema::create('csv_extracted_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('upload_file_id');
            $table->string('UNIQUE_KEY')->unique();
            $table->string('PRODUCT_TITLE');
            $table->text('PRODUCT_DESCRIPTION');
            $table->string('STYLE#');
            $table->string('SANMAR_MAINFRAME_COLOR');
            $table->string('SIZE');
            $table->string('COLOR_NAME');
            $table->decimal('PIECE_PRICE', 10,2);
    
            $table->foreign('upload_file_id')->references('id')->on('upload_files');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('csv_extracted_data');
    }
};
