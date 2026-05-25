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
        Schema::create('issue', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('title');
            $table->date('publish_date');
            $table->text('description');
            $table->Integer('article_count')->default(0);
            $table->unsignedBigInteger('volume');
            $table->enum('status',['active','inactive'])->nullable()->default(null);
            $table->softdeletes();
            $table->foreign('volume')->references('id')->on('volume');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('issue');
    }
};
