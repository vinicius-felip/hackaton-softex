<?php

namespace App\Controller\Auth;

use App\Controller\Pages\Home;
use App\Utils\View;
use Exception;

class Auth
{    
    /**
     * Instância de Reqquest
     *
     * @var Request
     */
    private $request;
        
    /**
     * Parâmetros de GET
     *
     * @var array
     */
    private $params = [];
    
    /**
     * Método responsável por realizar a conexão com o app do facebook
     *
     * @return Facebook
     */
    private static function getFacebook()
    {
        return new \League\OAuth2\Client\Provider\Facebook([
            "clientId"       => getenv('FACEBOOK_clientId'),
            "clientSecret"    => getenv('FACEBOOK_clientSecret'),
            "redirectUri"     => getenv('FACEBOOK_redirectUri'),
            "graphApiVersion" => getenv('FACEBOOK_graphApiVersion')
        ]);
    }
    
    /**
     * Método responsável por desautenticar o usuário
     *
     */
    public static function sair()
    {
        session_destroy();
        header('location: ' . getenv('URL_BASE'));
    }
    
    /**
     * Método responsável por receber a url de autenticação
     *
     * @return void
     */
    public static function getAuthUrl()
    {
        return self::getFacebook()->getAuthorizationUrl([
            "scope" => "email"
        ]);
    }
    
    /**
     * Método responsável por retornar a /home
     *
     * @param  Request $request
     */
    public static function getHome($request)
    {
        return Home::getHome($request);
    }
    
    /**
     * Método responsável por definir a Request para verificação do objeto
     *
     * @param  Request $request
     */
    public function setRequest($request)
    {
        $this->request = $request;
    }
    
    /**
     * Método responsável por definir os parâmetros de autenticação
     *
     */
    public function setParams()
    {
        $this->params = !is_null($this->request) ? $this->request->getQueryParams() : [];
    }
    
    /**
     * Método responsável por saber se o houve a tentativa de autenticação
     *
     */
    public function islogged()
    {
        if (!is_null($this->request)) {
            if (!isset($this->params['error']) && !isset($this->params['code'])) {
                header('location: ' . self::getAuthUrl());
                exit;
            }
        }
    }
    
    /**
     * Método responsável por saber retornar o usuario para o erro
     *
     * @return string
     */
    public function hasError()
    {
        if (isset($this->params['error'])) {
            $error = View::render(('pages/login/error'));
            return $error;
        }
        return '';
    }
    
    /**
     * Método responsável por saber se o usuario conseguiu se autenticar
     *
     */
    public function hasCode()
    {
        if (isset($this->params['code']) && empty($_SESSION['userLogged'])) {
            try {
                $token = self::getFacebook()->getAccessToken("authorization_code", ["code" => $this->params['code']]);
                $_SESSION['userLogged'] = self::getFacebook()->getResourceOwner($token);
                header('location: ' . getenv('URL_BASE'));
                exit;
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }
    }
    
    /**
     * Método responsável por impedir usuario de acessar areas restritas
     *
     * @return void
     */
    public static function logged()
    {
        if (!isset($_SESSION['userLogged'])) {
            header('location: ' . URL_BASE);
            exit;
        }
    }
}
