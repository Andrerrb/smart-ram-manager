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
            max-width: 900px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
        }

        h1, h2 {
            color: #222;
        }

        .summary {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            margin: 20px 0;
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th {
            background: #222;
            color: white;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 10px;
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
    </style>
</head>

<body>
    <div class="container">
        <h1>Resultado da Alocação de Memória</h1>

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
                        <tr>
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