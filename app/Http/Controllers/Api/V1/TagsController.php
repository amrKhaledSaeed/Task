<?php

namespace App\Http\Controllers\Api\V1;

use App\helpers;
use Illuminate\Http\Request;
use App\Http\Requests\TagsRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\TagsResource;
use App\Http\Resources\GeneralCollection;
use App\Http\RepositoryInterface\TagsInterface;

class TagsController extends Controller
{
    private $tagsInterface;
    public function __construct(TagsInterface $tagsInterface)
    {
        $this->tagsInterface = $tagsInterface;
    }
    use helpers;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = $this->tagsInterface->index();

        if(!empty($tags))
        {
            return $this->apiResponse(new GeneralCollection($tags,TagsResource::class));
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
    public function store(TagsRequest $request)
    {
         $tags = $this->tagsInterface->store($request);

        if(!empty($tags))
        {
            return $this->apiResponse(['data' => new TagsResource($tags)]);
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TagsRequest $request, $id)
    {
        $tags = $this->tagsInterface->update($request,$id);

        if(!empty($tags))
        {
            return $this->apiResponse(['data' => new TagsResource($tags)]);
        }else{
            return $this->apiResponse(['data' => 'Not Found'],404);
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
        $tags = $this->tagsInterface->destroy($id);

        if(!empty($tags))
        {
            return $this->apiResponse(['data' => 'Deleted']);
        }else{
            return $this->apiResponse(['data' => 'Not Found'],404);
        }
    }
}
