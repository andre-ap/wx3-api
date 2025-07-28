<?php

namespace Src\DAO;

interface LoginDAOInterface
{
    public function login(string $cpf): mixed;
}
