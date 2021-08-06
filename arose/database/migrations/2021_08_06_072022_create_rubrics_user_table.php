<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRubricsUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usedrubrics', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->enum('level', ['A1', 'A2', 'B1', 'B2', 'C1', 'C2'])->nullable();

            $table->unsignedBigInteger('rubric_id');
            $table->unsignedBigInteger('user_id');

            $table->foreign('rubric_id')->references('id')->on('rubrics');
            $table->foreign('user_id')->references('id')->on('users');

            $table->unique(['level', 'user_id', 'rubric_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usedrubrics');
    }
}
