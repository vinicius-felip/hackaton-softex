<?php

require_once __DIR__.'/includes/app.php';

use App\Http\Router;

session_start();

$obRouter = new Router(URL_BASE);

//INCLUE AS ROTAS DE PÁGINAS
include_once __DIR__."/includes/routes/pages.php";

//IMPRIME RESPONSE DA ROTA
$obRouter->run()->sendResponse();
