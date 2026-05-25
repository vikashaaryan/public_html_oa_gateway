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
        Schema::create('subject', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('slug_url');
            $table->text('description');
            $table->text('long_description');
            $table->text('meta_title');
            $table->text('meta_description');
            $table->text('meta_keywords');
            $table->Integer('article_count')->default(0);
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
        Schema::dropIfExists('subject');
    }
};
