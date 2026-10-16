<?php

namespace App\Http\Controllers;

use App\Models\Speaker;
use Illuminate\View\View;

class SpeakerController extends Controller
{
    public function index(): View
    {
        return view('speakers.index', [
            'speakers' => Speaker::ordered()->paginate(12),
        ]);
    }
}
