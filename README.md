# wx3-api

## Para rodar o projeto siga os passos:

1. Dentro da pasta /api, utilize o comando `composer install` e em seguida `composer dump-autoload`
2. Em seguinda, ainda na pasta /api, utilize o comando `php -S localhost:8080 -t public/`.
3. Em seguida crie um banco de dados utilizando o script do arquivo `bd.sql` da pasta /docs;
4. Utilize também o arquivo `seed.sql` para popular o banco de dados.
6. Edite o arquivo `.env` para o contexto do seu banco de dados.
7. Para rodar os testes usando Kahlan, basta usar o comando `composer test`
8. Para testar o end-points usando Postman, importe a collection `wx3_collection.postman_collection.json` da pasta /docs.

## Referências:

- PHP 8.2: https://www.php.net/
- MariaDB 10.4 https://mariadb.org/
- Slim Framework: https://www.slimframework.com/
- Kahlan: https://kahlan.github.io/docs/
- PHPStan: https://phpstan.org/
