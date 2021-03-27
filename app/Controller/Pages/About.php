<?php

namespace App\Controller\Pages;

use App\Http\Response;
use App\Utils\View;


class About extends Page{
    
    /**
     * Método responsável por retornar o conteudo da /About
     *  
     * @return string
     */
    public static function getAbout(){
      //VIEW DA SOBRE
      
      $content = View::render('pages/sobre',[
        "name"        => 'SOBRE',
        "description" => ''
      ]);


      //RETORNA A VIEW DA PAGINA
      return new Response(200, parent::getPage('TITULO', $content));
    }
}