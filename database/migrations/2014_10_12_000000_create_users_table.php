<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('user_type')->nullable();
            $table->string('full_name')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('phone_number')->unique()->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->boolean('activated')->default(false);
            $table->boolean('preferred')->default(false);
            $table->string('token');
            $table->ipAddress('signup_ip_address')->nullable();
            $table->ipAddress('signup_confirmation_ip_address')->nullable();
            $table->ipAddress('signup_sm_ip_address')->nullable();
            $table->ipAddress('admin_ip_address')->nullable();
            $table->ipAddress('updated_ip_address')->nullable();
            $table->ipAddress('deleted_ip_address')->nullable();
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
        Schema::dropIfExists('users');
    }
}