<?php

namespace App\Http\Controllers;

use App\Models\AssessmentAttempt;
use App\Models\AssessmentDimension;
use App\Models\AssessmentOption;
use App\Models\Event;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AssessmentController extends Controller
{
    public function index(): View
    {
        $dimensions = AssessmentDimension::with(['questions.options'])
            ->orderBy('sort_order')
            ->get();

        $sectors = [
            'Crop Production & Farming',
            'Precision Agriculture',
            'Livestock & Animal Farming',
            'Agricultural Inputs',
            'Aquaculture & Fisheries',
            'Smart Farming & Farm Management',
            'Agri Marketplace',
            'Supply Chain & Logistics',
            'Food Processing & Agrifood',
            'Agri Finance & Fintech',
            'Climate & Sustainable Agriculture',
            'Agri Data & AI',
            'Other',
        ];

        return view('assessment.index', compact('dimensions', 'sectors'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'startup_name' => ['required', 'string', 'max:255'],
            'founder_name' => ['required', 'string', 'max:255'],
            'sector'       => ['required', 'string'],
            'answers'      => ['required', 'array'],
            'answers.*'    => ['required', 'integer', 'exists:assessment_options,id'],
        ]);

        // Calculate scores per dimension and total
        $optionIds = $request->input('answers'); // [question_id => option_id]
        $options   = AssessmentOption::whereIn('id', $optionIds)->get()->keyBy('id');

        $totalScore     = 0;
        $dimensionScores = [];

        foreach ($optionIds as $questionId => $optionId) {
            $option = $options[$optionId] ?? null;
            if (! $option) {
                continue;
            }
            $totalScore += $option->score;
        }

        $questionCount = count($optionIds);
        $maxScore      = $questionCount * 5;
        $percentage    = $maxScore > 0 ? round(($totalScore / $maxScore) * 100) : 0;

        $stage = match (true) {
            $percentage >= 70 => 'Scale',
            $percentage >= 40 => 'Build',
            default           => 'Discover',
        };

        $attempt = AssessmentAttempt::create([
            'user_id'      => auth()->id(),
            'startup_name' => $request->startup_name,
            'founder_name' => $request->founder_name,
            'sector'       => $request->sector,
            'total_score'  => $percentage,
            'stage'        => $stage,
            'completed_at' => now(),
        ]);

        foreach ($optionIds as $questionId => $optionId) {
            $attempt->answers()->create([
                'assessment_question_id' => $questionId,
                'assessment_option_id'   => $optionId,
            ]);
        }

        return redirect()->route('assessment.result', $attempt);
    }

    public function result(AssessmentAttempt $attempt): View
    {
        $attempt->load('answers.option', 'answers.question.dimension');

        $upcomingEvents = Event::published()
            ->where('starts_at', '>', now())
            ->where('registration_open', true)
            ->orderBy('starts_at')
            ->take(3)
            ->get();

        $stageToolkits = [
            'Discover' => ['Ideation & Problem Discovery', 'Validation & Problem–Solution Fit'],
            'Build'    => ['Product–Market Fit'],
            'Scale'    => ['Scaling & Growth', 'Maturity & Expansion'],
        ];

        $recommendedToolkits = $stageToolkits[$attempt->stage] ?? [];

        return view('assessment.result', compact('attempt', 'upcomingEvents', 'recommendedToolkits'));
    }
}
