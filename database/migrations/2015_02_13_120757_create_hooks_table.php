<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateHooksTable extends Migration
{

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('hooks', function (Blueprint $table) {
      $table->increments('id');
      $table->string('event_name', 100);
      //you can separate the sender, repo...etc. but let's just keep it simple
      $table->text('payload');
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
    Schema::drop('hooks');
  }

}
