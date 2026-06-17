<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\KnapsackHeuristicService;

class MemoryController extends Controller
{
    public function home()
    {
        return view('memory.home');
    }

    public function basicMethods()
    {
        return view('memory.basic-methods');
    }

    public function geneticAlgorithms()
    {
        return view('memory.genetic-algorithms');
    }

    public function about()
    {
        return view('memory.about');
    }

    public function generateProblem(Request $request, KnapsackHeuristicService $service)
    {
        $executionType = $request->input('execution_type');
        $problemSize = (int) $request->input('problem_size', 5);

        if ($executionType === 'random') {
            $problem = $service->generateRandomProblem($problemSize);
        } else {
            $problem = $service->generateFixedProblem();
        }

        session([
            'problem' => $problem,
            'initial_solution' => null,
            'initial_evaluation' => null,
            'method_result' => null,
        ]);

        return back()->with('message', 'Problema gerado com sucesso.');
    }

    public function initialSolution(Request $request, KnapsackHeuristicService $service)
    {
        $problem = session('problem');

        if (!$problem) {
            $problem = $service->generateFixedProblem();

            session([
                'problem' => $problem,
            ]);
        }

        $solution = $service->generateInitialSolution($problem['processes']);

        $evaluation = $service->evaluate(
            $problem['processes'],
            $solution,
            $problem['capacity']
        );

        session([
            'initial_solution' => $solution,
            'initial_evaluation' => $evaluation,
            'method_result' => null,
        ]);

        return back()->with('message', 'Solução inicial gerada com sucesso.');
    }

    public function executeMethod(Request $request, KnapsackHeuristicService $service)
    {
        $problem = session('problem');
        $initialSolution = session('initial_solution');

        if (!$problem) {
            $problem = $service->generateFixedProblem();

            session([
                'problem' => $problem,
            ]);
        }

        if (!$initialSolution) {
            $initialSolution = $service->generateInitialSolution($problem['processes']);

            $initialEvaluation = $service->evaluate(
                $problem['processes'],
                $initialSolution,
                $problem['capacity']
            );

            session([
                'initial_solution' => $initialSolution,
                'initial_evaluation' => $initialEvaluation,
            ]);
        }

        $method = $request->input('method');

        if ($method === 'hill_climbing') {
            $result = $service->hillClimbing(
                $problem['processes'],
                $initialSolution,
                $problem['capacity']
            );

            session([
                'method_result' => $result,
            ]);

            return back()->with('message', 'Subida de Encosta executada com sucesso.');
        }

        if ($method === 'hill_climbing_attempts') {
            $maxAttempts = (int) $request->input('tmax', 10);

            $result = $service->hillClimbingWithAttempts(
                $problem['processes'],
                $problem['capacity'],
                $maxAttempts
            );

            session([
                'method_result' => $result,
            ]);

            return back()->with('message', 'Subida de Encosta com Tentativas executada com sucesso.');
        }

        if ($method === 'simulated_annealing') {
            $initialTemperature = (float) str_replace(',', '.', $request->input('ti', 100));
            $finalTemperature = (float) str_replace(',', '.', $request->input('tf', 0.1));
            $coolingRate = (float) str_replace(',', '.', $request->input('fr', 0.8));

            $result = $service->simulatedAnnealing(
                $problem['processes'],
                $initialSolution,
                $problem['capacity'],
                $initialTemperature,
                $finalTemperature,
                $coolingRate
            );

            session([
                'method_result' => $result,
            ]);

            return back()->with('message', 'Têmpera Simulada executada com sucesso.');
        }

        if ($method === 'genetic_algorithm') {
           $populationSize = (int) $request->input('tp', 10);
           $generations = (int) $request->input('ng', 50);
           $crossoverRate = (float) str_replace(',', '.', $request->input('tc', 0.8));
           $mutationRate = (float) str_replace(',', '.', $request->input('tm', 0.2));
           $generationInterval = (float) str_replace(',', '.', $request->input('ig', 0.1));

           $result = $service->geneticAlgorithm(
               $problem['processes'],
               $problem['capacity'],
               $populationSize,
               $generations,
               $crossoverRate,
               $mutationRate,
               $generationInterval
    );

    session([
        'method_result' => $result,
    ]);

    return back()->with('message', 'Algoritmo Genético executado com sucesso.');
}

        if ($method === 'comparative_analysis') {
            $result = $service->comparativeAnalysis(
                $problem['processes'],
                $problem['capacity']
            );

            session([
                'method_result' => $result,
            ]);

            return back()->with('message', 'Análise Comparativa executada com sucesso.');
        }

        return back()->with('message', 'Método ainda não implementado.');
    }
}