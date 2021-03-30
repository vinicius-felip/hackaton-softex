<?php

require __DIR__ . "/vendor/autoload.php";

use App\Http\Router;


define('URL', 'http://localhost/hackaton-softex\index.php');

$obRouter = new Router(URL);

//INCLUE AS ROTAS DE PÁGINAS
include_once __DIR__."/routes/pages.php";

//IMPRIME RESPONSE DA ROTA
$obRouter->run()->sendResponse();


