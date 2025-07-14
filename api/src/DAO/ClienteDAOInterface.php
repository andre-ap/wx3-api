<?php

namespace Src\DAO;

use Src\Model\Cliente;

interface ClienteDAOInterface
{
    /** @return Cliente[] */
    public function listarClientes(): array;

    public function buscarClientePorID(int $id): Cliente | null;

    public function criarNovoCliente(Cliente $cliente): int;

    public function atualizarCliente(int $id, array $dados): int;

    public function removerCliente(int $id): int;

    public function verificarCliente(string $cpf): bool;
}
