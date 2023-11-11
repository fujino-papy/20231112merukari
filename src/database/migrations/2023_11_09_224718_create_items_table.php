<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('users_id')->constrained()->cascadeOnDelete()->nullable(false);
            $table->string('name', 20)->nullable(false);
            $table->foreignId('categories_id')->constrained()->cascadeOnDelete()->nullable(false);
            $table->foreignId('conditions_id')->constrained()->cascadeOnDelete()->nullable(false);
            $table->string('summary', 200)->nullable(false);
            $table->string('image_url', 200)->nullable(false);
            $table->integer('price')->nullable(false);
            $table->boolean('sold')->nullable();
            $table->timestamp('created_at')->useCurrent()->nullable();
            $table->timestamp('updated_at')->useCurrent()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
