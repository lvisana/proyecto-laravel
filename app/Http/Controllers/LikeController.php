<?php

namespace App\Http\Controllers;
use App\Models\Like;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function like($id)
    {
        $user = \Auth::user();

        $isset_like = Like::where('user_id', $user->id)
                        ->where('image_id', $id);

        if ($isset_like->count() == 0) {
            $like = new Like;
            $like->user_id = $user->id;
            $like->image_id = $id;
    
            $like->save();

        } else {
            if ($isset_like->first()) {
                $isset_like->first()->delete();
            }
        }
    
        return Redirect::route('dashboard');
    }
}
