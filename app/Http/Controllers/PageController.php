<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\GalleryDirectory;
use App\Models\GalleryFiles;
// use App\Models\Posts;

class PageController extends Controller
{
    public function about()
    {
        $data = [
            'post1' => Post::find(1),
            'post2' => Post::find(2),
            'post3' => Post::find(3)
        ];
        return view('about', $data);
    }

    public function gallery()
    {
        $gallery = GalleryDirectory::get();
        return view('gallery', compact('gallery'));
    }

    public function contact()
    {
        $gallery = GalleryDirectory::get();
        return view('contact');
    }
}
