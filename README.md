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