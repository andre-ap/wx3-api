<?php

namespace Src\Controller;

use PDO;
use Src\Service\ClienteService;
use Src\Model\Cliente;

class ClienteController
{

    private ClienteService $service;

    public function __construct(PDO $pdo)
    {
        $this->service = new ClienteService($pdo);
    }

    /**
     * @return Cliente[]
     */
    public function listar()
    {
        return $this->service->listarClientes();
    }

    /**
     * @param int $id
     * @return Cliente | null
     */
    public function buscar(int $id): Cliente | null
    {
        return $this->service->buscarClientePorID($id);
    }

    /**
     * @param array{
     *  nomeCompleto: string, 
     *  cpf: string,
     *  dataNascimento: string
     * } $dados
     * @return int
     */
    public function criar(array $dados): int
    {
        return $this->service->criarNovoCliente($dados);
    }

    /**
     * @param int $id
     * @param array{
     *  nomeCompleto: string, 
     *  cpf: string,
     *  dataNascimento: string
     * } $dados
     * @return int
     */
    public function atualizar(int $id, array $dados): int
    {
        return $this->service->atualizarCliente($id, $dados);
    }

    /**
     * @param int $id
     * @return int
     */
    public function remover(int $id): int
    {
        return $this->service->removerCliente($id);
    }
}
