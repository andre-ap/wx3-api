# wx3-api

## Para rodar o projeto siga os passos:

1. Dentro da pasta /api, utilize o comando 'composer install' e em seguida 'composer dump-autoload'
2. Em seguinda, ainda na pasta /api, utilize o comando 'php -S localhost:8080 -t public/'.
3. Em seguida crie um banco de dados utilizando o script do arquivo 'bd.sql' da pasta /docs;
4. Utilize também o arquivo 'seed.sql' para popular o banco de dados.

## Referências:

- Slim Framework: https://www.slimframework.com/
- Kahlan: https://kahlan.github.io/docs/
- PHPStan: https://phpstan.org/

## Json pra testes:

#### Produtos: http://localhost:8080/api/produtos

```json
{
  "nome": "Camiseta Regata",
  "cor": "Preta",
  "imagem": "regata.jpg",
  "preco": 39.9,
  "descricao": "Camiseta regata leve.",
  "peso": 0.25,
  "categoriaId": 1
}
```

#### Categorias: http://localhost:8080/api/categorias

```json
{
  "nome": "Chapeus",
  "descricao": "Para colocar na cabeça"
}
```

#### Clientes: http://localhost:8080/api/clientes

```json
{
  "nomeCompleto": "Andre Teste",
  "cpf": "999.888.777-11",
  "dataNascimento": "1996-05-29
}
```

#### Endereços: http://localhost:8080/api/enderecos

```json
{
  "clienteId": 1,
  "logradouro": "Av Barao de Catangalo",
  "cidade": "Cantagalo",
  "bairro": "Centro",
  "numero": "46",
  "cep": "28500-000",
  "complemento": "Última casa"
}
```

#### Variações: http://localhost:8080/api/variacoes

```json
{
  "produtoId": 3,
  "tamanho": "G",
  "estoque": 50,
  "preco": 30.0
}
```

#### Pedidos: http://localhost:8080/api/produtos

```json
{
  "clienteId": 1,
  "enderecoEntregaId": 2,
  "formaPagamento": "PIX",
  "itens": [
    {
      "variacaoId": 3,
      "quantidade": 2
    },
    {
      "variacaoId": 2,
      "quantidade": 2
    }
  ]
}
```
