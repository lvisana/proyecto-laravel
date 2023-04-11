<?php

namespace App\Http\Controllers;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class CommentController extends Controller
{
    public function save(Request $request)
    {
        $request->validate([
            'image_id' => ['int', 'max:255', 'required'],
            'content' => ['string', 'required'],
        ]);

        $user = \Auth::user();
        $comment = new Comment;
        $comment->image_id = $request->input('image_id');
        $comment->content = $request->input('content');
        $comment->user_id = $user->id;

        $comment->save();

        return Redirect::to(route('image.detail', ['id' => $request->image_id]).'#comments')->with('status', 'comment-sent');
    }

    public function delete($id)
    {
        $comment = Comment::find($id);
    
        if ($comment && $comment->user_id == \Auth::user()->id) {
            Comment::where('id', $comment->id)->delete();
            return Redirect::to(route('image.detail', ['id' => $comment->image->id]).'#comments')->with('status', 'comment-deleted');
        } else {
            return Redirect::to(route('image.detail', ['id' => $comment->image->id]).'#comments');
        }

    }
}
