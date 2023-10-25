<?php

use App\Utils\Constants;
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
            $table->bigInteger('id');
            $table->string('name',60);
            $table->string('username',30)->unique();
            $table->string('password');
            $table->string('phone_number',15)->unique();
            $table->string('email',30)->unique();
            $table->boolean('status')->nullable();
            $table->string('avatar')->nullable();
            $table->string('created_by',50)->nullable();
            $table->string('update_by',50)->nullable();
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
