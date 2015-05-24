<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCitiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
              Schema::dropIfExists('cities');
		Schema::create('cities', function(Blueprint $table)
		{
                        $table->engine = 'MyISAM';
                        $table->char('city_id', 6);
                        $table->string('city_name', 20);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('cities');
	}

}
