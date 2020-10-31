<?php

namespace App\Http\Controllers;

use App\Post;

use App\Category;

use Illuminate\Http\Request;

use App\Http\Requests\CreatePostRequest;

use App\Http\Requests\UpdatePostRequest;

use Illuminate\Support\Facades\Storage;

use Illuminate\Database\Eloquent\SoftDeletes;


class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $trashed = Post::onlyTrashed()->get();

        return view('posts.index')
                ->with('posts',Post::all())
                ->withTrashed($trashed);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create')->with('categories', Category::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePostRequest $request)
    {
        //upload image to storage
        $image = $request->image->store('posts');

        Post::create([

            'title'=>$request->title,
            'description'=>$request->description,
            'content'=>$request->content,
            'image'=>$image,
            'category_id'=>$request->category

        ]);

        session()->flash('message',[
            'message'=>'Post Created Successfully',
            'type'=>'alert-success'
        ]);

        return redirect()->route('posts.index');
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('posts.edit')->with(array(
            'posts'=>$post,
            'categories'=>Category::all()
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        
        if( $request->image == null){

        $post->title = $request['title'];
        $post->description = $request['description'];
        $post->content = $request['content'];
        $post->published_at = $request['published_at'];
        $post->updated_at = $request['editted_at'];
        $post->category_id = $request['category'];

        $post->update();
        
        session()->flash('message',[
            'message'=>'Post Updated Successfully.',
            'type'=>'alert-warning'
        ]);

            return redirect()->route('posts.index');
        }
        else {

        $post->deleteImage();
        // $imageLocation = $post->image;
        // $delete = Storage::delete($imageLocation);

        $image = $request->image->store('posts');

        $post->image = $image;
        $post->title = $request['title'];
        $post->description = $request['description'];
        $post->content = $request['content'];
        $post->published_at = $request['published_at'];
        $post->updated_at = $request['editted_at'];
        $post->category_id = $request['category'];

        $post->update();
        
        session()->flash('message',[
            'message'=>'Post Updated Successfully.',
            'type'=>'alert-warning'
        ]);

        return redirect()->route('posts.index');

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->deleteImage();
        // $image = $post->image;
        // $delete = Storage::delete($image);

        $post->forceDelete();

       session()->flash('message', [
           'message'=> 'Post Deleted Successfully',
            'type'=>'alert-danger'
       ]);

       return redirect()->route('posts.index');
    }

    public function softDelete(Post $post){

        $post->delete();

        session()->flash('message', [
           'message'=> 'Post Trashed Successfully',
            'type'=>'alert-warning'
       ]);

       return redirect()->route('posts.index');

    }

}
