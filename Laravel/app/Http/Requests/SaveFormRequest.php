<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class SaveFormRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
        public function rules()
        {
            return [
                    'seller_name' => 'required',
                    'email' => 'required|email',
                    'title' => 'required|max:30',
                    'private' => 'boolean',
                    'allow_mails'=> 'boolean',
                    'phone'=> 'alpha_num:max:11',
                    'location_id'=> 'alpha_num|size:6',
                    'category_id'=> 'alpha_num|max:3',
                    'description'=> 'max:500',
                    'price'=> 'integer|min:0|max:999999',
                    'id'=>'integer'
            ];
        }

    }
    