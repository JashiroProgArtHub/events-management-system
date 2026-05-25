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
        Schema::create('events', function (Blueprint $table) {
            $table->id('event_id');
            $table->unsignedBigInteger('admin_id');
            $table->string('title');
            $table->longText('description');
            $table->string('venue');
            $table->dateTime('event_date');
            $table->enum('status', ['upcoming', 'ongoing', 'done'])->default('upcoming');
            $table->timestamps();
            $table->softDeletes(); // Soft delete support

            // Foreign keys
            $table->foreign('admin_id')->references('admin_id')->on('admins')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
