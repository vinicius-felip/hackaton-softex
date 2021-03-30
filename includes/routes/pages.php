<?php

use App\Controller\Auth\Auth;
use App\Controller\Pages;


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

//ROTA AUTENTICAÇÃO FACEBOOK
$obRouter->get('/facebook', [fn ($request) => Auth::getHome($request)]);

//ROTA SAIR FACEBOOK
$obRouter->get('/sair', [fn () => Auth::sair()]);
