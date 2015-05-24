<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
              Schema::dropIfExists('ads_container');
		Schema::create('ads_container', function(Blueprint $table)
		{
                      Schema::dropIfExists('ads_container');
                        $table->engine = 'InnoDB';
                        $table->increments('id');
			$table->boolean('private')->default(b'0');
			$table->boolean('allow_mails')->default(b'0');
			$table->char('phone', 11)->default('');
			$table->char('location_id', 6)->default('');
			$table->char('category_id', 3)->default('');
			$table->string('title', 30);
			$table->text('description')->nullable();
			$table->integer('price', false, true)->default(0);
			$table->integer('author_id')->unsigned();    
			  $table->foreign('author_id')
                                ->references('id')
                                ->on('ads_authors')
                                ->onDelete('cascade');
                        
                      

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('ads_container');
	}

}
