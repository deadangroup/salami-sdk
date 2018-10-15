<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImportQueueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('import_queue', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type');
            $table->string('status');

            $table->text('original_file_name');
            $table->text('original_file_path');
            $table->biginteger('total_entries')->nullable()->default(0);
            $table->biginteger('successful')->nullable()->default(0);
            $table->biginteger('failed')->nullable()->default(0);
            $table->text('failed_entries_path')->nullable();

            $table->auditable();

            $table->softDeletes();
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
        Schema::dropIfExists('import_queue');
    }
}
