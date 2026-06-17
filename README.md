# Smart RAM Manager

Projeto acadêmico desenvolvido em Laravel para simular o gerenciamento de memória RAM de um servidor utilizando o problema da Mochila 0/1 e métodos heurísticos.

## Sobre o projeto

O sistema representa uma adaptação do problema da Mochila 0/1 no contexto de gerenciamento de memória RAM de um servidor.

A aplicação trabalha com uma lista de processos, onde cada processo possui um consumo de memória e uma prioridade. O objetivo é selecionar uma combinação de processos que maximize a prioridade total sem ultrapassar a quantidade de memória RAM disponível.

## Relação com o problema da mochila

Neste projeto, o problema da mochila foi adaptado da seguinte forma:

* Capacidade da mochila: memória RAM disponível no servidor;
* Peso do item: quantidade de RAM consumida por cada processo;
* Valor do item: prioridade do processo;
* Decisão: executar ou não executar determinado processo.

Como cada processo pode ser escolhido ou não escolhido, foi utilizada a abordagem da Mochila 0/1.

## Funcionalidades

O sistema possui uma interface principal com os seguintes menus:

* Métodos Básicos;
* Algoritmos Genéticos;
* Sobre.

### Métodos Básicos

Na tela de Métodos Básicos, é possível:

* Selecionar o tipo de execução: FIXO ou ALEATÓRIO;
* Informar o tamanho do problema;
* Gerar o problema;
* Gerar uma solução inicial;
* Executar métodos heurísticos;
* Visualizar os resultados na área de exibição.

### Algoritmos Genéticos

Na tela de Algoritmos Genéticos, é possível:

* Selecionar o tipo de execução: FIXO ou ALEATÓRIO;
* Informar o tamanho do problema;
* Gerar o problema;
* Informar os parâmetros do Algoritmo Genético;
* Executar o Algoritmo Genético;
* Visualizar a solução encontrada;
* Visualizar a memória utilizada;
* Visualizar a prioridade total obtida;
* Verificar se a solução é válida;
* Visualizar os processos escolhidos;
* Visualizar um histórico resumido das gerações.

Os parâmetros disponíveis para o Algoritmo Genético são:

* TP: tamanho da população;
* NG: número de gerações;
* TC: taxa de cruzamento;
* TM: taxa de mutação;
* IG: intervalo de geração / elitismo.

### Sobre

A tela Sobre apresenta a descrição do problema tratado na aplicação e os nomes dos discentes responsáveis pelo desenvolvimento.

## Métodos implementados

Foram implementados os seguintes métodos:

* Solução Inicial;
* Avaliação da solução;
* Subida de Encosta;
* Subida de Encosta com Tentativas;
* Têmpera Simulada;
* Algoritmo Genético;
* Análise Comparativa.

## Funcionamento dos métodos

### Solução Inicial

A solução inicial é representada por um vetor de 0 e 1.

Exemplo:

```text
[1, 0, 1, 0, 1]
```

Cada posição representa um processo:

* 1: processo selecionado;
* 0: processo não selecionado.

### Avaliação da solução

A avaliação calcula:

* Memória total utilizada;
* Prioridade total;
* Se a solução é válida ou não;
* Quais processos foram selecionados.

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

* TI: temperatura inicial;
* TF: temperatura final;
* FR: fator de redução da temperatura.

### Algoritmo Genético

O Algoritmo Genético trabalha com uma população de soluções candidatas. Cada indivíduo da população é representado por um vetor binário, onde cada posição indica se determinado processo será selecionado ou não.

Exemplo:

```text
[1, 0, 1, 0, 1]
```

Nesse exemplo, os processos das posições 1, 3 e 5 seriam selecionados.

O funcionamento geral do Algoritmo Genético implementado é:

1. Geração de uma população inicial aleatória;
2. Avaliação dos indivíduos da população;
3. Seleção de pais por torneio;
4. Cruzamento entre os pais de acordo com a taxa de cruzamento;
5. Mutação dos genes de acordo com a taxa de mutação;
6. Reparo de soluções inválidas para respeitar o limite de memória RAM;
7. Preservação de parte dos melhores indivíduos por meio do parâmetro IG;
8. Repetição do processo até atingir o número de gerações definido.

O objetivo do Algoritmo Genético é encontrar uma combinação de processos que maximize a prioridade total sem ultrapassar a capacidade de memória RAM disponível.

### Análise Comparativa

A Análise Comparativa executa diferentes configurações dos métodos e exibe uma tabela com os resultados.

No projeto, o campo "Ganho" representa a prioridade total obtida pela solução.

## Tecnologias utilizadas

* PHP;
* Laravel;
* Blade;
* HTML;
* CSS.

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

Caso esteja usando Linux ou macOS, utilize:

```bash
cp .env.example .env
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

```text
http://127.0.0.1:8000
```

## Como executar o módulo de Algoritmos Genéticos

1. Abra o sistema no navegador;
2. Acesse o menu "Algoritmos Genéticos";
3. Selecione o tipo de execução:

   * FIXO: utiliza um problema pré-definido;
   * ALEATÓRIO: gera um problema com a quantidade de processos informada.
4. Informe o tamanho do problema;
5. Clique em "Gerar Problema";
6. Informe os parâmetros:

   * TP: tamanho da população;
   * NG: número de gerações;
   * TC: taxa de cruzamento;
   * TM: taxa de mutação;
   * IG: intervalo de geração / elitismo.
7. Clique em "Executar Algoritmo Genético";
8. Verifique os resultados exibidos na tela.

Para a atividade da Prova 2, deve-se utilizar N = 50 nas execuções comparativas.

## Exemplo de problema fixo

No modo FIXO, o sistema utiliza o seguinte problema:

| Processo         | Memória | Prioridade |
| ---------------- | ------: | ---------: |
| Banco de Dados   |    4 GB |         10 |
| Servidor Web     |    2 GB |          7 |
| Backup           |    3 GB |          5 |
| Monitoramento    |    1 GB |          4 |
| Relatório pesado |    5 GB |          8 |

A capacidade de memória RAM disponível é de 8 GB.

## Exemplo de solução

Uma possível solução encontrada é:

```text
[1, 1, 0, 1, 0]
```

Essa solução seleciona:

* Banco de Dados;
* Servidor Web;
* Monitoramento.

Memória utilizada:

```text
4 + 2 + 1 = 7 GB
```

Prioridade total:

```text
10 + 7 + 4 = 21
```

Como a memória utilizada não ultrapassa 8 GB, a solução é válida.

## Observações

O projeto não utiliza banco de dados para persistência dos resultados. Os problemas e resultados são mantidos temporariamente durante a sessão da aplicação.

O módulo de Algoritmo Genético foi implementado para atender à Atividade Prática - Módulo II, incluindo campos de edição para os parâmetros TP, NG, TC, TM e IG, botão para gerar problema, botão para executar o algoritmo e área de exibição dos resultados.

## Autores

* André Ribeiro Rodrigues Batista
* Kauã Henrique Albertino do Carmo
