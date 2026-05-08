<?php

namespace App\Services;

class KnapsackService
{
    public function solve(array $processes, int $capacity): array
    {
        $totalProcesses = count($processes);

        // Tabela usada para guardar a melhor prioridade possível
        // para cada quantidade de processos e de memória disponível.
        $table = array_fill(
            0,
            $totalProcesses + 1,
            array_fill(0, $capacity + 1, 0)
        );

        for ($i = 1; $i <= $totalProcesses; $i++) {
            $memory = $processes[$i - 1]['memory'];
            $priority = $processes[$i - 1]['priority'];

            for ($currentMemory = 0; $currentMemory <= $capacity; $currentMemory++) {
                if ($memory <= $currentMemory) {
                    $withoutProcess = $table[$i - 1][$currentMemory];

                    $withProcess = $priority + $table[$i - 1][$currentMemory - $memory];

                    $table[$i][$currentMemory] = max($withoutProcess, $withProcess);
                } else {
                    $table[$i][$currentMemory] = $table[$i - 1][$currentMemory];
                }
            }
        }

        $selectedProcesses = [];
        $remainingMemory = $capacity;

        // Volta pela tabela para descobrir quais processos foram escolhidos.
        for ($i = $totalProcesses; $i > 0; $i--) {
            if ($table[$i][$remainingMemory] != $table[$i - 1][$remainingMemory]) {
                $process = $processes[$i - 1];

                $selectedProcesses[] = $process;
                $remainingMemory -= $process['memory'];
            }
        }

        $usedMemory = array_sum(array_column($selectedProcesses, 'memory'));

        return [
            'max_priority' => $table[$totalProcesses][$capacity],
            'selected_processes' => array_reverse($selectedProcesses),
            'used_memory' => $usedMemory,
            'available_memory' => $capacity - $usedMemory,
        ];
    }
}