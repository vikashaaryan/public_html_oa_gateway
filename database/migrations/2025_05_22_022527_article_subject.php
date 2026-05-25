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
        Schema::create('article_subject', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('article');
            $table->unsignedBigInteger('subject');
            $table->foreign('article')->references('id')->on('article');
            $table->foreign('subject')->references('id')->on('subject');
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
        Schema::dropIfExists('article_subject');
    }
};
