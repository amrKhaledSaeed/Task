<?php

namespace App\Http\Controllers\Api\V1;

use App\helpers;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Http\Resources\GeneralCollection;
use App\Http\RepositoryInterface\PostInterface;

class PostController extends Controller
{
    private $postInterface;
    public function __construct(PostInterface $postInterface)
    {
        $this->postInterface = $postInterface;
    }
    use helpers;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $post = $this->postInterface->index();

        if(!empty($post))
        {
            return $this->apiResponse(new GeneralCollection($post,PostResource::class));
        }else{
            return $this->apiResponse(['data' => 'Not Found']);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {

        $post = $this->postInterface->store($request)->first();
        if(!empty($post))
        {
            return $this->apiResponse(['data' => new PostResource($post)]);
        }else{
            return $this->apiResponse(['message' => 'Not created']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = new Post();
        $this->authorize('view', $post);
        $post = $this->postInterface->show($id);

        if(!empty($post))
        {
          //  return $this->apiResponse(new GeneralCollection(collect($post),PostResource::class));
            return $this->apiResponse(['data' => new PostResource($post)]);
        }else{
            return $this->apiResponse(['data' => 'Not Found']);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, $id)
    {
        $post = new Post();
        $this->authorize('update', $post);
        $post = $this->postInterface->update($request,$id);

        if(!empty($post))
        {
            return $this->apiResponse(['data' => new PostResource($post)]);
        }else{
            return $this->apiResponse(['data' => 'Not Found']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = new Post();
        $this->authorize('delete', $post);
        $post = $this->postInterface->destroy($id);

        if(!empty($post))
        {
            return $this->apiResponse(['message' => 'Deleted']);
        }else{
            return $this->apiResponse(['message' => 'Not Found'],404);
        }
    }

    public function viewDeletedPosts()
    {
        $post = new Post();
        $this->authorize('restore', $post);
        $post = $this->postInterface->viewDeletedPosts();

        if(!empty($post->first()))
        {
            return $this->apiResponse(new GeneralCollection($post,PostResource::class));
        }else{
            return $this->apiResponse(['message' => 'Not Found']);
        }
    }
    public function restoreDeletedPosts($id)
    {
        $post = new Post();
        $this->authorize('restore', $post);
        $post = $this->postInterface->restoreDeletedPosts($id);

        if(!empty($post))
        {
            return $this->apiResponse(['message' => 'restored']);
        }else{
            return $this->apiResponse(['message' => 'Not Found']);
        }
    }
}
