<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Models\Image;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\Response;

class ImageController extends Controller
{
    public function create($edit = null)
    {
        if ($edit) {
            $image = Image::find($edit);

                if ($image && $image->user_id == \Auth::user()->id) {
                    return view('post.upload-image', [
                        'image' => $image
                    ]);
                }
        } else {
            return view('post.upload-image');
        }
    }

    public function save(Request $request)
    {
        $request->validate([
            'description' => ['string', 'required'],
            'image_path' => ['image', 'required'],
        ]);

        $image_path = $request->file('image_path');
        $description = $request->input('description');

        $user = \Auth::user();
        $image = new Image();
        $image->description = $description;
        $image->user_id = $user->id;

        if ($image_path) {
            $image_path_name = time().$image_path->getClientOriginalName();
            Storage::disk('images')->put($image_path_name, File::get($image_path));
            $image->image_path = $image_path_name;
        }

        $image->save();

        return Redirect::route('dashboard')->with('status', 'image-uploaded');
    }

    public function detail($id)
    {
        $image = Image::where('id', $id)->get();
        $comments = $image[0]->comments()->paginate(5);
        
        return view('post.detail', [
            'image' => $image,
            'comments' => $comments
        ]);
    }

    public function file($filename)
    {
        $image = Storage::disk('images')->get($filename);
        return new Response($image, 200);
    }

    public function likeCount($id)
    {
        $image = Image::where('id', $id)->get();
        $likes = $image[0]->likes();

        $users = [];

        foreach($likes->get() as $like) {
            array_push($users, array(
                'name' => $like->user->name,
                'surname' => $like->user->surname,
                'image' => $like->user->image,
            ));
        }

        return response()->json([
            'count' => (int)$likes->count(),
            'users' => (array)$users,
        ]);
    }

    public function delete($id)
    {
        $image = Image::find($id);

        if ($image && $image->user_id == \Auth::user()->id) {

            $image->likes()->delete();
            $image->comments()->delete();
            $image->delete();
            Storage::disk('images')->delete($image->image_path);
            
            return Redirect::route('dashboard')->with('status', 'image-deleted');
        } else {
            return Redirect::route('dashboard');
        }
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'description' => ['string', 'required'],
            'image_path' => ['image', 'required'],
        ]);

        $image_path = $request->file('image_path');
        $description = $request->input('description');


        $image = Image::find($id);

        if ($image && $image->user_id == \Auth::user()->id) {

            if ($image_path) {
                Storage::disk('images')->delete($image->image_path);

                $image_path_name = time().$image_path->getClientOriginalName();
                Storage::disk('images')->put($image_path_name, File::get($image_path));
                $image->image_path = $image_path_name;
            }

            $image->description = $description;

            $image->save();

            return Redirect::route('image.detail', ['id' => $image->id])->with('status', 'image-updated');
        } else {
            return Redirect::route('dashboard');
        }

    }
}
