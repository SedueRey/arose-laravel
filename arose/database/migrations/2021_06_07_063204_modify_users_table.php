<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('school')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->string('photo')->nullable();
            $table->text('bio')->nullable();
            $table->integer('numberStudents')->default(0);
            $table->boolean('isadmin')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('school');
            $table->dropColumn('city');
            $table->dropColumn('country');
            $table->dropColumn('photo');
            $table->dropColumn('numberStudents');
            $table->dropColumn('isadmin');
        });
    }
}
