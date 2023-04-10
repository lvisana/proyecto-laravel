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
    public function create()
    {
        return view('profile.upload-image');
    }

    public function save(Request $request)
    {
        $request->validate([
            'description' => ['string', 'max:1024', 'required'],
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
        
        return view('detail', [
            'image' => $image
        ]);
    }

    public function file($filename)
    {
        $image = Storage::disk('images')->get($filename);
        return new Response($image, 200);
    }
}
