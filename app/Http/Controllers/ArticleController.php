<?php

namespace App\Http\Controllers;

use App\Models\Article;
use GuzzleHttp\Exception\RequestException;
use http\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    /**
     * @return View
     */
    public static function index(){
        $page_title="InnoScripta Home challenge | Ahmadreza Yousefzad";
        return view('index',[
            'page_title' => $page_title
        ]);
    }

    /**
     * @param $request
     * @return Response
     */
    public function list(Request $request){
        //update database with 100 last articles(no cron jobs :) just Keep it simple)
        //$this->updateDatabase();

        //validate user inputs
        $validator = Validator::make($request->all(), [
            'source' => ['string','in:database,bbcNews,guardians,newsapi','nullable'],
            'category' => ['string','in:business,entertainment,health,science,sports,technology,other','nullable'],
            'key' => ['string','nullable'],
            'dateFrom' => ['string','regex:/^[0-9]{4}-[0-9]{1,2}-[0-9]{1,2}$/','nullable'],
            'dateTo' => ['string','regex:/^[0-9]{4}-[0-9]{1,2}-[0-9]{1,2}$/','nullable'],
            'author' => ['string','nullable'],
            'page' => ['numeric','min:0','nullable'],
            'pageSize' => ['numeric','min:0','nullable']
        ]);

        //failed validation responcse
        if ($validator->fails()) {
            return response(
                [
                    'error' => 'wrong input data , check bellow documentation.',
                    'attributes' =>
                    [
                        'source' => ['database','bbcNews','guardians','newsapi'],
                        'category' => ['business','entertainment','health','science','sports','technology','other'],
                        'key' => '',
                        'dateFrom' => 'start date YYYY-MM-DD',
                        'dateTo' => 'end date YYYY-MM-DD',
                        'author' => '',
                        'page' => 'number > 0',
                        'pageSize' => 'number > 0'
                    ]
                ]
                ,200);
        }

        //set parameters for desired data's
        $params['source']=isset($request['source']) && $request['source']!=null?$request['source']:'database';
        $params['category']=isset($request['category']) && $request['category']!=null?$request['category']:'';
        $params['key']=isset($request['key']) && $request['key']!=null?$request['key']:'';
        $params['dateFrom']=isset($request['dateFrom']) && $request['dateFrom']!=null?$request['dateFrom']:'';
        $params['dateTo']=isset($request['dateTo']) && $request['dateTo']!=null?$request['dateTo']:'';
        $params['author']=isset($request['author']) && $request['author']!=null?$request['author']:'';
        $params['page']=isset($request['page']) && $request['page']!=null?$request['page']:1;
        $params['pageSize']=isset($request['pageSize']) && $request['pageSize']!=null?$request['pageSize']:10;

        $link=url('/API/?source=' .$params['source'] .'&category=' .$params['category'] .'&key=' .$params['key'] .'&dateFrom=' .$params['dateFrom'] .'&dateTo=' .$params['dateTo'] .'&author=' .$params['author'] .'&page=' .$params['page'] .'&pageSize=' .$params['pageSize']);

        //get data from api's or database by user request
        $data=$params['source']=='database'?$this->searchDatabase($params):$this->apiCall($params);

        //set response
        return response(
            [
                'url' => $link,
                'source' => $params['source'],
                'category' => $params['category'],
                'key' => $params['key'],
                'dateFrom' => $params['dateFrom'],
                'dateTo' => $params['dateTo'],
                'author' => $params['author'],
                'page' => $params['page'],
                'pageSize' => $params['pageSize'],
                'data' => $data,
                'state' => 200
            ]
            ,200);
    }


    /**
     * @param $params
     * @return Array
     * @throws Exception
     */
    public function apiCall($params)
    {
        /**
         * - because of Unites state's sanctions for Iranian's , Ihad no access to almost all of listed api's , so I've used all I have :)
         * - newsAPi as 2 api , one for all sources and one for bbcNews
         * - guardians as third one
         */
        try {
            //setup query_params
            $query_params='&page='.$params['page'].'&pageSize='.$params['pageSize'];
            $query_params.=$params['key']!=''?'&q='.$params['key']:'';

            //check api name
            switch ($params['source']){
                case 'bbcNews' :
                    $source_url='https://newsapi.org/v2/top-headlines?language=en&sources=bbc-news&apiKey=62e9d2d181e64b8db2c64537c1d965c2'.$query_params;
                    break;
                case 'newsapi' :
                    $query_params.=$params['category']!=''?'&category='.$params['category']:'';
                    $source_url='https://newsapi.org/v2/top-headlines?language=en&apiKey=62e9d2d181e64b8db2c64537c1d965c2'.$query_params;
                    break;
                default :
                    $query_params='&page='.$params['page'].'&page-size='.$params['pageSize'];
                    $query_params.=$params['key']!=''?'&q='.$params['key']:'';
                    $query_params.=$params['category']!=''?'&section='.$params['category']:'';
                    $source_url='https://content.guardianapis.com/search?api-key=test&show-tags=contributor'.$query_params;
            }
            //set a http call for data's (Keep it simple , no guzzle :))
            $response = Http::get($source_url);
            return json_decode($response->body());
        } catch (RequestException $e) {
            return 'connection error!';
        }
    }


    /**
     * @param Request $request
     * @return Array
     */
    public function searchDatabase($params)
    {
        //setup local var's for sql
        $key=$params['key'];
        $source=$params['source'];
        $category=$params['category'];
        $dateFrom=$params['dateFrom'];
        $dateTo=$params['dateTo'];
        $author=$params['author'];
        $pagesize=$params['pageSize'];

        // eloquent set up on Article model with query params
        $data=Article::where('state','Active')
            ->where(function ($query) use ($key) {
                $query->where('title' ,'LIKE','%'.$key.'%')
                    ->orWhere('author' ,'LIKE','%'.$key.'%')
                    ->orWhere('source' ,'LIKE','%'.$key.'%')
                    ->orWhere('category' ,'LIKE','%'.$key.'%')
                    ->orWhere('description' ,'LIKE','%'.$key.'%');
            })->where(function ($query) use ($source,$category,$dateFrom,$dateTo,$author) {
                if($source!='' && $source!='database'){$query->where('source',$source);}
                if($category!=''){$query->where('category',$category);}
                if($dateFrom!=''){$query->where('date','>=',$dateFrom);}
                if($dateTo!=''){$query->where('date','<=',$dateTo);}
                if($author!=''){$query->where('author',$author);}
            })->orderBy('created_at','DESC')
            ->paginate($pagesize);

        return $data;
    }


    /**
     * fetch new articles from api's
     **/
    public function updateDatabase(){

        /**
         * this is a two separated part function to ustore new aricles to database
         * 1 - update 50 last newsapi's articles (includes bbcNews)
         * 2 - update 50 last guardians articles
         **/

        //common params
        $params['category']='';
        $params['key']='';
        $params['page']=1;
        $params['pageSize']=50;

        //newsApi
        $params['source'] = 'newsapi';
        $data=$this->apiCall($params);
        if($data->articles) {
            foreach ($data->articles as $article) {
                if (!count(Article::where('title', $article->title)->get())) {
                    $date = explode('T', $article->publishedAt);
                    $date = str_replace(' ', '', $date[0]);
                    $source = $article->source->name == 'BBC News' ? 'bbcNews' : 'newsapi';
                    $category = $article->source->name;
                    Article::create([
                        'title' => substr($article->title,0,1000),
                        'author' => substr($article->author,0,500),
                        'source' => $source,
                        'category' => $category,
                        'url' => substr($article->url,0,500),
                        'date' => $date,
                        'description' => $article->description
                    ]);
                }
            }
        }

        //guardians api
        $params['source'] = 'guardians';
        $data=$this->apiCall($params);
        if($data->response->results) {
            foreach($data->response->results as $article){
                if(!count(Article::where('title',$article->webTitle)->get())){
                    $date=explode('T',$article->webPublicationDate);
                    $source='guardians';
                    $category=$article->sectionName;
                    $author='';
                    foreach ($article->tags as $auth){
                        $author.=$auth->webTitle . ',' ;
                    }
                    Article::create([
                        'title' => substr($article->webTitle,0,500),
                        'author' => substr($author,0,500),
                        'source' => $source,
                        'category' => substr($category,0,255),
                        'url' => substr($article->webUrl,0,255),
                        'date' => $date[0],
                        'description' => $article->webTitle
                    ]);
                }
            }
        }
    }


    /**
     * static data as api documentation
     * @return Response
     */
    public function help(){
        //this is a simple helper for api users
        return response([
                'attributes' =>
                [
                    'source' => ['database','bbcNews','guardians','newsapi'],
                    'category' => ['business','entertainment','health','science','sports','technology','other'],
                    'key' => '',
                    'dateFrom' => 'start date YYYY-MM-DD',
                    'dateTo' => 'end date YYYY-MM-DD',
                    'author' => '',
                    'page' => 'number > 0',
                    'pageSize' => 'number > 0'
                ],
                'state' => 200
            ]
            ,200);
    }

}
