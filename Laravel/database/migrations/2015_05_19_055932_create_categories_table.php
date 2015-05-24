<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
              Schema::dropIfExists('categories');
		Schema::create('categories', function(Blueprint $table)
		{
			$table->engine = 'MyISAM';
                        $table->string('cat_id', 3)->primary();
                        $table->string('category', 30);
                        $table->tinyInteger('parent_id')->nullable();
		});
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
