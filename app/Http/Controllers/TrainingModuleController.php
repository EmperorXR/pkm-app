<?php

namespace App\Http\Controllers;

use App\Models\TrainingModule;
use App\Models\TrainingTrack;
use Illuminate\Contracts\View\View;

class TrainingModuleController extends Controller
{
    /**
     * Display a specific training module.
     */
    public function show(string $trackSlug, string $moduleSlug): View
    {
        $track = TrainingTrack::with(['modules' => function ($query): void {
            $query->orderBy('order_number');
        }])
            ->where('slug', $trackSlug)
            ->firstOrFail();

        $module = TrainingModule::where('training_track_id', $track->id)
            ->where('slug', $moduleSlug)
            ->firstOrFail();

        // Previous and Next module
        $modules = $track->modules;
        $currentIndex = $modules->search(fn (TrainingModule $item): bool => $item->id === $module->id);

        $prevModule = $currentIndex > 0 ? $modules->get($currentIndex - 1) : null;
        $nextModule = ($currentIndex !== false && $currentIndex < $modules->count() - 1) ? $modules->get($currentIndex + 1) : null;

        return view('pages.modules.show', compact('track', 'module', 'prevModule', 'nextModule'));
    }
}
