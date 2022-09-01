<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRateListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rate_lists', function (Blueprint $table) {
            $table->id();
            $table->string('quantity');
            $table->string('normal_price');
            $table->string('urgent_price');
            $table->foreignId('product_id')->constrained();
            $table->string('discount')->nullable();
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
        Schema::dropIfExists('rate_lists');
    }
}
