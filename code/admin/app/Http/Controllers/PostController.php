<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\PostCollection;

class PostController extends Controller
{

    private $apiClient;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

        $this->apiClient = new \GuzzleHttp\Client([
            'base_uri' => 'http://web',

        ]);
    }

    public function index(Request $request) 
    {

        $response = $this->apiClient->get('/app/api/posts');
        $data = json_decode($response->getBody()->getContents(), true);

        // $posts = new PostCollection($data);
        // dd($data);
        return view('home', ['posts' => $data]);
    }

    public function store(Request $request)
    {
        // $post = $request->isMethod('put') ?
        //     Post::findOrfail($request->id) : new Post;

        try {
            $auth_token = 'Bearer ' . $request->session()->get("auth_token");

            $headers =  [
                'Authorization' => $auth_token,
                'Accept' => 'application/json'
            ];

            $image_path = $request->file('image')->getPathname();
            $image_mime = $request->file('image')->getmimeType();
            $image_org  = $request->file('image')->getClientOriginalName();

            $params = [
                'headers' => $headers,
                'query' => [
                    'title' => $request->input('title'),
                    'body' => $request->input('body'),
                    'published' => $request->input('published'),
                    'author_id' => $request->input('author_id')
                ],
                'multipart' => [
                    [
                        'name' => 'image',
                        'filename' => $image_org,
                        'Mime-Type' => $image_mime,
                        'contents' => file_get_contents($image_path)
                    ]
                ]
            ];

            $this->apiClient->post('/app/api/post', $params);
            
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            dd($e->getResponse()->getBody()->getContents());
        }
        
        // return redirect()->action('PostController@index');
        return redirect('/admin');
    }

    public function delete(Request $request)
    {
        try {
            $auth_token = 'Bearer ' . $request->session()->get("auth_token");

            $id = $request->input('id');

            $params =  [
                'headers' => [
                    'Authorization' => $auth_token,
                    'Accept' => 'application/json'
                ]
            ];

            $this->apiClient->delete('/app/api/post/' . $id, $params);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            //throw $th;
        }

        return redirect('/admin');
    }

    public function show($id) 
    {
        try {
            $response = $this->apiClient->get("/app/api/post/{$id}");

            return $response->getBody()->getContents();
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            
            return [
                'error' => $e->getMessage()
            ];
        }
    }
}
