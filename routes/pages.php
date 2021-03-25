<?php

use App\Http\Response;
use App\Controller\Pages;

//ROTA HOME
$obRouter->get('/', [
    fn () => new Response(200, Pages\Home::getHome())
]);

