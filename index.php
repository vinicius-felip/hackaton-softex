<?php

require __DIR__ . "/vendor/autoload.php";

use App\Http\Router;
use App\Utils\View;

define('URL_BASE', 'http://localhost/hackaton');


View::init([
    'URL_BASE' => URL_BASE
]);


$obRouter = new Router(URL_BASE);

//INCLUE AS ROTAS DE PÁGINAS
include_once __DIR__."/routes/pages.php";

//IMPRIME RESPONSE DA ROTA
$obRouter->run()->sendResponse();


