<?php

namespace App\Http\Controllers;

use App\Models\SimulationRecord;
use App\Services\DistributedSimulatorService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DistributedLabController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(public DistributedSimulatorService $distService) {}

    /**
     * Display the interactive Distributed AI Cluster Simulator.
     */
    public function index(): View
    {
        $initialNodes = $this->distService->getInitialNodes();
        $savedSimulations = [];

        if (Auth::check()) {
            $savedSimulations = SimulationRecord::where('user_id', Auth::id())
                ->where('simulation_type', 'distributed_cluster')
                ->latest()
                ->take(5)
                ->get();
        }

        return view('pages.labs.distributed', compact('initialNodes', 'savedSimulations'));
    }

    /**
     * Execute distributed cluster simulation run.
     */
    public function simulate(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'algorithm' => 'required|in:round_robin,least_connections,weighted_capacity',
            'batch_requests' => 'required|integer|min:10|max:1000',
            'concurrency' => 'required|integer|min:1|max:100',
            'failed_node' => 'nullable|string',
            'replication_factor' => 'required|integer|min:1|max:5',
        ]);

        $result = $this->distService->simulate($validated);

        return response()->json([
            'success' => true,
            'result' => $result,
        ]);
    }

    /**
     * Save distributed simulation run.
     */
    public function save(Request $request): RedirectResponse
    {
        if (! Auth::check()) {
            return back()->with('error', 'Silakan login terlebih dahulu untuk menyimpan simulasi.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'input_data' => 'required|string',
            'result_data' => 'required|string',
        ]);

        SimulationRecord::create([
            'user_id' => Auth::id(),
            'simulation_type' => 'distributed_cluster',
            'title' => $validated['title'],
            'input_data' => json_decode($validated['input_data'], true) ?: [],
            'result_data' => json_decode($validated['result_data'], true) ?: [],
        ]);

        return back()->with('success', 'Riwayat simulasi klaster terdistribusi berhasil disimpan.');
    }
}
