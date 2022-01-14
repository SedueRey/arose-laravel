<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PublicRubricsMigrations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rubrics', function (Blueprint $table) {
            $table->boolean('public')->default(false);
            $table->float('maxpoints')->nullable();
            $table->float('passpoints')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rubrics', function (Blueprint $table) {
            $table->dropColumn('public');
            $table->dropColumn('maxpoints');
            $table->dropColumn('passpoints');
        });
    }
}
