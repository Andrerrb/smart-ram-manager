# Smart RAM Manager

Projeto acadêmico desenvolvido em Laravel para simular o gerenciamento de memória RAM de um servidor utilizando o problema da Mochila 0/1.

## Sobre o projeto

O sistema recebe uma quantidade de memória RAM disponível e uma lista de processos. Cada processo possui um consumo de memória e uma prioridade.

Com base nesses dados, o algoritmo escolhe a melhor combinação de processos para maximizar a prioridade total sem ultrapassar a memória disponível.

## Relação com o problema da mochila

Neste projeto, o problema da mochila foi adaptado da seguinte forma:

- Capacidade da mochila: memória RAM disponível no servidor
- Peso do item: quantidade de RAM consumida por cada processo
- Valor do item: prioridade do processo
- Decisão: executar ou não executar determinado processo

Como cada processo pode ser escolhido ou não escolhido, foi utilizada a abordagem da Mochila 0/1.

## Tecnologias utilizadas

- PHP 8.4.21
- Laravel 13.7
- Blade 
- HTML
- CSS

## Como executar o projeto

Clone o repositório:

```bash
git clone https://github.com/Andrerrb/smart-ram-manager.git
```

Entre na pasta do projeto:

```bash
cd smart-ram-manager
```

Instale as dependências:

```bash
composer install
```

Crie o arquivo `.env`:

```bash
copy .env.example .env
```

Gere a chave da aplicação:

```bash
php artisan key:generate
```

Execute o servidor:

```bash
php artisan serve
```

Acesse no navegador:

```txt
http://127.0.0.1:8000
```

## Exemplo de uso

Com 8 GB de RAM disponível, o sistema pode analisar processos como:

| Processo | Memória | Prioridade |
|---|---:|---:|
| Banco de Dados | 4 GB | 10 |
| Servidor Web | 2 GB | 7 |
| Backup | 3 GB | 5 |
| Monitoramento | 1 GB | 4 |
| Relatório pesado | 5 GB | 8 |

O algoritmo seleciona a combinação que gera a maior prioridade possível sem ultrapassar o limite de memória.

## Autor

André Ribeiro Rodrigues Batista | Kauã Henrique Albertino do Carmo