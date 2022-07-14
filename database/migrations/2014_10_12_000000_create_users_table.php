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
            $table->string('name');
            $table->string('address');
            $table->enum('type', ['corporate','individual']);
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->string('mobile_number')->unique();
            $table->timestamp('mobile_number_verified_at')->nullable();
            $table->string('mobile_verified_code')->unique();
            $table->string('pan_number')->nullable() ->unique();
            $table->string('password');
            $table->enum('status', ['pending', 'active','inactive']);
            $table->boolean('is_admin')->default(false);
            $table->string('pan_image')->unique()->nullable();
            $table->string('cover_image')->unique()->nullable();
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
        Schema::dropIfExists('users');
    }
}
