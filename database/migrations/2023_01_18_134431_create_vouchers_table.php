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
    Schema::create('vouchers', function (Blueprint $table) {
      $table->id();
      $table->string("voucher_name");
      $table->integer("discount_amount");
      $table->integer("voucher_limit");
      $table->integer("expires_at");
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
    Schema::dropIfExists('vouchers');
  }
};
