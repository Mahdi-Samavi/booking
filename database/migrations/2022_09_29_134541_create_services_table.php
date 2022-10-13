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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->json('title');
            $table->float('amount');
            $table->longText('description');
            $table->integer('duration')->comment('to the minute');
            $table->enum('presence_type', ['in-person', 'zoom', 'google meet']);
            $table->integer('capacity', false, true);
            $table->integer('cancel_at')->comment('to the minute');
            $table->boolean('status');
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
        Schema::dropIfExists('services');
    }
};
