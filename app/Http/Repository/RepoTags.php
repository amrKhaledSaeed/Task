<?php
namespace App\Http\Repository;

use App\Models\Tag;
use App\Http\RepositoryInterface\TagsInterface;

class RepoTags implements TagsInterface
{
    private $TagModel;
    public function __construct(Tag $TagModel)
    {
        $this->TagModel = $TagModel;
    }

    public function index()
    {
        $tags = $this->TagModel->get();
    }
    public function store($request)
    {
        $tags = $this->TagModel::create($request->toArray());

        return $tags;
    }
    public function show($id)
    {
        $tags = $this->TagModel->where('id',$id)->first();

        return $tags;
    }
    public function update($request,$id)
    {
        $tag = $this->show($id);
        if($tag)
        {
            $tags = $this->TagModel::where('id',$id)->update(
                [
                    'name' => (!empty($request->name)) ? $request->name : $tag->name
                ]
            );
            $tag = $this->show($id);

            return $tag;
        }else{

            return null;
        }

    }
    public function destroy($id)
    {
        $tag = $this->show($id);
        if($tag)
        {
           $tag->delete();

            return true;
        }else{

            return null;
        }
    }

}
