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
        Schema::table('notification_records', function (Blueprint $table) {
            $table->create();
            $table->id();

            $table->text('content');
            $table->enum('status', ['sending', 'send', 'opened', 'opened-link', 'failed'])->index();
            $table->string('message_id', 512)->index();
            $table->string('channel')->index();
            $table->string('channel_detail');
            $table->text('status_detail');

            $table->timestampsTz();
        });

        Schema::table('notification_record_objects', function (Blueprint $table) {
            $table->create();
            $table->id();

            $table->unsignedBigInteger('notification_record_id')->index();
            $table->string('object_type')->index();
            $table->string('object_id')->index();

            $table->unique(['notification_record_id', 'object_type', 'object_id'], 'unq_record_obj');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_records');
        Schema::dropIfExists('notification_record_objects');
    }
};
