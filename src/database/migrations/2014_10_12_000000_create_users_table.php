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
            $table->id();
            $table->string('name',20)->nullable(false);
            $table->string('email',200)->unique()->nullable(false);
            $table->string('password',200)->nullable(false);
            $table->string('img_url',255)->nullable(false);
            $table->string('post',255)->nullable(false);
            $table->string('address',200)->nullable(false);
            $table->string('building_name' ,200)->nullable(false);
            $table->rememberToken();
            $table->timestamp('created_at')->useCurrent()->nullable(false);
            $table->timestamp('updated_at')->useCurrent()->nullable(false);
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
