<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateSkillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skills', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('skills');

        //DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        //    Schema::dropIfExists();
        //DB::statement('SET FOREIGN_KEY_CHECKS = 1');

        //Schema::disableForeignKeyConstraints();
        //    Schema::dropIfExists();
        //Schema::enableForeignKeyConstraints();

    }
}
