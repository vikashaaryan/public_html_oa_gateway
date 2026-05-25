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
        Schema::create('footer_link', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('footer_category');
            $table->text('footer_link')->nullable()->default(null);
            $table->unsignedBigInteger('sort');
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
        Schema::dropIfExists('footer_link');
    }
};
