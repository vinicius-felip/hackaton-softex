<?php

namespace App\Controller\Pages;

use App\Utils\View;
use App\Http\Response;


class Home extends Page{
    
    /**
     * Método responsável por retornar o conteudo da /home
     *  
     * @return string
     */
    public static function getHome(){
      //VIEW DA HOME      
      $content = View::render('pages/home',[
        "name"        => 'HOME',
        "description" => '',
      ]);


      //RETORNA A VIEW DA PAGINA
      return new Response(200, parent::getPage('TITULO', $content));
    } 

}