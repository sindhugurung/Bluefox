<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
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
            $table->integer('range_from')->unsigned();
            $table->integer('range_to')->unsigned();
            $table->string('i_normal');
            $table->string('i_urgent');
            $table->string('c_normal');
            $table->string('c_urgent');
            //  $table->unsignedBigInteger('product_id')->nullable();
            // $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
              $table->foreignId('product_id')->constrained();
             $table->string('i_discount');
             $table->string('c_discount');
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
        Schema::dropIfExists('individual_rate_lists');
    }
};
