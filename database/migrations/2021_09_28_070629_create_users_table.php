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
            $table->string('name');
            $table->string('username')->unique();
            $table->string('password');
            $table->string('phone_number')->unique();
            $table->string('email')->unique();
            $table->string('api_roles')->default(Constants::USER);
            $table->string('menu_roles')->default(Constants::USER);
            $table->string('status')->nullable();
            $table->bigInteger('company_id');
            $table->bigInteger('branch_id')->nullable();
            $table->bigInteger('employee_id')->nullable();
            $table->string('coordinate')->nullable();
            $table->string('fcm_token')->nullable();
            $table->string('avatar')->nullable();
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
