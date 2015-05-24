<?php

use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
            
                DB::unprepared(File::get('database/seeds/categories.sql'));
                       
	}

}