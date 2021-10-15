<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCalendarUserTable extends Migration
{
    public function up()
    {
        Schema::create('calendar_user', function (Blueprint $table) {
            $table->foreignId('calendar_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->boolean('is_owner')->default(false);
        });
    }

    public function down()
    {
        Schema::dropIfExists('calendar_user');
    }
}
