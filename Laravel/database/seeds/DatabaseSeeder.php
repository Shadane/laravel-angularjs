<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
                $this->call('CityTableSeeder');
                $this->command->info('City table seeded!');
                
                $this->call('CategoryTableSeeder');
                $this->command->info('Category table seeded!');
                
                
                $this->call('AdsAuthorsTableSeeder');
                $this->command->info('Authors table seeded!');

                $this->call('AdsContainerTableSeeder');
                $this->command->info('Ads table seeded!');

//		Model::unguard();

		// $this->call('UserTableSeeder');
	}

}
