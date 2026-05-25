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
        Schema::create('author', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('slug_url');
            $table->text('image');
            $table->string('email')->unique();
            $table->enum('status',['active','inactive'])->nullable()->default(null);
            $table->unsignedBigInteger('location_id');
            $table->unsignedBigInteger('university_id');
            $table->unsignedBigInteger('job_id');
            $table->text('about');
            $table->unsignedBigInteger('sort');
            $table->foreign('location_id')->references('id')->on('location');
            $table->foreign('university_id')->references('id')->on('university');
            $table->foreign('job_id')->references('id')->on('job');
            $table->softdeletes();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('author');
    }
};
