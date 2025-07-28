<?php

namespace Src\DAO;

use PDO;

class LoginDAO implements LoginDAOInterface
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function login(string $cpf): mixed
    {
        $sql = "SELECT * FROM funcionarios WHERE cpf = :cpf";
        $ps = $this->pdo->prepare($sql);

        $ps->execute([
            ":cpf" => $cpf
        ]);

        $funcionarioEncontrado = $ps->fetch(PDO::FETCH_ASSOC);

        if (!$funcionarioEncontrado) {
            http_response_code(401);
            exit();
        }

        return $funcionarioEncontrado;
    }
}
