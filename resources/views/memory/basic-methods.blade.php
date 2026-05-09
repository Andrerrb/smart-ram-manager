<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">

    <title>Métodos Básicos - Smart RAM Manager</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            padding: 40px;
        }

        .container {
            max-width: 1000px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
        }

        h1, h2, h3, h4 {
            color: #222;
        }

        p {
            color: #555;
            line-height: 1.5;
        }

        .info-box {
            background: #eef2ff;
            border-left: 5px solid #2563eb;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
            color: #333;
            line-height: 1.5;
        }

        .message {
            background: #ecfdf5;
            border-left: 5px solid #16a34a;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
            color: #333;
        }

        .form-section {
            margin-top: 25px;
            padding: 20px;
            background: #f9fafb;
            border-radius: 8px;
            border: 1px solid #ddd;
        }

        .form-row {
            display: flex;
            gap: 20px;
            margin-bottom: 15px;
            align-items: center;
            flex-wrap: wrap;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 6px;
        }

        input, select {
            padding: 8px;
            border: 1px solid #bbb;
            border-radius: 4px;
            min-width: 180px;
        }

        button {
            padding: 10px 16px;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            margin-right: 8px;
            margin-top: 8px;
        }

        .btn-blue {
            background: #2563eb;
        }

        .btn-blue:hover {
            background: #1d4ed8;
        }

        .btn-green {
            background: #16a34a;
        }

        .btn-green:hover {
            background: #15803d;
        }

        .btn-dark {
            background: #222;
        }

        .btn-dark:hover {
            background: #444;
        }

        .result-area {
            margin-top: 25px;
            padding: 20px;
            background: #f1f1f1;
            border-radius: 8px;
            min-height: 120px;
        }

        .valid {
            color: #15803d;
            font-weight: bold;
        }

        .invalid {
            color: #b91c1c;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            margin-bottom: 20px;
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

        a {
            display: inline-block;
            margin-top: 20px;
            color: white;
            background: #222;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
        }

        a:hover {
            background: #444;
        }

        .small-note {
            font-size: 14px;
            color: #666;
            margin-top: 5px;
        }

        .method-result {
            background: #fff;
            border-left: 5px solid #222;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Métodos Básicos</h1>

        <p>
            Nesta tela são executados os métodos básicos aplicados ao problema da Mochila 0/1,
            usando o contexto de gerenciamento de memória RAM de um servidor.
        </p>

        <div class="info-box">
            Cada processo representa um item da mochila. A memória consumida pelo processo
            representa o peso, e a prioridade representa o valor. A memória RAM disponível
            representa a capacidade máxima da mochila.
        </div>

        @if(session('message'))
            <div class="message">
                {{ session('message') }}
            </div>
        @endif

        <div class="form-section">
            <h2>Configuração do problema</h2>

            <form action="{{ route('problem.generate') }}" method="POST">
                @csrf

                <div class="form-row">
                    <div>
                        <label>Tipo de execução:</label>
                        <select name="execution_type">
                            <option value="fixed">FIXO</option>
                            <option value="random">ALEATÓRIO</option>
                        </select>
                    </div>

                    <div>
                        <label>Tamanho do problema:</label>
                        <input type="number" name="problem_size" value="5" min="1">

                        <p class="small-note">
                            No modo FIXO, o tamanho é ignorado. No modo ALEATÓRIO,
                            ele define quantos processos serão gerados.
                        </p>
                    </div>
                </div>

                <button type="submit" class="btn-blue">Gerar Problema</button>
            </form>
        </div>

        <div class="form-section">
            <h2>Solução inicial</h2>

            <form action="{{ route('solution.initial') }}" method="POST">
                @csrf

                <p>
                    Gera uma solução inicial para o problema, indicando quais processos começam
                    selecionados ou não selecionados.
                </p>

                <button type="submit" class="btn-green">Solução Inicial</button>
            </form>
        </div>

        <div class="form-section">
            <h2>Executar método</h2>

            <form action="{{ route('method.execute') }}" method="POST">
                @csrf

                <div class="form-row">
                    <div>
                        <label>Método:</label>
                        <select name="method">
                            <option value="hill_climbing">Subida de Encosta</option>
                            <option value="hill_climbing_attempts">Subida de Encosta com Tentativas</option>
                            <option value="simulated_annealing">Têmpera Simulada</option>
                            <option value="comparative_analysis">Análise Comparativa</option>
                        </select>
                    </div>

                    <div>
                        <label>TMAX:</label>
                        <input type="number" name="tmax" value="10">
                    </div>

                    <div>
                        <label>TI:</label>
                        <input type="number" name="ti" value="100">
                    </div>

                    <div>
                        <label>TF:</label>
                        <input type="number" name="tf" value="0.1" step="0.1">
                    </div>

                    <div>
                        <label>FR:</label>
                        <input type="number" name="fr" value="0.8" step="0.1">
                    </div>
                </div>

                <button type="submit" class="btn-dark">Executar</button>
            </form>
        </div>

        <div class="result-area">
            <h2>Área de exibição</h2>

            @if(session('problem'))
                @php
                    $problem = session('problem');
                @endphp

                <h3>Problema gerado</h3>

                <p>
                    <strong>Capacidade da RAM:</strong> {{ $problem['capacity'] }} GB
                </p>

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

            @if(session('initial_solution') && session('initial_evaluation'))
                @php
                    $solution = session('initial_solution');
                    $evaluation = session('initial_evaluation');
                @endphp

                <h3>Solução inicial</h3>

                <p>
                    <strong>Vetor solução:</strong>
                    [{{ implode(', ', $solution) }}]
                </p>

                <p>
                    <strong>Memória usada:</strong> {{ $evaluation['used_memory'] }} GB
                </p>

                <p>
                    <strong>Prioridade total:</strong> {{ $evaluation['total_priority'] }}
                </p>

                <p>
                    <strong>Solução válida:</strong>

                    @if($evaluation['is_valid'])
                        <span class="valid">Sim</span>
                    @else
                        <span class="invalid">Não</span>
                    @endif
                </p>

                @if(count($evaluation['selected_processes']) > 0)
                    <h4>Processos selecionados</h4>

                    <table>
                        <thead>
                            <tr>
                                <th>Processo</th>
                                <th>Memória</th>
                                <th>Prioridade</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($evaluation['selected_processes'] as $process)
                                <tr>
                                    <td>{{ $process['name'] }}</td>
                                    <td>{{ $process['memory'] }} GB</td>
                                    <td>{{ $process['priority'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            @endif

            @if(session('method_result'))
                @php
                    $methodResult = session('method_result');
                @endphp

                <div class="method-result">
                    <h3>Resultado do método</h3>

                    <p>
                        <strong>Método executado:</strong>
                        {{ $methodResult['method'] }}
                    </p>

                    @if(isset($methodResult['comparison_results']))
                        <h4>Tabela de análise comparativa</h4>

                        <table>
                            <thead>
                                <tr>
                                    <th>Método</th>
                                    <th>Observação</th>
                                    <th>Ganho</th>
                                    <th>Memória usada</th>
                                    <th>Solução</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($methodResult['comparison_results'] as $comparison)
                                    <tr>
                                        <td>{{ $comparison['method'] }}</td>
                                        <td>{{ $comparison['observation'] }}</td>
                                        <td>{{ $comparison['gain'] }}</td>
                                        <td>{{ $comparison['used_memory'] }} GB</td>
                                        <td>[{{ implode(', ', $comparison['solution']) }}]</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <h4>Melhor resultado encontrado</h4>

                        <p>
                            <strong>Método:</strong>
                            {{ $methodResult['best_result']['method'] }}
                        </p>

                        <p>
                            <strong>Observação:</strong>
                            {{ $methodResult['best_result']['observation'] }}
                        </p>

                        <p>
                            <strong>Ganho:</strong>
                            {{ $methodResult['best_result']['gain'] }}
                        </p>

                        <p>
                            <strong>Memória usada:</strong>
                            {{ $methodResult['best_result']['used_memory'] }} GB
                        </p>

                        <p>
                            <strong>Solução:</strong>
                            [{{ implode(', ', $methodResult['best_result']['solution']) }}]
                        </p>
                    @else
                        @php
                            $methodEvaluation = $methodResult['evaluation'];
                        @endphp

                        <p>
                            <strong>Solução encontrada:</strong>
                            [{{ implode(', ', $methodResult['solution']) }}]
                        </p>

                        <p>
                            <strong>Memória usada:</strong>
                            {{ $methodEvaluation['used_memory'] }} GB
                        </p>

                        <p>
                            <strong>Prioridade total:</strong>
                            {{ $methodEvaluation['total_priority'] }}
                        </p>

                        <p>
                            <strong>Solução válida:</strong>

                            @if($methodEvaluation['is_valid'])
                                <span class="valid">Sim</span>
                            @else
                                <span class="invalid">Não</span>
                            @endif
                        </p>

                        <p>
                            <strong>Iterações:</strong>
                            {{ $methodResult['iterations'] }}
                        </p>

                        @if(isset($methodResult['attempts']))
                            <p>
                                <strong>Tentativas:</strong>
                                {{ $methodResult['attempts'] }}
                            </p>
                        @endif

                        @if(isset($methodResult['temperature']))
                            <p>
                                <strong>TI:</strong>
                                {{ $methodResult['temperature']['initial'] }}
                            </p>

                            <p>
                                <strong>TF:</strong>
                                {{ $methodResult['temperature']['final'] }}
                            </p>

                            <p>
                                <strong>FR:</strong>
                                {{ $methodResult['temperature']['cooling_rate'] }}
                            </p>
                        @endif

                        @if(count($methodEvaluation['selected_processes']) > 0)
                            <h4>Processos escolhidos pelo método</h4>

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
                    @endif
                </div>
            @endif
        </div>

        <a href="{{ route('home') }}">Voltar</a>
    </div>
</body>
</html>