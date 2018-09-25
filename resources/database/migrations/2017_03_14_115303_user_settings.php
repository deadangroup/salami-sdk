<?php

/**
 * This file is part of the Deadan Group Software Stack
 *
 * (c) James Ngugi <james@deadangroup.com>
 *
 * <code> Build something people want </code>
 *
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UserSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('user_settings', function (Blueprint $table) {

            $table->increments('id');
            $table->text('payment_settings');
            $table->text('invoice_settings');
            $table->text('active_payment_options');

            $table->integer('user_id')->unsigned()->nullable(true);

            $table->auditable();
            $table->deletable();
            $table->device();

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
     * @return  void
     */
    public function down()
    {
        Schema::dropIfExists('user_settings');
    }
}
