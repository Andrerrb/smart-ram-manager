<!DOCTYPE html>
<html lang="pt-BR">
<head>

    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    
    <meta charset="UTF-8">

    <title>Sobre</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            padding: 40px;
        }

        .container {
            max-width: 850px;
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

        .info-box {
            background: #eef2ff;
            border-left: 5px solid #2563eb;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
            color: #333;
            line-height: 1.5;
        }

        ul {
            color: #555;
            line-height: 1.6;
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
        <h1>Sobre o Projeto</h1>

        <p>
            O Smart RAM Manager é uma aplicação acadêmica desenvolvida em Laravel
            para representar uma variação do problema da Mochila 0/1 aplicada ao
            gerenciamento de memória RAM de um servidor.
        </p>

        <div class="info-box">
            Neste problema, a memória RAM disponível representa a capacidade da mochila.
            Cada processo representa um item, possuindo um consumo de memória e uma prioridade.
            O objetivo é selecionar processos com a maior prioridade possível sem ultrapassar
            o limite de memória disponível.
        </div>

        <h2>Relação com a Mochila 0/1</h2>

        <ul>
            <li><strong>Capacidade:</strong> quantidade de memória RAM disponível.</li>
            <li><strong>Peso:</strong> memória consumida por cada processo.</li>
            <li><strong>Valor:</strong> prioridade de cada processo.</li>
            <li><strong>Decisão:</strong> executar ou não executar um processo.</li>
        </ul>

        <h2>Discente</h2>

        <ul>
            <li>André Ribeiro Rodrigues Batista</li>
            <li>Kauã Henrique Albertino do Carmo</li>
        </ul>

        <a href="{{ route('home') }}">Voltar</a>
    </div>
</body>
</html>