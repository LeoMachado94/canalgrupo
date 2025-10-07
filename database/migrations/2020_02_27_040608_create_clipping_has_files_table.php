<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClippingHasFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clipping_has_files', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('clipping_id');
            $table->string('name', 128);
            $table->string('path');
            $table->string('file_type', 32)->nullable();
            $table->string('extension', 4)->nullable();
            $table->double('size', 3, 2)->nullable()->comment('kbyte');
            $table->timestamps();

            $table->foreign('clipping_id')->references('id')->on('clippings')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clipping_has_files');
    }
}
