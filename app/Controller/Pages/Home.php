<?php

namespace App\Controller\Pages;

use App\Controller\Auth\Auth;
use App\Utils\View;
use App\Http\Response;

class Home extends Page
{
  
  /**
   * Método responsável por retornar o conteudo da /home
   *  
   * @return string
   */
  public static function getHome($request = null)
  {
    $obAuth = new Auth;
    $obAuth->setRequest($request);
    $obAuth->setParams();
    $obAuth->islogged();
    $obAuth->hasCode();

    //VIEW DA HOME      
    $content = View::render('pages/home', [
      "name"        => 'HOME',
      "description" => '',
      "error" => $obAuth->hasError()
    ]);


    //RETORNA A VIEW DA PAGINA
    return new Response(200, parent::getPage('Recicle Já', $content));
  }
}
