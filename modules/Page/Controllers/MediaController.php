<?php

namespace Modules\Page\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function shareStories(Request $request)
    {
        // Validate image, optional
        $request->validate([
            'image' => 'required|image|mimes:png,jpg,jpeg|max:5120', // max 5MB
        ]);


        // $image = $request->file('image');
        // // Store image in a public disk (e.g., 'public' points to storage/app/public)
        // $path = $image->store('story-images', 'public');

        // // Get URL of stored image
        // $url = Storage::disk('public')->url($path);

        $file = $request->file('image');
        $icon = $file->store('0000/shareStories', 'uploads') ?? '';

        return response()->json(['url' => $icon, 'ok' => true]);
    }
}
