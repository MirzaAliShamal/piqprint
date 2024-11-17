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
        Schema::create('user_session_photos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_session_id');
            $table->text('original_name')->nullable();
            $table->text('filename')->nullable();
            $table->text('path')->nullable();
            $table->text('url')->nullable();
            $table->text('size')->nullable();
            $table->text('mime_type')->nullable();
            $table->foreign('user_session_id')->references('id')->on('user_sessions')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_session_photos');
    }
};
