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
    public function up() {
        Schema::create('returned_logs', function (Blueprint $table) {
            $table->integer('id')->autoIncrement();
            $table->longText('app_uuid');
            $table->longText('reason')->nullable();
            $table->string('admin');
            $table->string('action');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('returned_logs');
    }
};
