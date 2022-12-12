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
        Schema::create('webhook_webhook_events', function (Blueprint $table) {
            $table->id();

            // The ID of the webhook endpoint.
            $table->unsignedBigInteger('webhook_id');

            // The ID of the webhook event.
            $table->unsignedBigInteger('webhook_event_id');

            // A foreign key constraint on the webhook_id column.
            $table->foreign('webhook_id')
                ->references('id')
                ->on('webhook_endpoints');

            // A foreign key constraint on the webhook_event_id column.
            $table->foreign('webhook_event_id')
                ->references('id')
                ->on('webhook_events');

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
        Schema::dropIfExists('webhook_webhook_events');
    }
};
