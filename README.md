# wx3-api

## ⚠️ Código melhorado na branch v2
Várias melhorias no código foram feitas após o dia 10/07, como:
- Desacoplamento de classes;
- Injeção de dependências para uma rota mais limpa;
- Validação real de CPF;
- Autenticação simples utilizando JWT;
- Correção de bugs, repetição de código, etc.

Acesse: [Branch V2](https://github.com/andre-ap/wx3-api/tree/v2)

## Para rodar o projeto siga os passos:

1. Dentro da pasta /api, utilize o comando `composer install` e em seguida `composer dump-autoload`
2. Em seguinda, ainda na pasta /api, utilize o comando `php -S localhost:8080 -t public/`.
3. Em seguida crie um banco de dados utilizando o script do arquivo `bd.sql` da pasta /docs;
4. Utilize também o arquivo `seed.sql` para popular o banco de dados.
6. Edite o arquivo `.env` para o contexto do seu banco de dados.
7. Para rodar os testes usando Kahlan, basta usar o comando `composer test`
8. Para testar os end-points usando Postman, importe a collection `wx3_collection.postman_collection.json` da pasta /docs.

## Referências:

- PHP 8.2: https://www.php.net/
- MySQL 8.0 https://www.mysql.com/
- Slim Framework: https://www.slimframework.com/
- Kahlan: https://kahlan.github.io/docs/
- PHPStan: https://phpstan.org/
