<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('toggl_id')->unsigned()->index();
            $table->integer('project_id')->unsigned()->index();
            $table->string('name')->index();
            $table->string('label');
            $table->integer('estimated_seconds')->nullable();
            $table->boolean('active_flag')->default(1)->index();
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
        Schema::dropIfExists('client_tasks');
    }
}
