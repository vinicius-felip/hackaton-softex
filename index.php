<?php

require __DIR__ . "/vendor/autoload.php";

use App\Http\Router;
use App\Model\Common\Environment;
use App\Utils\View;

Environment::load(__DIR__);

define('URL_BASE', getenv('URL_BASE'));


View::init([
    'URL_BASE' => URL_BASE
]);


$obRouter = new Router(URL_BASE);

//INCLUE AS ROTAS DE PÁGINAS
include_once __DIR__."/routes/pages.php";

//IMPRIME RESPONSE DA ROTA
$obRouter->run()->sendResponse();


