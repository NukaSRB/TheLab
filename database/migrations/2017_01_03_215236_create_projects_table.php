<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_projects', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('toggl_id')->unsigned()->index()->nullable();
            $table->integer('client_id')->unsigned()->index();
            $table->string('name')->index();
            $table->string('label');
            $table->string('color', 6);
            $table->integer('rate')->nullable();
            $table->integer('estimated_hours')->nullable();
            $table->boolean('billable_flag')->default(1)->index();
            $table->boolean('active_flag')->default(1)->index();
            $table->boolean('private_flag')->default(1)->index();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('client_id')
                  ->references('id')
                  ->on('clients')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('client_projects');
    }
}
