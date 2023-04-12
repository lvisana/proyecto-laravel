<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        
        $request->user()->fill($request->validated());
        
        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }
        
        $image = $request->file('image');
        
        if ($image) {
            $image_path = time().$image->getClientOriginalName();

            Storage::disk('users')->put($image_path, File::get($image));
            $request->user()->image = $image_path;
        }

        $request->user()->save();

        return Redirect::route('settings.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function avatar($filename)
    {
        $image = Storage::disk('users')->get($filename);
        return new Response($image, 200);
    }

    public function profile()
    {
        $currUser = \Auth::user();

        $user = User::where('id', $currUser->id)->get();
        $images = $user[0]->images()->orderByDesc('created_at')->paginate(3);

        return view('profile.profile', [
            'user' => $user,
            'images' => $images
        ]);
    }
}
