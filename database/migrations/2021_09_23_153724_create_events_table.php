<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_general_ci';
            $table->id();
            $table->foreignId('calendar_id')->constrained()->onDelete('cascade');
            $table->string('title', 42)->default('New event')->charset('utf8mb4')->collation('utf8mb4_general_ci');
            $table->string('content', 255)->nullable()->charset('utf8mb4')->collation('utf8mb4_general_ci');
            $table->enum('category', ['Arrangement', 'Reminder', 'Task'])->default('Reminder')->charset('latin1')->collation('latin1_general_ci');

            $table->dateTime("target");
            $table->boolean("system")->default(false);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('events');
    }
}
