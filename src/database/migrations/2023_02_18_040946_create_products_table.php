<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('merchant_id');
            $table->text('description')->nullable();
            $table->double('price');
            $table->string('unit_type');
            $table->integer('quantity');
            $table->unsignedBigInteger('discount_id')->nullable();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('province_id');
            $table->tinyInteger('status')->default(0)->comment('0: pending, 1: success, -1: declined');
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
        Schema::dropIfExists('products');
    }
}
