<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Http\Trait\ApiResponseTrait;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'category_id'=>'integer',
            'user_id'=>'integer',
        ]);
        $query=Post::query();
        if($request->category_id ){
            $query->where('category_id',$request->category_id);
        }
        if($request->user_id ){
            $query->where('user_id',$request->user_id);
        }
        $posts=$query->get();
        return $this->apiResponse(PostResource::collection($posts),'all posts',200);
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        $request->validated();

        $post=new Post();
        $post->title=$request->title;
        $post->body=$request->body;
        $post->category_id=$request->category_id;
        $post->user_id=$request->user_id;
        $post->save();
        
        return $this->apiResponse ($post,'you added post successfully',200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return $this->apiResponse(new PostResource($post),'this is your request',200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $request->validated();
        $post->title=$request->title??$post->title;
        $post->body=$request->body??$post->body;
        $post->category_id=$request->category_id??$post->category_id;
        $post->user_id=$request->user_id??$post->user_id;

        $post->save();
        return $this->apiResponse(new PostResource($post),'you updated post successfully',200);


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return $this->apiDelete('you deleted successfully',200);

    }
}
