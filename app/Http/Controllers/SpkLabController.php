<?php

namespace App\Http\Controllers;

use App\Models\SimulationRecord;
use App\Services\SpkService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SpkLabController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(public SpkService $spkService) {}

    /**
     * Display the interactive SPK / DSS Lab interface.
     */
    public function index(Request $request): View
    {
        $sampleDatasets = $this->spkService->getSampleDatasets();
        $selectedDatasetKey = $request->query('dataset', 'ai_server');
        $initialData = $sampleDatasets[$selectedDatasetKey] ?? $sampleDatasets['ai_server'];

        $savedSimulations = [];
        if (Auth::check()) {
            $savedSimulations = SimulationRecord::where('user_id', Auth::id())
                ->where('simulation_type', 'like', 'spk_%')
                ->latest()
                ->take(5)
                ->get();
        }

        return view('pages.labs.spk', compact('sampleDatasets', 'selectedDatasetKey', 'initialData', 'savedSimulations'));
    }

    /**
     * Process SPK calculation dynamically.
     */
    public function calculate(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'method' => 'required|in:saw,topsis,wp',
            'criteria' => 'required|array|min:2',
            'criteria.*.code' => 'required|string',
            'criteria.*.name' => 'required|string',
            'criteria.*.weight' => 'required|numeric|min:0.01',
            'criteria.*.type' => 'required|in:benefit,cost',
            'alternatives' => 'required|array|min:2',
            'alternatives.*.code' => 'required|string',
            'alternatives.*.name' => 'required|string',
            'alternatives.*.values' => 'required|array',
        ]);

        $method = $validated['method'];
        $criteria = $validated['criteria'];
        $alternatives = $validated['alternatives'];

        $result = match ($method) {
            'saw' => $this->spkService->calculateSaw($criteria, $alternatives),
            'topsis' => $this->spkService->calculateTopsis($criteria, $alternatives),
            'wp' => $this->spkService->calculateWeightedProduct($criteria, $alternatives),
        };

        return response()->json([
            'success' => true,
            'result' => $result,
        ]);
    }

    /**
     * Save simulation record to history.
     */
    public function save(Request $request): RedirectResponse
    {
        if (! Auth::check()) {
            return back()->with('error', 'Silakan login terlebih dahulu untuk menyimpan riwayat simulasi.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'method' => 'required|in:saw,topsis,wp',
            'input_data' => 'required|string',
            'result_data' => 'required|string',
        ]);

        SimulationRecord::create([
            'user_id' => Auth::id(),
            'simulation_type' => 'spk_'.$validated['method'],
            'title' => $validated['title'],
            'input_data' => json_decode($validated['input_data'], true) ?: [],
            'result_data' => json_decode($validated['result_data'], true) ?: [],
        ]);

        return back()->with('success', 'Riwayat simulasi SPK AI berhasil disimpan ke akun Anda.');
    }
}
