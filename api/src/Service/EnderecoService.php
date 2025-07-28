<?php

namespace Src\Service;

use Src\DAO\EnderecoDAOInterface;
use Src\Exception\EnderecoException;
use Src\Model\Endereco;

class EnderecoService
{
    private EnderecoDAOInterface $dao;

    public function __construct(EnderecoDAOInterface $dao)
    {
        $this->dao = $dao;
    }

    /**
     * @return Endereco[] | null
     */
    public function listarEnderecos(): array | null
    {
        return $this->dao->listarEnderecos();
    }

    /**
     * @param int $id
     * @return Endereco|null
     */
    public function buscarEnderecoPorId(int $id): Endereco | null
    {
        $this->validarId($id);

        return $this->dao->buscarEnderecoPorId($id);
    }

    /**
     * @param array{
     * clienteId: int,
     * logradouro: string,
     * cidade: string,
     * bairro: string,
     * numero: string,
     * cep: string,
     * complemento: string
     * } $dados
     * @return int
     */
    public function criarNovoEndereco(array $dados): int
    {
        $this->validarDados($dados);

        return $this->dao->criarNovoEndereco($dados);
    }

    /**
     * @param int $id
     * @param array{
     * logradouro: string,
     * cidade: string,
     * bairro: string,
     * numero: string,
     * cep: string,
     * complemento: string,
     * clienteId: int
     * } $dados
     * @return int
     */
    public function atualizarEndereco(int $id, array $dados): int
    {
        $this->validarId($id);
        $this->validarDados($dados);

        return $this->dao->atualizarEndereco($id, $dados);
    }

    public function removerEnderecoPorId(int $id): int
    {
        $this->validarId($id);

        return $this->dao->removerEnderecoPorId($id);
    }

    public function validarId(int $id): void
    {
        if ($id <= 0) {
            throw EnderecoException::idInvalido();
        }

        if (!$this->dao->buscarEnderecoPorId($id)) {
            throw EnderecoException::enderecoNaoEncontrado();
        }
    }
    /**
     * @param array{
     *  clienteId: int,
     *  logradouro: string,
     *  cidade: string,
     *  bairro: string,
     *  numero: string,
     *  cep: string,
     *  complemento?: string
     * } $dados
     * @throws EnderecoException
     * @return void
     */
    public function validarDados(array $dados): void
    {
        if ($dados['clienteId'] <= 0) {
            throw EnderecoException::clienteIdInvalido();
        }

        if (empty($dados['logradouro']) || strlen($dados['logradouro']) < 3) {
            throw EnderecoException::logradouroInvalido();
        }

        if (empty($dados['cidade']) || strlen($dados['cidade']) < 3) {
            throw EnderecoException::cidadeInvalida();
        }

        if (empty($dados['bairro']) || strlen($dados['bairro']) < 3) {
            throw EnderecoException::bairroInvalido();
        }

        if (empty($dados['numero'])) {
            throw EnderecoException::numeroInvalido();
        }

        if (empty($dados['cep'])) {
            throw EnderecoException::cepInvalido();
        }

        if (!isset($dados['complemento'])) {
            throw EnderecoException::complementoInvalido();
        }
    }
}
