<?php namespace App\Http\Controllers;
use App\Ad;
use App\City;
use App\Category;
use App\Author;
use App\Http\Controllers\Controller;
use App\Http\Requests\SaveFormRequest;

class AdsController extends Controller {

	public function index()
        {
            $response['cities'] = City::all();
            $response['categories'] = Category::with('optgroups')->whereNotNull('parent_id')->get();
            $response['authors'] = Author::all()->keyBy('id');
            $response['ads'] = Ad::select('id','private', 'title', 'price', 'author_id')->get()->keyBy('id');
            return $response;
        }
        
        public function store(SaveFormRequest $request)
        {
            
            $response['author'] = Author::saveRequest($request);
            
            $request->merge(['author_id' => $response['author']['id']]);
            
            $response['ad'] = Ad::saveRequest($request);
            return $response;
        }
        
        public function show($id)
        {
          $response['ad'] = Ad::findOrFail($id);
          $auId = $response['ad']->author_id;
          $response['author'] = Author::findOrFail($auId);
          return $response;

        }
        
        public function destroy($id)
        {
            $response = Ad::findOrfail($id)->delete();
            return $response;
        }

}
