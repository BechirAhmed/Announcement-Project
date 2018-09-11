<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index();
            $table->string('slug')->nullable()->unique();
            $table->string('name', 255)->nullable();
            $table->string('description', 1000)->nullable();
            $table->string('price')->nullable();
            $table->string('discount')->nullable();
            $table->string('count')->nullable();
            $table->string('sku')->nullable()->unique();
            $table->string('color')->nullable();
            $table->boolean('preferred')->default(0);
            $table->boolean('sold')->default(0);
            $table->boolean('is_active')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('products');
    }
}
