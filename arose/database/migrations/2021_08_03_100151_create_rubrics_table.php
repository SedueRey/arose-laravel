<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRubricsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rubrics', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->float('points')->nullable();
            $table->timestamps();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->index(['title']);
            $table->index(['points']);
        });

        Schema::create('criteria', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();

            $table->index(['title']);

            $table->unsignedBigInteger('rubric_id');
            $table->foreign('rubric_id')->references('id')->on('rubrics');
        });

        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->float('points')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();

            $table->index(['title']);
            $table->index(['points']);

            $table->unsignedBigInteger('criterion_id');
            $table->foreign('criterion_id')->references('id')->on('criteria');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ratings');
        Schema::dropIfExists('criteria');
        Schema::dropIfExists('rubrics');
    }
}
