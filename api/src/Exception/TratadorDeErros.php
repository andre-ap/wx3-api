<?php

namespace src\exception;

use Exception;

class TratadorDeErros extends Exception
{
    /**
     * @var string[]|array<string>
     */
    private $erros = [];

    /**
     * @param string $message
     * @param int $code
     * @param string[] $erros
     */
    public function __construct(string $message, int $code = 500, array $erros = [])
    {
        $this->erros = $erros;
        parent::__construct($message, $code);
    }

    /**
     * @return string[]
     */
    public function getErros():array
    {
        return $this->erros;
    }
}
