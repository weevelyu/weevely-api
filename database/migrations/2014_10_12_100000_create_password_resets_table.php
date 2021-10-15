<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePasswordResetsTable extends Migration
{
    public function up()
    {
        Schema::create('password_resets', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_general_ci';
            $table->id();
            $table->string('email')->index()->charset('utf8mb4')->collation('utf8mb4_general_ci');
            $table->string('token')->charset('utf8mb4')->collation('utf8mb4_general_ci');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('password_resets');
    }
}
