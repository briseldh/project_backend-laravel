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
        Schema::create('post_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('post_id')->comment('Foreign key to the posts table');
            $table->string('path', 255)->comment('The path to the image');
            $table->string('alt_text', 64)->comment('Image alt text');
            $table->timestamp('uploaded_at')->comment('The time when the image got uploaded');

            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
            $table->index('post_id');

            $table->comment('The table of all images of all posts.');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_images');
    }
};
