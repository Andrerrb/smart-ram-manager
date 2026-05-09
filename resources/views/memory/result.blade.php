<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">

    <title>Resultado - Smart RAM Manager</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            padding: 40px;
        }

        .container {
            max-width: 950px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
        }

        h1, h2 {
            color: #222;
        }

        p {
            color: #555;
            line-height: 1.5;
        }

        .summary {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            margin: 25px 0;
        }

        .card {
            background: #f1f1f1;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
        }

        .card strong {
            display: block;
            font-size: 24px;
            margin-top: 8px;
        }

        .memory-bar {
            background: #e5e7eb;
            height: 25px;
            border-radius: 20px;
            overflow: hidden;
            margin: 15px 0 25px 0;
        }

        .memory-used {
            background: #2563eb;
            height: 100%;
            color: white;
            text-align: center;
            line-height: 25px;
            font-size: 14px;
        }

        .result-box {
            background: #ecfdf5;
            border-left: 5px solid #16a34a;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
            color: #333;
            line-height: 1.5;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            margin-bottom: 25px;
        }

        th {
            background: #222;
            color: white;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }

        .selected-row {
            background: #f0fdf4;
        }

        a {
            display: inline-block;
            margin-top: 10px;
            color: white;
            background: #222;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
        }

        a:hover {
            background: #444;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Resultado da Alocação de Memória</h1>

        <p>
            O algoritmo analisou os processos informados e escolheu a melhor combinação
            possível de acordo com a memória RAM disponível e a prioridade de cada processo.
        </p>

        <div class="summary">
            <div class="card">
                RAM total
                <strong>{{ $capacity }} GB</strong>
            </div>

            <div class="card">
                RAM usada
                <strong>{{ $result['used_memory'] }} GB</strong>
            </div>

            <div class="card">
                RAM livre
                <strong>{{ $result['available_memory'] }} GB</strong>
            </div>

            <div class="card">
                Prioridade total
                <strong>{{ $result['max_priority'] }}</strong>
            </div>
        </div>

        @php
            $usedPercentage = 0;

            if ($capacity > 0) {
                $usedPercentage = ($result['used_memory'] / $capacity) * 100;
            }
        @endphp

        <h2>Uso da memória</h2>

        <div class="memory-bar">
            <div class="memory-used" style="width: {{ $usedPercentage }}%;">
                {{ number_format($usedPercentage, 1) }}%
            </div>
        </div>

        <div class="result-box">
            <strong>Resultado:</strong>
            foram usados {{ $result['used_memory'] }} GB de {{ $capacity }} GB disponíveis.
            A prioridade total alcançada foi {{ $result['max_priority'] }}.
        </div>

        <h2>Processos escolhidos pelo algoritmo</h2>

        @if(count($result['selected_processes']) > 0)
            <table>
                <thead>
                    <tr>
                        <th>Processo</th>
                        <th>Memória necessária</th>
                        <th>Prioridade</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($result['selected_processes'] as $process)
                        <tr class="selected-row">
                            <td>{{ $process['name'] }}</td>
                            <td>{{ $process['memory'] }} GB</td>
                            <td>{{ $process['priority'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>Nenhum processo pôde ser alocado.</p>
        @endif

        <h2>Todos os processos informados</h2>

        <table>
            <thead>
                <tr>
                    <th>Processo</th>
                    <th>Memória necessária</th>
                    <th>Prioridade</th>
                </tr>
            </thead>

            <tbody>
                @foreach($processes as $process)
                    <tr>
                        <td>{{ $process['name'] }}</td>
                        <td>{{ $process['memory'] }} GB</td>
                        <td>{{ $process['priority'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <a href="/">Voltar</a>
    </div>
</body>
</html>