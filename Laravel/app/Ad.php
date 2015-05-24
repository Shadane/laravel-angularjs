<?php

    namespace App;

    use Illuminate\Database\Eloquent\Model;

    class Ad extends Model
    {

        protected $table = 'ads_container';
        public $timestamps = false;
        protected $fillable = [
                'private',
                'allow_mails',
                'phone',
                'location_id',
                'category_id',
                'title',
                'description',
                'price',
                'author_id'
        ];

        public static function saveRequest($request)
        {
            if ($request->input('id'))
            {
                $ad = static::find($request->input('id'));
                $ad->fill($request->input());
                $response[ 'action' ] = 'update';
                $response[ 'message' ] = 'Объявление успешно отредактировано';
            }
            else
            {
                $ad = new static($request->input());
                $response[ 'action' ] = 'save';
                $response[ 'message' ] = 'Новое объявление сохранено';
            }


            if ($ad->save())
            {
                $response[ 'id' ] = $ad->id;
                $response[ 'status' ] = 'success';
            }
            else
            {
                $response[ 'status' ] = 'error';
                $response[ 'message' ] = 'Ошибка сохранения';
            }

            return $response;
        }

        public function delete()
        {
            if (parent::delete())
            {
                $response[ 'status' ] = 'success';
                $response[ 'message' ] = 'Объявление успешно удалено';
            }
            else
            {
                $response[ 'status' ] = 'error';
            }
            
            return $response;
        }

    }
    