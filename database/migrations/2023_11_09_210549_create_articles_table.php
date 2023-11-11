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
        Schema::create('articles', function (Blueprint $table) {

            $table->id();

            //unique title to store news by title and prevent duplicate store
            $table->string('title',1000)->unique();
            $table->string('author',500)->nullable();
            $table->string('source');
            $table->string('category');
            $table->string('url',500)->nullable();
            $table->string('date',30);
            $table->text('description')->nullable();

            $table->enum('state',['Active','Waiting','Deleted'])->default('Active');

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
