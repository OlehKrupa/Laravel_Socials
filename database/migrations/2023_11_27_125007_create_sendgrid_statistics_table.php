<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sendgrid_statistics', function (Blueprint $table) {
            $table->id();
            $table->string('email')->nullable();
            $table->timestamp('timestamp')->nullable();
            $table->string('event')->nullable();
            $table->boolean('sg_machine_open')->nullable();
            $table->string('category')->nullable();
            $table->string('sg_event_id')->nullable();
            $table->string('sg_message_id')->nullable();
            $table->string('useragent')->nullable();
            $table->string('ip')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sendgrid_statistics');
    }
};
