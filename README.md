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