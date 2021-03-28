<?php

use App\Controller\Pages;
use App\Http\Response;

//ROTA HOME
$obRouter->get('/', [fn () => Pages\Home::getHome()]);

//ROTA SOBRE
$obRouter->get('/sobre', [fn () => Pages\About::getAbout()]);

//ROTA INSERIR MARCADOR (view)
$obRouter->get('/inserir', [fn () => Pages\Insert::getMarker()]);

//ROTA INSERIR MARCADOR (insert)
$obRouter->post('/inserir', [fn ($request) => Pages\Insert::insertMarker($request)]);

//ROTA RECEBER MARCADOR (view)
$obRouter->get('/admin', [fn () => Pages\Admin::getMarker()]);

//ROTA UPDATE MARCADOR (insert)
$obRouter->post('/admin', [fn ($request) => Pages\Admin::updateMarker($request)]);

