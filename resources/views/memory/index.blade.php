<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">

    <title>Smart RAM Manager</title>

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

        h1 {
            color: #222;
        }

        p {
            color: #555;
            line-height: 1.5;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th {
            background: #222;
            color: white;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 10px;
        }

        input {
            width: 95%;
            padding: 8px;
        }

        button {
            margin-top: 20px;
            padding: 12px 20px;
            background: #222;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        button:hover {
            background: #444;
        }

        .error {
            background: #ffe0e0;
            padding: 10px;
            border: 1px solid #ff9999;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Smart RAM Manager</h1>

        <p>
            Este sistema simula o gerenciamento de memória RAM de um servidor usando
            o problema da Mochila 0/1. Cada processo possui um consumo de memória e uma
            prioridade. O objetivo é escolher os processos mais importantes sem ultrapassar
            a memória disponível.
        </p>

        @if ($errors->any())
            <div class="error">
                <strong>Erro:</strong> verifique os dados informados.
            </div>
        @endif

        <form action="{{ route('memory.calculate') }}" method="POST">
            @csrf

            <label>Memória RAM disponível:</label>
            <input type="number" name="capacity" value="8" required>
            <span>GB</span>

            <h2>Processos</h2>

            <table>
                <thead>
                    <tr>
                        <th>Nome do processo</th>
                        <th>Memória necessária em GB</th>
                        <th>Prioridade</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>
                            <input type="text" name="names[]" value="Banco de Dados">
                        </td>
                        <td>
                            <input type="number" name="memories[]" value="4">
                        </td>
                        <td>
                            <input type="number" name="priorities[]" value="10">
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <input type="text" name="names[]" value="Servidor Web">
                        </td>
                        <td>
                            <input type="number" name="memories[]" value="2">
                        </td>
                        <td>
                            <input type="number" name="priorities[]" value="7">
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <input type="text" name="names[]" value="Backup">
                        </td>
                        <td>
                            <input type="number" name="memories[]" value="3">
                        </td>
                        <td>
                            <input type="number" name="priorities[]" value="5">
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <input type="text" name="names[]" value="Monitoramento">
                        </td>
                        <td>
                            <input type="number" name="memories[]" value="1">
                        </td>
                        <td>
                            <input type="number" name="priorities[]" value="4">
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <input type="text" name="names[]" value="Relatório pesado">
                        </td>
                        <td>
                            <input type="number" name="memories[]" value="5">
                        </td>
                        <td>
                            <input type="number" name="priorities[]" value="8">
                        </td>
                    </tr>
                </tbody>
            </table>

            <button type="submit">Calcular melhor alocação</button>
        </form>
    </div>
</body>
</html>