<?php
use Illuminate\Database\Seeder;

class AdsAuthorsTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
                    DB::table('ads_authors')->insert(array(['seller_name'=>'Александр', 'email'=>'atguard@mail.ru'],
                                                               ['seller_name'=>'Олег', 'email'=>'oleg82@gmail.com'],
                                                           ['seller_name'=>'Михаил', 'email'=>'stepanov@yandex.ru']));
                       
	}

}
