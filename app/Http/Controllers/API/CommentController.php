<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Http\Resources\CommentResource;
use App\Http\Trait\ApiResponseTrait;
use App\Models\Comment;
use App\Models\r;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    use ApiResponseTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'post_id'=>'integer',
            'user_id'=>'integer',
        ]);
        $query=Comment::query();
        if($request->post_id ){
            $query->where('post_id',$request->post_id);
        }
        if($request->user_id ){
            $query->where('user_id',$request->user_id);
        }
        $posts=$query->get();
        return $this->apiResponse(CommentResource::collection($posts),'all posts',200);
        
    }

    /**
     * Show the form for creating a new resource.
     */
 
    /**
     * Store a newly created resource in storage.
     */
    public function store(CommentRequest $request,Comment $comment)
    {
        $request->validated();
        $comment=new Comment();
        $comment->post_id=$request->post_id;
        $comment->user_id=$request->user_id;
        $comment->content=$request->content;
        $comment->save();

        return $this->apiResponse(new CommentResource($comment),'you updated comment successfully',200);

    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        return $this->apiResponse(new CommentResource($comment),'this is your request',200);
    }

    /**
     * Show the form for editing the specified resource.
     */
  

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        $request->validated();
        $comment->post_id=$request->title??$comment->post_id;
        $comment->user_id=$request->user_id??$comment->user_id;
        $comment->content=$request->content??$comment->content;
       
        $comment->save();
        return $this->apiResponse(new CommentResource($comment),'you updated comment successfully',200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
        return $this->apiDelete('you deleted successfully',200);
    }
}
