<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\KnapsackService;

class MemoryController extends Controller
{
    public function index()
    {
        return view('memory.index');
    }

    public function calculate(Request $request, KnapsackService $knapsackService)
    {
        $request->validate([
            'capacity' => 'required|integer|min:1',
            'names' => 'required|array',
            'memories' => 'required|array',
            'priorities' => 'required|array',
        ]);

        $memoryCapacity = (int) $request->input('capacity');

        $names = $request->input('names');
        $memories = $request->input('memories');
        $priorities = $request->input('priorities');

        $processes = [];

        // Monta a lista de processos a partir dos dados enviados pelo formulário.
        for ($i = 0; $i < count($names); $i++) {
            if (
                !empty($names[$i]) &&
                !empty($memories[$i]) &&
                !empty($priorities[$i])
            ) {
                $processes[] = [
                    'name' => $names[$i],
                    'memory' => (int) $memories[$i],
                    'priority' => (int) $priorities[$i],
                ];
            }
        }

        $result = $knapsackService->solve($processes, $memoryCapacity);

        return view('memory.result', [
            'capacity' => $memoryCapacity,
            'processes' => $processes,
            'result' => $result,
        ]);
    }
}