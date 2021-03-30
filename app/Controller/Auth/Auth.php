<?php

namespace App\Controller\Auth;

use App\Controller\Pages\Home;
use App\Utils\View;
use Exception;

class Auth
{
    private $request;
    private $params = [];

    private static function getFacebook()
    {
        return new \League\OAuth2\Client\Provider\Facebook([
            "clientId"       => getenv('FACEBOOK_clientId'),
            "clientSecret"    => getenv('FACEBOOK_clientSecret'),
            "redirectUri"     => getenv('FACEBOOK_redirectUri'),
            "graphApiVersion" => getenv('FACEBOOK_graphApiVersion')
        ]);
    }

    public static function sair(){
        session_destroy();
        header('location: '.getenv('URL_BASE'));
    }

    public static function getAuthUrl()
    {
        return self::getFacebook()->getAuthorizationUrl([
            "scope" => "email"
        ]);
    }

    public static function getHome($request)
    {
        return Home::getHome($request);
    }

    public function setRequest($request)
    {
        $this->request = $request;
    }

    public function setParams()
    {
        $this->params = !is_null($this->request) ? $this->request->getQueryParams() : [];
    }

    public function islogged()
    {
        if (!is_null($this->request)) {
            if (!isset($this->params['error']) && !isset($this->params['code'])) {
                header('location: ' . self::getAuthUrl());
                exit;
            }
        }
    }

    public function hasError()
    {
        if (isset($this->params['error'])) {
            $error = View::render(('pages/login/error'));
            return $error;
        }
        return '';
    }

    public function hasCode()
    {
        if (isset($this->params['code']) && empty($_SESSION['userLogged'])) {
            try {
                $token = self::getFacebook()->getAccessToken("authorization_code", ["code" => $this->params['code']]);
                $_SESSION['userLogged'] = self::getFacebook()->getResourceOwner($token);
                header('location: '.getenv('URL_BASE'));
                exit;
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }
    }
}   
