# Laravel_API

Uma API feita em Laravel

## By Matheose

Estudo feito na BeerAndCode

Quando se inicia esse projeto não tem a pasta vendor então executar esse comando.
Sem a pasta vendor não se consegue executar o sail.
E por conta do git a pasta vendor não versionado.

~~~shell
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs
~~~

Subindo o docker com sail
~~~shell
./vendor/bin/sail up
~~~

Executando as migrations
~~~shell
./vendor/bin/sail artisan migrate --seed
~~~

## Alteração no docker-compose

~~~bash
pgsql:
    image: 'postgres:15'
    ports:
        - '${FORWARD_DB_PORT:-5432}:5432'
    environment:
        PGPASSWORD: '${DB_PASSWORD:-secret}'
        POSTGRES_DB: '${DB_DATABASE:-modulo_11}'
        POSTGRES_USER: '${DB_USERNAME:-sail}'
        POSTGRES_PASSWORD: '${DB_PASSWORD:-secret}'
    volumes:
        - 'sail-pgsql:/var/lib/postgresql/data'
        - './vendor/laravel/sail/database/pgsql/create-testing-database.sql:/docker-entrypoint-initdb.d/10-create-testing-database.sql'
    networks:
        - sail
    healthcheck:
        test:
            - CMD
            - pg_isready
            - '-q'
            - '-d'
            - '${DB_DATABASE}'
            - '-U'
            - '${DB_USERNAME}'
        retries: 3
        timeout: 5s
~~~

No arquivo .env precisei acrescentar as linhas.
~~~bash
WWWGROUP=1000
WWWUSER=1000
~~~

Sobre o Banco de dados Postgres.
No meu notebook não precicei fazer nada.
Em outro PC eu precisei criar o usuario sail e executar esse escript.

~~~bash
root@085d603868cc:/# psql -U sail -d modulo_11
psql: error: connection to server on socket "/var/run/postgresql/.s.PGSQL.5432" failed: FATAL:  role "sail" does not exist
root@085d603868cc:/# psql -U postgres 
psql (15.7 (Debian 15.7-1.pgdg120+1))
Type "help" for help.

postgres=# CREATE USER sail WITH PASSWORD 'password';
CREATE ROLE
postgres=# CREATE DATABASE modulo_11;
CREATE DATABASE
postgres=# GRANT ALL PRIVILEGES on DATABASE modulo_11 TO sail;
GRANT
postgres=# \q

GRANT USAGE ON SCHEMA public TO sail;
GRANT CREATE ON SCHEMA public TO sail;
\c modulo_11
CREATE TABLE public.test_table (
    id serial PRIMARY KEY,
    name varchar(255) NOT NULL
);
ALTER DATABASE modulo_11 OWNER TO sail;
ALTER SCHEMA public OWNER TO sail;
~~~


## Criando controlers

~~~bash
./vendor/bin/sail artisan make:controller ClientController -m Client --request --api
~~~

## API Resource

Encapsula o retorno da API.
Consegue mudar o formato do retorno da API.

~~~bash
./vendor/bin/sail artisan make:resource ClientResource
~~~

Esse Resource devolve as informações assim:
~~~json
{
	"data": {
		"name": "Robson Bueno",
		"email": "robson.bueno@gmail.com",
		"created_at": "2024-08-06"
	}
}
~~~

Se pode mudar esse data, para isso e so criar uma variavel static na
ClientResource.php

~~~php
class ClientResource extends JsonResource
{
    public static $wrap = 'comida';

    ...
}
~~~

Se quiser remover o data.
Dentro de app/Providers/AppServiceProvider.php, dentro do metodo boot
Se tiver usando o paginate e usado o data.

~~~PHP
public function boot(): void
{
    JsonResource::withoutWrapping();
}
~~~

~~~shell
./vendor/bin/sail artisan make:resource ClientCollection    
~~~