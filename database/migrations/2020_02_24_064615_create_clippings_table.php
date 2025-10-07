<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClippingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clippings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('middle_id');
            $table->unsignedBigInteger('subject_matter_id')->nullable();
            $table->unsignedBigInteger('vehicle_id')->nullable();
            $table->unsignedBigInteger('editorial_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('classification_id')->nullable();
            $table->unsignedBigInteger('exhibition_id')->nullable();
            $table->unsignedBigInteger('source_id')->nullable();
            $table->string('title');
            $table->string('slug');
            $table->date('date');
            $table->dateTime('last_read')->nullable();
            $table->text('review')->nullable();
            $table->boolean('active')->default(1);
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('clients')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('middle_id')->references('id')->on('middles')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('subject_matter_id')->references('id')->on('subject_matters')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('vehicle_id')->references('id')->on('vehicles')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('editorial_id')->references('id')->on('editorials')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            // Non editable by user
            $table->foreign('classification_id')->references('id')->on('classifications')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('exhibition_id')->references('id')->on('exhibitions')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('source_id')->references('id')->on('sources')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clippings');
    }
}
