<?php

namespace App\Controller\Pages;

use App\Controller\Auth\Auth;
use App\Utils\View;
use App\Http\Response;
use App\Model\Entity\Marker;

class Admin extends Page
{

  /**
   * Método responsável por retornar o conteudo da /inserir
   *  
   * @return string
   */
  public static function getMarker()
  {
    //VERIFICAR SE ADMIN ESTÁ LOGADO
    Auth::logged();

    //VIEW DA MARKER

    $content = View::render('pages/admin', []);

    //RETORNA A VIEW DA PAGINA
    return new Response(200, parent::getPage('Recicle Já', $content));
  }

  /**
   * Método responsável por atualizar um marcador no bando de dados
   *
   * @param  Request $request
   * @return string
   */
  public static function updateMarker($request)
  {

    //DADOS POST
    $postVars = $request->getPostVars();

    //NOVA INSTANCIA DE MARKER
    $obMarker = new Marker;
    $obMarker->id = $postVars['id'];
    $obMarker->status = $postVars['status'];

    //ATUALIZAR
    $obMarker->updateMarker();

    return new Response(200, 'Concluido');
  }

    /**
   * Método responsável por atualizar um marcador no bando de dados
   *
   * @param  Request $request
   * @return string
   */
  public static function deleteMarker($request)
  {

    //DADOS POST
    $postVars = $request->getPostVars();

    //NOVA INSTANCIA DE MARKER
    $obMarker = new Marker;
    $obMarker->id = $postVars['id'];

    //ATUALIZAR
    $obMarker->deleteMarker();

    return new Response(200, 'Concluido');
  }
}
