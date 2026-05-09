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
}