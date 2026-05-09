# Smart RAM Manager

Projeto acadêmico desenvolvido em Laravel para simular o gerenciamento de memória RAM de um servidor utilizando o problema da Mochila 0/1 e métodos heurísticos.

## Sobre o projeto

O sistema representa uma adaptação do problema da Mochila 0/1 no contexto de gerenciamento de memória RAM de um servidor.

A aplicação trabalha com uma lista de processos, onde cada processo possui um consumo de memória e uma prioridade. O objetivo é selecionar uma combinação de processos que maximize a prioridade total sem ultrapassar a quantidade de memória RAM disponível.

## Relação com o problema da mochila

Neste projeto, o problema da mochila foi adaptado da seguinte forma:

- Capacidade da mochila: memória RAM disponível no servidor;
- Peso do item: quantidade de RAM consumida por cada processo;
- Valor do item: prioridade do processo;
- Decisão: executar ou não executar determinado processo.

Como cada processo pode ser escolhido ou não escolhido, foi utilizada a abordagem da Mochila 0/1.

## Funcionalidades

O sistema possui uma interface principal com os seguintes menus:

- Métodos Básicos;
- Algoritmos Genéticos;
- Sobre.

### Métodos Básicos

Na tela de Métodos Básicos, é possível:

- Selecionar o tipo de execução: FIXO ou ALEATÓRIO;
- Informar o tamanho do problema;
- Gerar o problema;
- Gerar uma solução inicial;
- Executar métodos heurísticos;
- Visualizar os resultados na área de exibição.

### Algoritmos Genéticos

O menu Algoritmos Genéticos exibe a mensagem:

```txt
Módulo em desenvolvimento.
```

### Sobre

A tela Sobre apresenta a descrição do problema tratado na aplicação e os nomes dos discentes responsáveis pelo desenvolvimento.

## Métodos implementados

Foram implementados os seguintes métodos:

- Solução Inicial;
- Avaliação da solução;
- Subida de Encosta;
- Subida de Encosta com Tentativas;
- Têmpera Simulada;
- Análise Comparativa.

## Funcionamento dos métodos

### Solução Inicial

A solução inicial é representada por um vetor de 0 e 1.

Exemplo:

```txt
[1, 0, 1, 0, 1]
```

Cada posição representa um processo:

- 1: processo selecionado;
- 0: processo não selecionado.

### Avaliação da solução

A avaliação calcula:

- Memória total utilizada;
- Prioridade total;
- Se a solução é válida ou não;
- Quais processos foram selecionados.

Caso a memória utilizada ultrapasse a capacidade disponível, a solução é considerada inválida e recebe prioridade total igual a 0.

### Subida de Encosta

O método de Subida de Encosta parte de uma solução inicial e tenta melhorar a solução alterando uma posição do vetor por vez.

A cada iteração, o algoritmo procura uma solução vizinha com maior prioridade total, desde que ela respeite o limite de memória RAM disponível.

### Subida de Encosta com Tentativas

A Subida de Encosta com Tentativas executa o método de Subida de Encosta várias vezes, partindo de soluções iniciais diferentes.

O parâmetro TMAX representa a quantidade máxima de tentativas.

### Têmpera Simulada

A Têmpera Simulada também busca melhorar a solução, mas pode aceitar uma solução pior em alguns momentos para tentar escapar de ótimos locais.

Os parâmetros utilizados são:

- TI: temperatura inicial;
- TF: temperatura final;
- FR: fator de redução da temperatura.

### Análise Comparativa

A Análise Comparativa executa diferentes configurações dos métodos e exibe uma tabela com os resultados.

No projeto, o campo "Ganho" representa a prioridade total obtida pela solução.

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

## Exemplo de problema fixo

No modo FIXO, o sistema utiliza o seguinte problema:

| Processo | Memória | Prioridade |
|---|---:|---:|
| Banco de Dados | 4 GB | 10 |
| Servidor Web | 2 GB | 7 |
| Backup | 3 GB | 5 |
| Monitoramento | 1 GB | 4 |
| Relatório pesado | 5 GB | 8 |

A capacidade de memória RAM disponível é de 8 GB.

## Exemplo de solução

Uma possível solução encontrada é:

```txt
[1, 1, 0, 1, 0]
```

Essa solução seleciona:

- Banco de Dados;
- Servidor Web;
- Monitoramento.

Memória utilizada:

```txt
4 + 2 + 1 = 7 GB
```

Prioridade total:

```txt
10 + 7 + 4 = 21
```

Como a memória utilizada não ultrapassa 8 GB, a solução é válida.

## Autores

- André Ribeiro Rodrigues Batista
- Kauã Henrique Albertino do Carmo