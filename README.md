Alonso Engenharia
==================================

## Dependências #

Para rodar o projeto local é necessário apenas o *Docker* instalado na máquina.

## Como Rodar? ##

Primeiro precisamos configurar o arquivo .env com as configurações do banco.

Crie um arquivo chamado .env na raiz do projeto (pasta application) e copie o conteúdo do arquivo .env.example para dentro dele. Depois disso, precisamos alterar algumas informações dentro do arquivo criado. São elas:

```
DB_HOST=alonso-engenharia-mysql
DB_PORT=3306
DB_DATABASE=alonso_engenharia
DB_USERNAME=root
DB_PASSWORD=root
```

Agora é necessário criar uma rede para o nosso projeto e subir os containers do docker. Abra o terminal e entre no diretório do projeto clonado. Depois digite o comando:

`docker network create alonso.engenharia`

`docker compose up -d`

Após rodar esses comandos, será necessário entrar no container em que o PHP está rodando para poder executar alguns outros comandos. No mesmo terminal, entre o comando:

`docker exec -it alonso-engenharia-php-fpm bash`

O terminal irá mudar e passará a ser o terminal de dentro do container. Agora, basta rodar os comandos abaixo em sequência para poder subir o banco de dados (Migrate) e popular algumas tabelas que são necessárias (Seeder):

`cd application`

`composer install`

`php artisan key:generate`

`php artisan migrate`

`php artisan db:seed`

Pronto! O ambiente agora está certo para rodar o projeto.