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
        Schema::create('games', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->string('user_id');
            $table->integer('width');
            $table->integer('height');
            $table->integer('bombs');
            $table->integer('seed');
            $table->integer('limit');
            $table->boolean('ranked')->default(true);
            $table->string('status'); //abandoned won lost running
            $table->text('state');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('finished_at')->nullable();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**cl
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
