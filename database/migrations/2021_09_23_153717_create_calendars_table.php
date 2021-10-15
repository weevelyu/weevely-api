<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCalendarsTable extends Migration
{
    public function up()
    {
        Schema::create('calendars', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_general_ci';
            $table->id();
            $table->string('title', 16)->default("New calendar")->charset('utf8mb4')->collation('utf8mb4_general_ci');
            $table->boolean('main')->default(false);
            $table->boolean('hidden')->default(false);
            $table->boolean('shared')->default(false);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('calendars');
    }
}
