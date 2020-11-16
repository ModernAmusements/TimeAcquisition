<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('type');
        });

        DB::table('categories')->insert([
            ['type' => 'OT Accrued'],
            ['type' => 'Comp Time Used'],
            ['type' => 'Vacation Time Used'],
            ['type' => 'Personal Hours Used'],
            ['type' => 'Sick Time']
      ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
