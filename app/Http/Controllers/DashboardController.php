<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use Illuminate\Database\Eloquent\Collection;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $images = Image::orderByDesc('created_at')->paginate(3);

        return view('dashboard', [
            'images' => $images
        ]);
    }
}
