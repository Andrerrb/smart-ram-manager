<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

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
            margin-bottom: 10px;
        }

        p {
            color: #555;
            line-height: 1.5;
        }

        .menu {
            margin-top: 30px;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .menu a {
            display: block;
            background: #222;
            color: white;
            text-decoration: none;
            padding: 25px;
            border-radius: 8px;
            text-align: center;
            font-weight: bold;
        }

        .menu a:hover {
            background: #444;
        }

        .info-box {
            background: #eef2ff;
            border-left: 5px solid #2563eb;
            padding: 15px;
            margin-top: 20px;
            border-radius: 5px;
            color: #333;
            line-height: 1.5;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Smart RAM Manager</h1>

        <p>
            Aplicação acadêmica para resolver uma variação do problema da Mochila 0/1,
            usando o gerenciamento de memória RAM de um servidor como contexto.
        </p>

        <div class="info-box">
            Na adaptação do problema, a memória RAM disponível representa a capacidade da mochila.
            Cada processo possui um consumo de memória e uma prioridade. O objetivo é selecionar
            os processos mais importantes sem ultrapassar a memória disponível.
        </div>

        <div class="menu">
            <a href="{{ route('basic.methods') }}">Métodos Básicos</a>

            <a href="{{ route('genetic.algorithms') }}">Algoritmos Genéticos</a>

            <a href="{{ route('about') }}">Sobre</a>
        </div>
    </div>
</body>
</html>