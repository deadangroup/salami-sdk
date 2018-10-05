<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification_settings', function (Blueprint $table) {
            $table->increments('id');

            $table->string('facebook_id')->nullable(true);

            $table->boolean('facebook_enabled')->nullable(true)->default(false);

            $table->string('twitter_username')->nullable(true);

            $table->boolean('twitter_enabled')->nullable(true)->default(false);

            $table->string('webhook_url')->nullable(true);

            $table->boolean('webhook_enabled')->nullable(true)->default(false);

            $table->string('slack_url')->nullable(true);

            $table->string('slack_channel')->nullable(true);

            $table->boolean('slack_enabled')->nullable(true)->default(false);

            $table->integer('user_id')->unsigned()->nullable();

            $table->auditable();



            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            /**
             * Foreignkeys section
             */

            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notification_settings');
    }
}
