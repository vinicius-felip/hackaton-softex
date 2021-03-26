<?php

use App\Controller\Pages;
use App\Http\Response;

//ROTA HOME
$obRouter->get('/', [fn () => Pages\Home::getHome()]);

//ROTA SOBRE
$obRouter->get('/sobre', [fn () => Pages\About::getAbout()]);
