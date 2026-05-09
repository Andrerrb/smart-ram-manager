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
            max-width: 950px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
        }

        h1 {
            color: #222;
            margin-bottom: 10px;
        }

        h2 {
            color: #222;
            margin-top: 30px;
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

        .form-group {
            margin-top: 20px;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 8px;
        }

        .capacity-input {
            max-width: 180px;
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
            text-align: left;
        }

        input {
            width: 95%;
            padding: 8px;
            border: 1px solid #bbb;
            border-radius: 4px;
        }

        .actions {
            margin-top: 20px;
            display: flex;
            gap: 10px;
        }

        button {
            padding: 12px 20px;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        .btn-add {
            background: #2563eb;
        }

        .btn-add:hover {
            background: #1d4ed8;
        }

        .btn-calculate {
            background: #16a34a;
        }

        .btn-calculate:hover {
            background: #15803d;
        }

        .btn-remove {
            background: #dc2626;
            padding: 8px 12px;
        }

        .btn-remove:hover {
            background: #b91c1c;
        }

        .error {
            background: #ffe0e0;
            padding: 10px;
            border: 1px solid #ff9999;
            margin-bottom: 15px;
            border-radius: 5px;
        }

        .footer-note {
            margin-top: 25px;
            font-size: 14px;
            color: #666;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Smart RAM Manager</h1>

        <p>
            Este sistema simula o gerenciamento de memória RAM de um servidor usando
            o problema da Mochila 0/1.
        </p>

        <div class="info-box">
            <strong>Como funciona:</strong>
            a RAM disponível representa a capacidade da mochila. Cada processo consome
            uma quantidade de memória e possui uma prioridade. O algoritmo escolhe a
            melhor combinação possível sem ultrapassar o limite informado.
        </div>

        @if ($errors->any())
            <div class="error">
                <strong>Erro:</strong> verifique os dados informados.
            </div>
        @endif

        <form action="{{ route('memory.calculate') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Memória RAM disponível:</label>
                <input class="capacity-input" type="number" name="capacity" value="8" required>
                <span>GB</span>
            </div>

            <h2>Processos</h2>

            <table>
                <thead>
                    <tr>
                        <th>Nome do processo</th>
                        <th>Memória necessária em GB</th>
                        <th>Prioridade</th>
                        <th>Ação</th>
                    </tr>
                </thead>

                <tbody id="process-list">
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
                        <td>
                            <button type="button" class="btn-remove" onclick="removeProcess(this)">Remover</button>
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
                        <td>
                            <button type="button" class="btn-remove" onclick="removeProcess(this)">Remover</button>
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
                        <td>
                            <button type="button" class="btn-remove" onclick="removeProcess(this)">Remover</button>
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
                        <td>
                            <button type="button" class="btn-remove" onclick="removeProcess(this)">Remover</button>
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
                        <td>
                            <button type="button" class="btn-remove" onclick="removeProcess(this)">Remover</button>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="actions">
                <button type="button" class="btn-add" onclick="addProcess()">Adicionar processo</button>

                <button type="submit" class="btn-calculate">Calcular melhor alocação</button>
            </div>
        </form>

        <p class="footer-note">
            Cada processo pode ser escolhido ou não escolhido, por isso foi usada a abordagem
            da Mochila 0/1.
        </p>
    </div>

    <script>
        function addProcess() {
            const processList = document.getElementById('process-list');

            const newRow = document.createElement('tr');

            newRow.innerHTML = `
                <td>
                    <input type="text" name="names[]" placeholder="Nome do processo">
                </td>
                <td>
                    <input type="number" name="memories[]" placeholder="Memória em GB">
                </td>
                <td>
                    <input type="number" name="priorities[]" placeholder="Prioridade">
                </td>
                <td>
                    <button type="button" class="btn-remove" onclick="removeProcess(this)">Remover</button>
                </td>
            `;

            processList.appendChild(newRow);
        }

        function removeProcess(button) {
            button.closest('tr').remove();
        }
    </script>
</body>
</html>