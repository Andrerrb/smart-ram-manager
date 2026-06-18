<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\KnapsackHeuristicService;

class GenerateHeuristicReport extends Command
{
    protected $signature = 'report:heuristics';

    protected $description = 'Gera os arquivos CSV para o relatório da Prova 2';

    public function handle()
    {
        set_time_limit(0);

        $service = app(KnapsackHeuristicService::class);

        $n = 50;
        $simulations = 20;

        $reportDir = storage_path('app/reports');

        if (!is_dir($reportDir)) {
            mkdir($reportDir, 0777, true);
        }

        $this->info('Gerando problemas de teste...');

        $problems = [];

        for ($simulation = 1; $simulation <= $simulations; $simulation++) {
            $problems[] = $service->generateRandomProblem($n);
        }

        $this->info('Iniciando Parte 1 - Análise de parâmetros genéticos...');

        $tpValues = [10, 50, 100];
        $ngValues = [10, 50, 100, 200];
        $tcValues = [0.2, 0.5, 0.8];
        $tmValues = [0, 0.2, 0.8];
        $igValues = [0, 0.1, 0.7];

        $agRows = [];
        $totalConfigs = count($tpValues) * count($ngValues) * count($tcValues) * count($tmValues) * count($igValues);
        $currentConfig = 1;

        foreach ($tpValues as $tp) {
            foreach ($ngValues as $ng) {
                foreach ($tcValues as $tc) {
                    foreach ($tmValues as $tm) {
                        foreach ($igValues as $ig) {
                            $sumGain = 0;

                            for ($simulation = 1; $simulation <= $simulations; $simulation++) {
                                $problem = $problems[$simulation - 1];

                                $result = $service->geneticAlgorithm(
                                    $problem['processes'],
                                    $problem['capacity'],
                                    $tp,
                                    $ng,
                                    $tc,
                                    $tm,
                                    $ig
                                );

                                $sumGain += $result['evaluation']['total_priority'];
                            }

                            $averageGain = $sumGain / $simulations;
                            $averageGainFormula = 100 * $averageGain;

                            $agRows[] = [
                                'TP' => $tp,
                                'NG' => $ng,
                                'TC' => $tc,
                                'TM' => $tm,
                                'IG' => $ig,
                                'SOMA_GANHO' => $sumGain,
                                'MEDIA_PRIORIDADE' => $averageGain,
                                'GANHO_MEDIO_FORMULA' => $averageGainFormula,
                            ];

                            $this->info('Configuração AG ' . $currentConfig . '/' . $totalConfigs . ' concluída.');

                            $currentConfig++;
                        }
                    }
                }
            }
        }

        usort($agRows, function ($a, $b) {
            return $b['GANHO_MEDIO_FORMULA'] <=> $a['GANHO_MEDIO_FORMULA'];
        });

        $this->writeCsv(
            $reportDir . '/ag_parametros.csv',
            ['TP', 'NG', 'TC', 'TM', 'IG', 'SOMA_GANHO', 'MEDIA_PRIORIDADE', 'GANHO_MEDIO_FORMULA'],
            $agRows
        );

        $topAgConfigs = array_slice($agRows, 0, 3);

        $this->writeCsv(
            $reportDir . '/ag_top3.csv',
            ['TP', 'NG', 'TC', 'TM', 'IG', 'SOMA_GANHO', 'MEDIA_PRIORIDADE', 'GANHO_MEDIO_FORMULA'],
            $topAgConfigs
        );

        $this->info('Parte 1 concluída.');
        $this->info('Iniciando Parte 2 - Comparação entre métodos...');

        $comparisonRows = [];

        foreach ($topAgConfigs as $index => $config) {
            $sumGain = 0;

            for ($simulation = 1; $simulation <= $simulations; $simulation++) {
                $problem = $problems[$simulation - 1];

                $result = $service->geneticAlgorithm(
                    $problem['processes'],
                    $problem['capacity'],
                    (int) $config['TP'],
                    (int) $config['NG'],
                    (float) $config['TC'],
                    (float) $config['TM'],
                    (float) $config['IG']
                );

                $sumGain += $result['evaluation']['total_priority'];
            }

            $averageGain = $sumGain / $simulations;

            $comparisonRows[] = [
                'METODO' => 'AG ' . ($index + 1),
                'CONFIGURACAO' => 'TP=' . $config['TP'] . '; NG=' . $config['NG'] . '; TC=' . $config['TC'] . '; TM=' . $config['TM'] . '; IG=' . $config['IG'],
                'SOMA_GANHO' => $sumGain,
                'MEDIA_PRIORIDADE' => $averageGain,
                'GANHO_MEDIO_FORMULA' => 100 * $averageGain,
            ];
        }

        $sumGain = 0;

        for ($simulation = 1; $simulation <= $simulations; $simulation++) {
            $problem = $problems[$simulation - 1];

            $initialSolution = $service->generateInitialSolution($problem['processes']);

            $result = $service->hillClimbing(
                $problem['processes'],
                $initialSolution,
                $problem['capacity']
            );

            $sumGain += $result['evaluation']['total_priority'];
        }

        $averageGain = $sumGain / $simulations;

        $comparisonRows[] = [
            'METODO' => 'SE',
            'CONFIGURACAO' => 'Configuração única',
            'SOMA_GANHO' => $sumGain,
            'MEDIA_PRIORIDADE' => $averageGain,
            'GANHO_MEDIO_FORMULA' => 100 * $averageGain,
        ];

        $sumGain = 0;
        $setAttempts = $n;

        for ($simulation = 1; $simulation <= $simulations; $simulation++) {
            $problem = $problems[$simulation - 1];

            $result = $service->hillClimbingWithAttempts(
                $problem['processes'],
                $problem['capacity'],
                $setAttempts
            );

            $sumGain += $result['evaluation']['total_priority'];
        }

        $averageGain = $sumGain / $simulations;

        $comparisonRows[] = [
            'METODO' => 'SET',
            'CONFIGURACAO' => '[N, N/2] = [' . $n . ', ' . intdiv($n, 2) . ']',
            'SOMA_GANHO' => $sumGain,
            'MEDIA_PRIORIDADE' => $averageGain,
            'GANHO_MEDIO_FORMULA' => 100 * $averageGain,
        ];

        $tsConfigs = [
            [2000, 0.1, 0.8],
            [2000, 0.01, 0.8],
            [2000, 0.1, 0.9],
            [2000, 0.01, 0.9],
        ];

        foreach ($tsConfigs as $config) {
            $sumGain = 0;

            for ($simulation = 1; $simulation <= $simulations; $simulation++) {
                $problem = $problems[$simulation - 1];

                $initialSolution = $service->generateInitialSolution($problem['processes']);

                $result = $service->simulatedAnnealing(
                    $problem['processes'],
                    $initialSolution,
                    $problem['capacity'],
                    $config[0],
                    $config[1],
                    $config[2]
                );

                $sumGain += $result['evaluation']['total_priority'];
            }

            $averageGain = $sumGain / $simulations;

            $comparisonRows[] = [
                'METODO' => 'TS',
                'CONFIGURACAO' => '[' . $config[0] . ', ' . $config[1] . ', ' . $config[2] . ']',
                'SOMA_GANHO' => $sumGain,
                'MEDIA_PRIORIDADE' => $averageGain,
                'GANHO_MEDIO_FORMULA' => 100 * $averageGain,
            ];
        }

        usort($comparisonRows, function ($a, $b) {
            return $b['GANHO_MEDIO_FORMULA'] <=> $a['GANHO_MEDIO_FORMULA'];
        });

        $this->writeCsv(
            $reportDir . '/comparativo_metodos.csv',
            ['METODO', 'CONFIGURACAO', 'SOMA_GANHO', 'MEDIA_PRIORIDADE', 'GANHO_MEDIO_FORMULA'],
            $comparisonRows
        );

        $this->info('Relatórios gerados com sucesso em:');
        $this->info($reportDir);

        return Command::SUCCESS;
    }

    private function writeCsv(string $path, array $headers, array $rows): void
    {
        $file = fopen($path, 'w');

        fputcsv($file, $headers, ';');

        foreach ($rows as $row) {
            fputcsv($file, $row, ';');
        }

        fclose($file);
    }
}