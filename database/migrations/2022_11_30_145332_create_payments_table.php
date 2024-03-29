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
    Schema::create('payments', function (Blueprint $table) {
      $table->string('id')->primary();
      $table->string('invoice', '10')->nullable();
      $table->unsignedBigInteger('room_no');
      $table->unsignedBigInteger('user_id');
      $table->string('transaction_id', '255')->nullable();
      $table->string('va_number');
      $table->string('amount');
      $table->string('status');
      $table->integer('booked_at');
      $table->integer('booked_until')->nullable();
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
    Schema::dropIfExists('payments');
  }
};
