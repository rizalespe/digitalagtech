<?php

namespace App\Http\Controllers;

use App\Models\GalleryPhoto;
use Illuminate\View\View;

class GalleryController extends Controller
{
    public function index(): View
    {
        return view('gallery.index', [
            'photos' => GalleryPhoto::with('event')->orderBy('sort_order')->latest()->paginate(12),
        ]);
    }
}
