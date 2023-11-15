<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function Laravel\Prompts\table;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger('user_id')->comment('Foreign key to the users table');
            $table->unsignedBigInteger('post_id')->comment('Foreign key to the posts table');
            $table->string('text', 1000)->comment('The comment text');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->index('user_id');
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
            $table->index('post_id');

            $table->comment('All existing comments table');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
