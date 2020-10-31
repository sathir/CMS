<?php

namespace App\Http\Controllers;
use App\Post;
use Illuminate\Http\Request;
use App\Http\Requests\CreatePostRequest;
use Illuminate\Support\Facades\Storage;

class TrashController extends Controller
{
    public function restore_post(Request $post, $id){

        $post = Post::withTrashed()
                ->where('id', $id)
                ->restore();
        
        session()->flash('message',[
            
            'message'=> 'Post restored successfully.',
            'type'=>'alert-success'
        ]);

        return redirect()->route('posts.index');
    }
}
