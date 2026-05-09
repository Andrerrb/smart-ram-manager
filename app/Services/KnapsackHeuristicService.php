<?php

namespace App\Services;

class KnapsackHeuristicService
{
    public function generateFixedProblem(): array
    {
        return [
            'capacity' => 8,
            'processes' => [
                [
                    'name' => 'Banco de Dados',
                    'memory' => 4,
                    'priority' => 10,
                ],
                [
                    'name' => 'Servidor Web',
                    'memory' => 2,
                    'priority' => 7,
                ],
                [
                    'name' => 'Backup',
                    'memory' => 3,
                    'priority' => 5,
                ],
                [
                    'name' => 'Monitoramento',
                    'memory' => 1,
                    'priority' => 4,
                ],
                [
                    'name' => 'Relatório pesado',
                    'memory' => 5,
                    'priority' => 8,
                ],
            ],
        ];
    }

    public function generateRandomProblem(int $size): array
    {
        $processes = [];

        for ($i = 1; $i <= $size; $i++) {
            $processes[] = [
                'name' => 'Processo ' . $i,
                'memory' => rand(1, 8),
                'priority' => rand(1, 20),
            ];
        }

        return [
            'capacity' => rand(8, 20),
            'processes' => $processes,
        ];
    }

    public function generateInitialSolution(array $processes): array
    {
        $solution = [];

        foreach ($processes as $process) {
            $solution[] = rand(0, 1);
        }

        return $solution;
    }

    public function evaluate(array $processes, array $solution, int $capacity): array
    {
        $usedMemory = 0;
        $totalPriority = 0;
        $selectedProcesses = [];

        foreach ($solution as $index => $selected) {
            if ($selected == 1) {
                $process = $processes[$index];

                $usedMemory += $process['memory'];
                $totalPriority += $process['priority'];
                $selectedProcesses[] = $process;
            }
        }

        if ($usedMemory > $capacity) {
            $totalPriority = 0;
        }

        return [
            'solution' => $solution,
            'used_memory' => $usedMemory,
            'total_priority' => $totalPriority,
            'is_valid' => $usedMemory <= $capacity,
            'selected_processes' => $selectedProcesses,
        ];
    }

    public function hillClimbing(array $processes, array $initialSolution, int $capacity): array
    {
        $currentSolution = $initialSolution;

        $currentEvaluation = $this->evaluate(
            $processes,
            $currentSolution,
            $capacity
        );

        $improved = true;
        $iterations = 0;

        while ($improved) {
            $improved = false;
            $bestNeighbor = $currentSolution;
            $bestEvaluation = $currentEvaluation;

            for ($i = 0; $i < count($currentSolution); $i++) {
                $neighbor = $currentSolution;

                // Inverte uma posição da solução: 0 vira 1 e 1 vira 0.
                $neighbor[$i] = $neighbor[$i] == 1 ? 0 : 1;

                $neighborEvaluation = $this->evaluate(
                    $processes,
                    $neighbor,
                    $capacity
                );

                if (
                    $neighborEvaluation['is_valid'] &&
                    $neighborEvaluation['total_priority'] > $bestEvaluation['total_priority']
                ) {
                    $bestNeighbor = $neighbor;
                    $bestEvaluation = $neighborEvaluation;
                    $improved = true;
                }
            }

            if ($improved) {
                $currentSolution = $bestNeighbor;
                $currentEvaluation = $bestEvaluation;
            }

            $iterations++;
        }

        return [
            'method' => 'Subida de Encosta',
            'solution' => $currentSolution,
            'evaluation' => $currentEvaluation,
            'iterations' => $iterations,
        ];
    }

    public function hillClimbingWithAttempts(array $processes, int $capacity, int $maxAttempts): array
    {
        $bestResult = null;

        for ($attempt = 1; $attempt <= $maxAttempts; $attempt++) {
            $initialSolution = $this->generateInitialSolution($processes);

            $result = $this->hillClimbing(
                $processes,
                $initialSolution,
                $capacity
            );

            if (
                $bestResult === null ||
                $result['evaluation']['total_priority'] > $bestResult['evaluation']['total_priority']
            ) {
                $bestResult = $result;
            }
        }

        $bestResult['method'] = 'Subida de Encosta com Tentativas';
        $bestResult['attempts'] = $maxAttempts;

        return $bestResult;
    }

    public function simulatedAnnealing(
        array $processes,
        array $initialSolution,
        int $capacity,
        float $initialTemperature,
        float $finalTemperature,
        float $coolingRate
    ): array {
        $currentSolution = $initialSolution;

        $currentEvaluation = $this->evaluate(
            $processes,
            $currentSolution,
            $capacity
        );

        $bestSolution = $currentSolution;
        $bestEvaluation = $currentEvaluation;

        $temperature = $initialTemperature;
        $iterations = 0;

        while ($temperature > $finalTemperature) {
            $neighbor = $currentSolution;

            $randomIndex = rand(0, count($neighbor) - 1);

            // Inverte uma posição aleatória da solução.
            $neighbor[$randomIndex] = $neighbor[$randomIndex] == 1 ? 0 : 1;

            $neighborEvaluation = $this->evaluate(
                $processes,
                $neighbor,
                $capacity
            );

            $currentPriority = $currentEvaluation['total_priority'];
            $neighborPriority = $neighborEvaluation['total_priority'];

            if ($neighborEvaluation['is_valid']) {
                if ($neighborPriority > $currentPriority) {
                    $currentSolution = $neighbor;
                    $currentEvaluation = $neighborEvaluation;
                } else {
                    $difference = $neighborPriority - $currentPriority;

                    $probability = exp($difference / $temperature);

                    $randomValue = mt_rand() / mt_getrandmax();

                    if ($randomValue < $probability) {
                        $currentSolution = $neighbor;
                        $currentEvaluation = $neighborEvaluation;
                    }
                }

                if ($currentEvaluation['total_priority'] > $bestEvaluation['total_priority']) {
                    $bestSolution = $currentSolution;
                    $bestEvaluation = $currentEvaluation;
                }
            }

            $temperature *= $coolingRate;
            $iterations++;
        }

        return [
            'method' => 'Têmpera Simulada',
            'solution' => $bestSolution,
            'evaluation' => $bestEvaluation,
            'iterations' => $iterations,
            'temperature' => [
                'initial' => $initialTemperature,
                'final' => $finalTemperature,
                'cooling_rate' => $coolingRate,
            ],
        ];
    }

    public function comparativeAnalysis(array $processes, int $capacity): array
    {
        $n = count($processes);

        $results = [];

        // Subida de Encosta simples
        $initialSolution = $this->generateInitialSolution($processes);

        $seResult = $this->hillClimbing(
            $processes,
            $initialSolution,
            $capacity
        );

        $results[] = [
            'method' => 'SE',
            'observation' => '---',
            'gain' => $seResult['evaluation']['total_priority'],
            'solution' => $seResult['solution'],
            'used_memory' => $seResult['evaluation']['used_memory'],
        ];

        // Subida de Encosta com Tentativas
        $attemptsConfigs = [
            max(1, intdiv($n, 2)),
            $n,
            2 * $n,
        ];

        foreach ($attemptsConfigs as $attempts) {
            $setResult = $this->hillClimbingWithAttempts(
                $processes,
                $capacity,
                $attempts
            );

            $results[] = [
                'method' => 'SET',
                'observation' => 'TMAX = ' . $attempts,
                'gain' => $setResult['evaluation']['total_priority'],
                'solution' => $setResult['solution'],
                'used_memory' => $setResult['evaluation']['used_memory'],
            ];
        }

        // Têmpera Simulada com diferentes configurações
        $temperatureConfigs = [
            ['ti' => 100, 'tf' => 0.1, 'fr' => 0.8],
            ['ti' => 200, 'tf' => 0.1, 'fr' => 0.8],
            ['ti' => 500, 'tf' => 0.1, 'fr' => 0.8],
            ['ti' => 200, 'tf' => 0.1, 'fr' => 0.9],
            ['ti' => 500, 'tf' => 0.1, 'fr' => 0.9],
            ['ti' => 200, 'tf' => 0.01, 'fr' => 0.9],
            ['ti' => 500, 'tf' => 0.01, 'fr' => 0.9],
        ];

        foreach ($temperatureConfigs as $config) {
            $initialSolution = $this->generateInitialSolution($processes);

            $teResult = $this->simulatedAnnealing(
                $processes,
                $initialSolution,
                $capacity,
                $config['ti'],
                $config['tf'],
                $config['fr']
            );

            $results[] = [
                'method' => 'TE',
                'observation' => 'TI=' . $config['ti'] . '; TF=' . $config['tf'] . '; FR=' . $config['fr'],
                'gain' => $teResult['evaluation']['total_priority'],
                'solution' => $teResult['solution'],
                'used_memory' => $teResult['evaluation']['used_memory'],
            ];
        }

        $bestResult = $results[0];

        foreach ($results as $result) {
            if ($result['gain'] > $bestResult['gain']) {
                $bestResult = $result;
            }
        }

        return [
            'method' => 'Análise Comparativa',
            'comparison_results' => $results,
            'best_result' => $bestResult,
            'iterations' => count($results),
        ];
    }
}