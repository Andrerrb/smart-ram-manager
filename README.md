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