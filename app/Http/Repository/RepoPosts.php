<?php
namespace App\Http\Repository;

use App\helpers;
use App\Models\Tag;
use App\Models\Post;
use Illuminate\Support\Facades\DB;
use App\Http\RepositoryInterface\PostInterface;

class RepoPosts implements PostInterface
{
    use helpers;
    private $postModel;
    public function __construct(Post $postModel)
    {
        $this->postModel = $postModel;
    }

    public function index()
    {
        $posts = auth()->user()->posts()->latest('pinned')->latest('created_at')->get();
        return $posts;
    }
    public function store($request)
    {
        $postCover = $this->uploadFile($request,'storage/PostCover','postCover',null);

        $post = new Post($request->toArray());
        $post->user_id = auth()->id();
        $post->cover_image = $postCover;
        $post->save();

        $post->tags()->sync($request['tag_ids']);

        return $post->with('tags');
    }
    public function show($id)
    {
        $posts = $this->postModel->where('id',$id)->with('tags')->first();

        return $posts;
    }
    public function update($request,$id)
    {
        $post = $this->show($id);
        if($post)
        {
            if($request->has('file'))
            {
                $postCover = $this->uploadFile($request,'storage/PostCover','postCover',$post->cover_image);

            }
            $postUpdate = $this->postModel::where('id',$id)->update(
                [
                    'title' => (!empty($request->title)) ? $request->title : $post->title,
                    'body' => (!empty($request->body)) ? $request->body : $post->body,
                    'cover_image' => (!empty($request->file)) ? $postCover : $post->cover_image,
                    'pinned' => (!is_null($request->pinned)) ? $request->pinned : $post->pinned,
                ]
            );
            if ($request->has('tag_ids')) {
                $post->tags()->sync($request['tag_ids']);
            }
            $tag = $this->show($id);

            return $tag;
        }else{

            return null;
        }

    }
    public function destroy($id)
    {
        $post = $this->show($id);
        if($post)
        {
           $post->delete();

            return true;
        }else{

            return null;
        }
    }

    public function viewDeletedPosts()
    {
       // $posts = $this->postModel->where('deleted_at','!=','null')->get();
        $posts =  auth()->user()->posts()->onlyTrashed()->latest('deleted_at')->get();

        return $posts;
    }

    public function restoreDeletedPosts($id)
    {
        $post = $this->postModel->where('id',$id)->onlyTrashed()->first();
        if( $post)
        {
            $post->restore();
            return true;
        }else{
            return null;
        }

    }

    public function forceDelete()
    {
        $posts = $this->postModel->onlyTrashed()->where('deleted_at', '<', now()->subDays(30))->get();

        if($posts)
        {
            foreach ($posts as $post) {
                $post->forceDelete();
                 }
            return true;
        }else{
            return null;
        }
    }



}
