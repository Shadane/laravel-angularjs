<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Author extends Model {

	protected $table = 'ads_authors';
        public $timestamps = false;
        protected $fillable = [
                'seller_name',
                'email'
        ];
        
        public static function saveRequest($request)
        {
             if (!$author = static::where('email','=',$request->input('email'))->first())
            {
               $author = new Author();
               $author->email = $request->input('email');

               $response['action'] = 'save';
               $response['message'] = 'Новый автор успешно сохранен';
               
            }
             else
            {
                $response['action'] = 'update';
                $response['message'] = 'Автор обновлен';
            }
            
            $author->seller_name = $request->input('seller_name');
            if ($author->save())
            {
                $response['id'] = $author->id;
                $response['status'] = 'success';
            }
             else
            {
                 $response['status'] = 'error';
                 $response['message'] = 'Ошибка базы данных';
            }
            return $response;
            
        }
}
