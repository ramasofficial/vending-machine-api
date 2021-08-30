<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendingMachineProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vending_machine_products', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('vending_machine_id');

            $table->string('name', 255);

            $table->unsignedSmallInteger('price_in_pences')->default(0);

            $table->timestamps();

            $table->foreign('vending_machine_id')->references('id')->on('vending_machines');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vending_machine_products');
    }
}
