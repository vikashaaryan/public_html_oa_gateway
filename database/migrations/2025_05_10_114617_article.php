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
        Schema::create('article', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedBigInteger('article_type');
            $table->date('submit_date');
            $table->date('approve_date');
            $table->date('publish_date');
            $table->text('pdf')->nullable()->default(null);
            $table->text('doi')->nullable()->default(null);
            $table->text('doi_link')->nullable()->default(null);
            $table->text('article_id');
            $table->text('copy_rights');
            $table->integer('no_author');
            $table->integer('no_contents');
            $table->unsignedBigInteger('university');
            $table->text('seo_title');
            $table->text('seo_description');
            $table->text('seo_keywords');
            $table->unsignedBigInteger('volume');
            $table->unsignedBigInteger('issue');
            $table->enum('status',['active','inactive'])->nullable()->default(null);
            $table->foreign('article_type')->references('id')->on('article_type');
            $table->foreign('subject')->references('id')->on('subject');
            $table->foreign('university')->references('id')->on('university');
            $table->foreign('volume')->references('id')->on('volume');
            $table->foreign('issue')->references('id')->on('issue');
            $table->foreign('topic')->references('id')->on('topic');
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
        Schema::dropIfExists('article');
    }
};
