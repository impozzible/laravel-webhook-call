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
        Schema::create('webhook_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('webhook_id');
            $table->unsignedBigInteger('webhook_event_id')
                ->nullable();
            // add column for a nullable polymorphic relationship
            $table->nullableMorphs('entity');
            $table->json('payload');
            $table->string('event_name');
            $table->unsignedSmallInteger('attempt')
                ->default(1);
            $table->string('http_verb', 6);
            $table->unsignedSmallInteger('http_code')
                ->nullable();
            $table->text('response_body')
                ->nullable();
            $table->timestamps();

            $table->foreign('webhook_id')->references('id')->on('webhooks');
            $table->foreign('webhook_event_id')->references('id')->on('webhook_events');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('webhook_logs');
    }
};
