<?php

namespace App\Http;

class Response
{

    /**
     * Código do Status HTTP
     *
     * @var int
     */
    private $httpCode = 200;


    /**
     * Cabeçalho do Response
     *
     * @var array
     */
    private $headers = [];

    /**
     * Tipo de conteúdo
     *
     * @var string
     */
    private $contentType = 'text/html';

    /**
     * Contéudo do Response
     *
     * @var mixed
     */
    private $content;

    /**
     * Método responsável por iniciar a classe com valores
     *
     * @param  integer $httpCode
     * @param  mixed $content
     * @param  string $contentType
     */
    public function __construct($httpCode, $content, $contentType = 'text/html')
    {
        $this->httpCode = $httpCode;
        $this->content  = $content;
        $this->setContentType($contentType);
    }

    /**
     * Método responsável por alterar o ContentType do Response
     *
     * @param  mixed $contentType
     * @return void
     */
    public function setContentType($contentType)
    {
        $this->contentType = $contentType;
        $this->addHeader('Content-Type', $contentType);
    }

    /**
     * Método responsável por adicionar um registro no cabeçalho de response
     *
     * @param  string $key
     * @param  string $value
     * @return void
     */
    public function addHeader($key, $value)
    {
        $this->headers[$key] = $value;
    }

    /**
     * Método responsável por enviar os headers para o navegador
     *
     * @return void
     */
    private function sendHeaders()
    {
        //STATUS
        http_response_code($this->httpCode);

        //ENVIAR HEADERS
        foreach ($this->headers as $key => $value) {
            header($key . ': ' . $value);
        }
    }

    /**
     * Método responsável por enviar a resposta para o usuário
     *
     */
    public function sendResponse()
    {
        //ENVIA OS HEADERS
        $this->sendHeaders();

        //IMPRIME CONTEUDO
        switch ($this->contentType) {
            case 'text/html':
                echo $this->content;
                break;
        }
    }
}
