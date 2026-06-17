<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Algoritmos Genéticos - Smart RAM Manager</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            padding: 40px;
            color: #222;
        }

        .container {
            max-width: 1000px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
        }

        h1, h2, h3 {
            color: #222;
        }

        .description {
            background: #eef2ff;
            border-left: 5px solid #4f46e5;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .message {
            background: #dcfce7;
            border-left: 5px solid #16a34a;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .section {
            margin-top: 25px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        label {
            display: block;
            margin-top: 12px;
            font-weight: bold;
        }

        input, select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #bbb;
            border-radius: 5px;
        }

        button {
            margin-top: 18px;
            padding: 10px 15px;
            border: none;
            background: #2563eb;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background: #1d4ed8;
        }

        .back-link {
            display: inline-block;
            margin-top: 25px;
            color: white;
            background: #222;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
        }

        .back-link:hover {
            background: #444;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background: #f1f5f9;
        }

        .valid {
            color: #16a34a;
            font-weight: bold;
        }

        .invalid {
            color: #dc2626;
            font-weight: bold;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        @media (max-width: 700px) {
            .grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Algoritmos Genéticos</h1>

        <div class="description">
            Nesta tela é executado o Algoritmo Genético aplicado ao problema da Mochila 0/1.
            No contexto do projeto, cada processo representa um item, a memória representa o peso,
            a prioridade representa o valor, e a RAM disponível representa a capacidade máxima.
        </div>

        @if(session('message'))
            <div class="message">
                {{ session('message') }}
            </div>
        @endif

        <div class="section">
            <h2>Configuração do problema</h2>

            <form method="POST" action="{{ route('problem.generate') }}">
                @csrf

                <label for="execution_type">Tipo de execução:</label>
                <select name="execution_type" id="execution_type">
                    <option value="random">Fixo</option>
                    <option value="fixed">Aleatório</option>
                </select>

                <label for="problem_size">Tamanho do problema:</label>
                <input type="number" name="problem_size" id="problem_size" value="50" min="1">

                <small>
                    Para a atividade da Prova 2, use N = 50 no modo aleatório.
                    No modo fixo, o tamanho é ignorado.
                </small>

                <br>

                <button type="submit">Gerar Problema</button>
            </form>
        </div>

        <div class="section">
            <h2>Executar Algoritmo Genético</h2>

            <form method="POST" action="{{ route('method.execute') }}">
                @csrf

                <input type="hidden" name="method" value="genetic_algorithm">

                <div class="grid">
                    <div>
                        <label for="tp">TP - Tamanho da população:</label>
                        <input type="number" name="tp" id="tp" value="50" min="2">
                    </div>

                    <div>
                        <label for="ng">NG - Número de gerações:</label>
                        <input type="number" name="ng" id="ng" value="100" min="1">
                    </div>

                    <div>
                        <label for="tc">TC - Taxa de cruzamento:</label>
                        <input type="number" name="tc" id="tc" value="0.8" step="0.01" min="0" max="1">
                    </div>

                    <div>
                        <label for="tm">TM - Taxa de mutação:</label>
                        <input type="number" name="tm" id="tm" value="0.2" step="0.01" min="0" max="1">
                    </div>

                    <div>
                        <label for="ig">IG - Intervalo de geração / elitismo:</label>
                        <input type="number" name="ig" id="ig" value="0.1" step="0.01" min="0" max="1">
                    </div>
                </div>

                <button type="submit">Executar Algoritmo Genético</button>
            </form>
        </div>

        <div class="section">
            <h2>Área de exibição</h2>

            @if(session('problem'))
                @php
                    $problem = session('problem');
                @endphp

                <h3>Problema gerado</h3>

                <p><strong>Capacidade da RAM:</strong> {{ $problem['capacity'] }} GB</p>
                <p><strong>Quantidade de processos:</strong> {{ count($problem['processes']) }}</p>

                <table>
                    <thead>
                        <tr>
                            <th>Processo</th>
                            <th>Memória</th>
                            <th>Prioridade</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($problem['processes'] as $process)
                            <tr>
                                <td>{{ $process['name'] }}</td>
                                <td>{{ $process['memory'] }} GB</td>
                                <td>{{ $process['priority'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>Nenhum problema foi gerado ainda.</p>
            @endif

            @if(session('method_result'))
                @php
                    $methodResult = session('method_result');
                    $methodEvaluation = $methodResult['evaluation'];
                @endphp

                <h3>Resultado do Algoritmo Genético</h3>

                <p><strong>Método executado:</strong> {{ $methodResult['method'] }}</p>
                <p><strong>Solução encontrada:</strong> [{{ implode(', ', $methodResult['solution']) }}]</p>
                <p><strong>Memória usada:</strong> {{ $methodEvaluation['used_memory'] }} GB</p>
                <p><strong>Prioridade total:</strong> {{ $methodEvaluation['total_priority'] }}</p>

                <p>
                    <strong>Solução válida:</strong>
                    @if($methodEvaluation['is_valid'])
                        <span class="valid">Sim</span>
                    @else
                        <span class="invalid">Não</span>
                    @endif
                </p>

                <p><strong>Gerações executadas:</strong> {{ $methodResult['iterations'] }}</p>

                @if(isset($methodResult['parameters']))
                    <h3>Parâmetros utilizados</h3>

                    <table>
                        <thead>
                            <tr>
                                <th>TP</th>
                                <th>NG</th>
                                <th>TC</th>
                                <th>TM</th>
                                <th>IG</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $methodResult['parameters']['population_size'] }}</td>
                                <td>{{ $methodResult['parameters']['generations'] }}</td>
                                <td>{{ $methodResult['parameters']['crossover_rate'] }}</td>
                                <td>{{ $methodResult['parameters']['mutation_rate'] }}</td>
                                <td>{{ $methodResult['parameters']['generation_interval'] }}</td>
                            </tr>
                        </tbody>
                    </table>
                @endif

                @if(count($methodEvaluation['selected_processes']) > 0)
                    <h3>Processos escolhidos pelo Algoritmo Genético</h3>

                    <table>
                        <thead>
                            <tr>
                                <th>Processo</th>
                                <th>Memória</th>
                                <th>Prioridade</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($methodEvaluation['selected_processes'] as $process)
                                <tr>
                                    <td>{{ $process['name'] }}</td>
                                    <td>{{ $process['memory'] }} GB</td>
                                    <td>{{ $process['priority'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif

                @if(isset($methodResult['history']) && count($methodResult['history']) > 0)
                    <h3>Histórico resumido das gerações</h3>

                    <table>
                        <thead>
                            <tr>
                                <th>Geração</th>
                                <th>Melhor ganho até a geração</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(array_slice($methodResult['history'], -10) as $history)
                                <tr>
                                    <td>{{ $history['generation'] }}</td>
                                    <td>{{ $history['best_gain'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <small>
                        Exibindo apenas as 10 últimas gerações para não poluir a tela.
                    </small>
                @endif
            @endif
        </div>

        <a class="back-link" href="{{ route('home') }}">Voltar</a>
    </div>
</body>

</html>