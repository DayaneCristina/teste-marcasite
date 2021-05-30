Alonso Engenharia
==================================

## Dependências #

Para rodar o projeto local é necessário apenas o *Docker* instalado na máquina.

## Como Rodar? ##

Primeiro é necessário subir os containers do docker do projeto. Abra o terminal e entre no diretório do projeto clonado. Depois digite o comando:

`docker compose up -d`

Após rodar esse comando, será necessário entrar no container em que o PHP está rodando para poder executar alguns outros comandos. No mesmo terminal, entre o comando:

`php exec -it alonso-engenharia-php-fpm bash`

O terminal irá mudar e passará a ser o terminal de dentro do container. Agora, basta rodar os comandos abaixo em sequência para poder subir o banco de dados (Migrate) e popular algumas tabelas que são necessárias (Seeder):

`cd application`

`composer install`

`php artisan migrate`

`php artisan db:seed`

Pronto! O ambiente agora está certo para rodar o projeto.