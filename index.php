<?php

require_once __DIR__.'/includes/app.php';

use App\Http\Router;

$obRouter = new Router(URL_BASE);

//INCLUE AS ROTAS DE PÁGINAS
include_once __DIR__."/includes/routes/pages.php";

//IMPRIME RESPONSE DA ROTA
$obRouter->run()->sendResponse();


