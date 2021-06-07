<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resources', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('filename')->nullable();
            $table->string('filepath')->nullable();
            $table->string('country')->nullable();
            $table->enum('level', ['', 'A1', 'A2', 'B1', 'B2', 'C1', 'C2'])->default('');
            $table->enum('format', ['', 'Text', 'Audio', 'Video', 'Multimedia'] )->default('');
            $table->string('type')->nullable();
            $table->string('creation')->nullable();
            $table->text('description')->nullable();

            $table->index(['filename']);
            $table->index(['level']);
            $table->index(['format']);
            $table->index(['type']);
            $table->index(['country']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resources');
    }
}
