<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(): View
    {
        return view('news.index', [
            'posts' => Post::published()->paginate(9),
        ]);
    }

    public function show(Post $post): View
    {
        abort_unless($post->published_at?->isPast(), 404);

        return view('news.show', [
            'post' => $post,
            'related' => Post::published()->whereKeyNot($post->id)->take(3)->get(),
        ]);
    }
}
