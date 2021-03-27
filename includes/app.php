<?php

require __DIR__ . "/../vendor/autoload.php";

use App\Model\Common\Environment;
use App\Utils\View;

//CARREGA AS VARIAVÉIS DE AMBIENTE
Environment::load(__DIR__.'/../');

//DEFINE A A URL_BASE
define('URL_BASE', getenv('URL_BASE'));

//DEFINE  O VALOR PADRÃO DAS VARIÁVEIS
View::init([
    'URL_BASE' => URL_BASE
]);