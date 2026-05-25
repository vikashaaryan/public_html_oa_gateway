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
        Schema::create('article_content', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('article');
            $table->text('title');
            $table->text('description');
            $table->integer('content_sort');
            $table->foreign('article')->references('id')->on('article');
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
        Schema::dropIfExists('article_content');
    }
};
