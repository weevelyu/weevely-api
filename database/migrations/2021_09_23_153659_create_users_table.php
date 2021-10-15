<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_general_ci';
            $table->id();
            $table->string('name', 10)->unique()->charset('utf8mb4')->collation('utf8mb4_general_ci');
            $table->string('password')->charset('utf8mb4')->collation('utf8mb4_general_ci');
            $table->string('email', 64)->unique()->charset('utf8mb4')->collation('utf8mb4_general_ci');
            $table->string('image')->default('https://d3djy7pad2souj.cloudfront.net/weevely/avatar1_weevely_H265P.png');
            $table->string('shareId', 10)->unique()->charset('utf8mb4')->collation('utf8mb4_general_ci');
            $table->enum('role', ['user', 'admin'])->default('user')->charset('latin1')->collation('latin1_general_ci');

            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
