<?php

namespace App\Http\Controllers;

use App\Enums\ToolkitStage;
use App\Models\IncubationProgram;
use App\Models\Toolkit;
use Illuminate\View\View;

class ProgramController extends Controller
{
    public function selfLearning(): View
    {
        return view('programs.self-learning', [
            'toolkits' => Toolkit::active()->get(),
            'stages' => ToolkitStage::cases(),
        ]);
    }

    public function incubation(): View
    {
        return view('programs.incubation', [
            'programs' => IncubationProgram::active()->with('photos')->get(),
            'stats' => config('site.incubation_stats'),
        ]);
    }
}
