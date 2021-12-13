<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RelatedResources extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('related_resources', function (Blueprint $table) {
            $table->unsignedBigInteger('resource_id');
            $table->foreign('resource_id')->references('id')->on('resources');
            $table->unsignedBigInteger('other_resource_id');
            $table->foreign('other_resource_id')->references('id')->on('resources');
            $table->primary(['resource_id', 'other_resource_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('related_resources');
    }
}
