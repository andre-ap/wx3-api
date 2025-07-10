<?php

namespace Src\DAO;

use DateTime;
use Exception;
use PDO;
use Src\Model\Categoria;

class CategoriaDAO
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @return Categoria[]
     */
    public function buscarCategorias(): array
    {
        $sql = "SELECT id, nome, descricao FROM categorias";

        $ps = $this->pdo->query($sql);

        if (!$ps) {
            throw new Exception("SQL mal formatada ou erro ao executar");
        }

        $dados = $ps->fetchAll(PDO::FETCH_ASSOC);

        $categorias = [];

        foreach ($dados as $linha) {
            $categorias[] = new Categoria(
                id: $linha["id"],
                nome: $linha["nome"],
                descricao: $linha["descricao"]
            );
        }

        return $categorias;
    }

    /**
     * @param int $id
     * @return Categoria | array<void>
     */
    public function buscarCategoriaPorId(int $id): Categoria | array
    {
        $sql = "SELECT id, nome, descricao FROM categorias
        WHERE id = :id";

        $ps = $this->pdo->prepare($sql);

        $ps->execute(['id' => $id]);

        $dados = $ps->fetch(PDO::FETCH_ASSOC);

        if (!$dados) {
            return [];
        }

        return new Categoria(
            id: $dados["id"],
            nome: $dados["nome"],
            descricao: $dados["descricao"]
        );;
    }


    public function criarNovaCategoria(Categoria $categoria): int
    {
        $sql = "INSERT into categorias (nome, descricao)
        VALUES (:nome, :descricao)";

        $ps = $this->pdo->prepare($sql);

        $ps->execute([
            ":nome" => $categoria->nome,
            ":descricao" => $categoria->descricao
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    /**
     * @param int $id
     * @param array{
     * nome: string,
     * descricao: string 
     * } $dados
     */
    public function atualizarCategoria(int $id, array $dados): int
    {
        $sql = "UPDATE categorias SET nome = :nome, descricao = :descricao
                WHERE id = :id";

        $ps = $this->pdo->prepare($sql);

        $ps->execute([
            ':nome' => $dados['nome'],
            ':descricao' => $dados['descricao'],
            ':id' => $id
        ]);

        return $id;
    }

    /**
     * @param int $id
     * @return int
     */
    public function removerItemPorID(int $id): int
    {
        $sql = "DELETE FROM categorias WHERE id = :id";

        $ps = $this->pdo->prepare($sql);

        $ps->execute([':id' => $id]);

        return $id;
    }
}
