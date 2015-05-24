<?php

use Illuminate\Database\Seeder;

class AdsContainerTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
            DB::table('ads_container')->insert(array(['private'=>'0', 'phone' => '89132088539', 'location_id' =>'641780', 'category_id' => '51', 'title'=> 'Кеды Фирменные продам', 'description'=> 'Рекомендую, сам носил три года!', 'price'=>'12', 'author_id'=> 1],
                                                        ['private'=>'1', 'phone' => '79135553343', 'location_id' =>'641780', 'category_id' => '27', 'title'=> 'Домик в Англии', 'description'=> 'Наша компания предоставляет широкий спектр услуг.', 'price'=>'120000', 'author_id'=> 3],
                                                           ['private'=>'0', 'phone' => '3327879', 'location_id' =>'641760', 'category_id' => '41', 'title'=> 'Счищаю снег с крыш', 'description'=> 'Лестница всегда при себе.', 'price'=>'80', 'author_id'=> 2]));
                
                       
	}

}
