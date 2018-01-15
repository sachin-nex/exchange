<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id',11);
            $table->string('customer_id',10);
            $table->string('first_name',45);
            $table->string('last_name',45);
            $table->string('mobile',15)->unique();
            $table->string('dial_code',6);
            $table->string('email',155)->unique();
            $table->string('password',155);
            $table->string('country',52);
            $table->string('referal_code',52);
            $table->tinyInteger('profile')->nullable()->unsigned();
            $table->tinyInteger('aml')->nullable()->unsigned();
            $table->tinyInteger('agreement')->nullable()->unsigned();
            $table->tinyInteger('email_verified')->nullable()->unsigned();
            $table->tinyInteger('mobile_verified')->nullable()->unsigned();
            $table->tinyInteger('status')->nullable()->unsigned();
            $table->tinyInteger('terms_conditions')->nullable()->unsigned();
            $table->string('token',155);
            $table->string('remember_token',155);
            $table->string('google_auth_code',155);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->tinyInteger('auth_enabled')->nullable()->unsigned();
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
