<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthors extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
              Schema::dropIfExists('ads_authors');
		Schema::create('ads_authors', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';
                        $table->increments('id');
                        $table->string('seller_name', 50);
                        $table->string('email')->unique();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('ads_authors');
	}

}
