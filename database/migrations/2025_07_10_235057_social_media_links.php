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
        Schema::create('social_media_link', function (Blueprint $table) {
            $table->id();
            $table->string('name');
             $table->unsignedBigInteger('sort');
            $table->text('link');
            $table->text('image');
            $table->enum('status',['active','inactive'])->nullable()->default(null);
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
        Schema::dropIfExists('social_media_link');
    }
};
