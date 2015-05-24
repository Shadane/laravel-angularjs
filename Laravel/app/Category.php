<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {

	protected $table = 'categories';
        public $timestamps = false;
        protected $fillable = [
                'cat_id',
                'category',
                'parent_id'
        ];

        public function optgroups()
        {
            return $this->hasOne('App\Category', 'cat_id', 'parent_id');
        }
}
