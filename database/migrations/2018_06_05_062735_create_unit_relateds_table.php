<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUnitRelatedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unit_relateds', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('name', 55)->nullable();
            $table->string('description', 1000)->nullable();
            $table->boolean('is_active')->default(0);
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('unit_relateds');
    }
}
